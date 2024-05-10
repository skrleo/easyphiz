<?php
/*
 * @author: Rio
 * @Date: 2024-05-08 17:18:38
 */
namespace PhizPay\Kernel\Contracts;

interface ConfigInterface
{

    public function get($key);


    public function set($key, $value);
}