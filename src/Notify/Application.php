<?php
/*
 * @author: Rio
 * @Date: 2024-08-26 10:30:08
 */

namespace PhizPay\Notify;

use PhizPay\Kernel\AesUtil;
use PhizPay\Kernel\BaseService;
use PhizPay\Kernel\Exceptions\InvalidArgumentException;

class Application extends BaseService
{
    const AES_KEY = "a7cde1ZJB1kG2e7VfTs3jQzaWizur8Gb";  // 32字节的密钥

    /**
     * 支付回调参数解析
     *
     * @param array $args
     * @return mixed
     * @throws InvalidArgumentException
     */
    public function paid($args)
    {
        if (empty($args)) {
            throw new InvalidArgumentException('args is required', 500);
        }

        if ($args['summary'] != "SUCCESS") {
            throw new InvalidArgumentException('callback notify failed', 500);
        }

        $args = json_decode(json_encode($args), true);
        if (empty($resource = $args['resource'])) {
            throw new InvalidArgumentException('resource is empty', 500);
        }

        $result = (new AesUtil(self::AES_KEY))->decryptToString($resource['associated_data'], $resource['nonce'], $resource['ciphertext']);
        return $result;
    }

    public function refund(array $args) {}
}
