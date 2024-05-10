<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 10:56:52
 */

namespace PhizPay\Kernel;

/**
 * AbstractConfig类
 */
abstract class AbstractConfig
{
    protected $config;

    /**
     * Constructs a new instance of the class.
     *
     * @param array $config The configuration array.
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }
}