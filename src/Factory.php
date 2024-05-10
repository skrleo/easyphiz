<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 10:02:10
 */
namespace PhizPay;

class Factory
{
    /**
     * Creates a new instance of the specified application.
     *
     * @param mixed $name The name of the application.
     * @param array $config The configuration array for the application.
     * @return mixed The newly created application instance.
     */
    public static function make($name, array $config)
    {
        $namespace = ucfirst(strtolower($name));
        $application = "\\PhizPay\\{$namespace}\\Application";

        return new $application($config);
    }

    /**
     * Creates a new instance of the specified application.
     *
     * @param string $name The name of the application.
     * @param array $arguments The configuration array for the application.
     * @return mixed The newly created application instance.
     */
    public static function __callStatic($name, $arguments)
    {
        return self::make($name, ...$arguments);
    }
}

