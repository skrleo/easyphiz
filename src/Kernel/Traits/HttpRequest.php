<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 13:59:04
 */

namespace PhizPay\Kernel\Traits;

use GuzzleHttp\Client;

/*
 * @author: Rio
 * @Date: 2024-04-29 13:59:04
 */

trait HttpRequest
{
    /**
     * @var \GuzzleHttp\ClientInterface
     */
    protected $httpClient;

    public function httpClient()
    {
        return (new Client());
    }

    /**
     * 发送请求
     */
    public function request($url, $method = 'GET', $options = [])
    {
        $method = strtoupper($method);

        if (property_exists($this, 'baseUri') && !is_null($this->baseUri)) {
            $options['base_uri'] = $this->baseUri;
        }

        $response = $this->httpClient()->request($method, $url, $options);
        $response->getBody()->rewind();

        return $response;
    }
}