<?php

namespace PhizPay\Kernel;

use Exception;
use InvalidArgumentException;

class AesUtil
{
    const KEY_LENGTH_BYTE = 32;  // 32字节，256位
    const TAG_LENGTH_BIT = 128;  // GCM认证标签长度

    private $aesKey;

    public function __construct($key)
    {
        if (strlen($key) !== self::KEY_LENGTH_BYTE) {
            throw new InvalidArgumentException("AES key must be 32 bytes long");
        }
        $this->aesKey = $key;
    }

    /**
     * 解密AES-GCM加密的字符串
     *
     * @param string $associatedData 附加数据
     * @param string $nonce 随机数 (IV)
     * @param string $ciphertext 密文 (Base64编码)
     * @return string 解密后的明文
     * @throws Exception
     */
    public function decryptToString($associatedData, $nonce, $ciphertext)
    {
        // 将Base64密文解码为二进制
        $ciphertextBinary = base64_decode($ciphertext);

        // 获取密文的长度，后16字节是Tag
        $ciphertextLength = strlen($ciphertextBinary);
        if ($ciphertextLength < 16) {
            throw new Exception("Ciphertext is too short");
        }

        // 分离Tag和密文
        $tag = substr($ciphertextBinary, -16);
        $ciphertextWithoutTag = substr($ciphertextBinary, 0, $ciphertextLength - 16);

        // 设置解密模式为AES-256-GCM
        $cipher = "aes-256-gcm";

        // 使用openssl进行解密
        $decrypted = openssl_decrypt(
            $ciphertextWithoutTag,
            $cipher,
            $this->aesKey,
            OPENSSL_RAW_DATA,
            $nonce,
            $tag,
            $associatedData
        );

        if ($decrypted === false) {
            throw new Exception("Decryption failed");
        }

        return $decrypted;
    }
}
