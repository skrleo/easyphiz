<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 10:56:52
 */
namespace PhizPay\Kernel;

use PhizPay\Kernel\Contracts\ConfigInterface;
use PhizPay\Kernel\Support\Str;

class BaseService extends AbstractConfig implements ConfigInterface
{

    /**
     * Retrieves a value from the configuration array.
     *
     * @param string|int $key The key to retrieve from the configuration array.
     * @param mixed $default The default value to return if the key is not found in the configuration array.
     * @return mixed The value associated with the given key in the configuration array, or the default value if the key is not found.
     */
    public function get($key, $default = null)
    {
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return $default;
    }

    /**
     * Sets a value in the configuration array.
     *
     * @param mixed $key The key to set in the configuration array.
     * @param mixed $value The value to associate with the key in the configuration array.
     * @return void
     */
    public function set($key, $value)
    {
        $this->config[$key] = $value;
    }

    /**
     * Sends a request to the specified URL with the given method and body.
     *
     * @param string $url The URL to send the request to.
     * @param string $method The HTTP method to use (default: 'GET').
     * @param array $body The request body (default: array()).
     * @throws None
     * @return string The response body.
     */
    public function request(string $url, string $method = 'GET', array $body = array())
    {
        if ($method !== 'GET') {
            $body = array_merge($body, array(
                'mchid' => $this->config['mchid'],
                'appid' => $this->config['appid'],
            ));
        }

        $ch = curl_init();

        list($nonceStr, $timestamp, $signature) = $this->configSignature($url, $method, $body);

        $headers = $this->getHeaders($signature, $nonceStr, $timestamp);

        // 判断是测试环境还是正式环境
        $baseUrl = $this->config['is_debug'] ? 'https://pay-dev.xyue.zip:10443' : 'https://payment.phiz.chat';

        curl_setopt($ch, CURLOPT_URL, $baseUrl . $url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body, true));
        }

        //判断当前是不是有post数据的发
        $output = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        curl_close($ch);

        return substr($output, $headerSize);
    }

    /**
     * Generates the signature for an API request.
     *
     * @param string|null $url The URL for the request.
     * @param string $method The HTTP method for the request. Default is 'GET'.
     * @param array $body The request body. Default is an empty array.
     * @param string|null $nonce The nonce for the request. If not provided, a random string will be generated.
     * @param string|null $timestamp The timestamp for the request. If not provided, the current time will be used.
     * @return array An array containing the nonce, timestamp, and the base64-encoded signature.
     */
    protected function configSignature(string $url = null, string $method = 'GET', array $body = [], string $nonce = null, string $timestamp = null): array
    {
        $timestamp = $timestamp ?: time();
        $nonceStr = $nonce ?: Str::random(32);

        $signData = implode("\n", array(
            $method,
            $method === 'GET' ? explode("?", $url)[0] : $url,
            $timestamp,
            $nonceStr,
            $method ==='GET' ? "\n" : json_encode($body, true) . "\n"
        ));

        $fileContent = file_get_contents($this->config['cert_path']);
        $privateKey = openssl_pkey_get_private($fileContent);

        $encryptedData = '';
        openssl_sign($signData, $encryptedData, $privateKey, OPENSSL_ALGO_SHA256);
        return array($nonceStr, $timestamp, base64_encode($encryptedData));
    }

    /**
     * Generates the headers for an API request.
     *
     * @param string|null $signature The signature for the request.
     * @param string|null $nonce The nonce for the request.
     * @param string|null $timestamp The timestamp for the request.
     * @return array The headers for the API request.
     */
    protected function getHeaders(string $signature = null, string $nonce = null, string $timestamp = null): array
    {
        $data = array(
            'mchid' => $this->config['mchid'],
            'nonce_str' => $nonce,
            'signature' => $signature,
            'timestamp' => $timestamp,
            'serial_no' => $this->config['serial_no'],
        );

        $string = '';
        foreach($data as $k => $v) {
            $string .= $k . '="' . $v . '",';
        }

        return array(
            'Content-Type:application/json',
            'Authorization:Phizpay2-SHA256-RSA2048 ' . rtrim($string, ',')
        );
    }
}