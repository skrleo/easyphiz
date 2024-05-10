<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 11:24:55
 */

namespace PhizPay\Order;

class Unify
{
    /**
     * Executes a JSAPI transaction with the given arguments.
     *
     * @param array $args The arguments for the transaction.
     *                    Should contain the 'trade_type' key.
     * @return array An array containing the endpoint URL, the HTTP method,
     *               and the transaction parameters.
     */
    public function jsapi($args)
    {
        return array("/phiz-microwd-merchapi/pay/transactions/jsapi", 'POST', $args);
    }

    /**
     * Executes a native transaction with the given arguments.
     *
     * @param array $args The arguments for the transaction.
     * @return array An array containing the endpoint URL, the HTTP method, and the transaction parameters.
     */
    public function native($args)
    {
        return array("/phiz-microwd-merchapi/pay/transactions/native", 'POST', $args);
    }

    /**
     * Executes a micropay transaction with the given arguments.
     *
     * @param array $args The arguments for the transaction.
     * @return array An array containing the endpoint URL, the HTTP method, and the transaction parameters.
     */
    public function micropay($args)
    {
        return array("/phiz-microwd-merchapi/pay/transactions/micropay", 'POST', $args);
    }
}
