<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 10:30:07
 */
namespace PhizPay\Order;

use PhizPay\Kernel\BaseService;
use PhizPay\Kernel\Exceptions\InvalidArgumentException;
use PhizPay\Kernel\Support\Str;

class Application extends BaseService
{
    /**
     * Unifies the given array of arguments into a single format for different payment types.
     *
     * @param array $args An array of arguments containing the trade type.
     * @throws InvalidArgumentException If the trade type is not set or if the trade type is invalid.
     * @return mixed The response from the request.
     */
    public function unify(array $args)
    {
        if (!isset($args['trade_type'])) {
            throw new InvalidArgumentException('trade_type is required', 500);
        }

        if (!method_exists(new Unify(), $fun = $args['trade_type'])) {
            throw new InvalidArgumentException(sprintf('%s invalid method', $fun), 500);
        }

        $response = $this->request(...(new Unify())->$fun($args));

        return $response;
    }

    /**
     * Orders query by transaction ID.
     *
     * @param array $args Arguments array containing the transaction ID.
     * @throws InvalidArgumentException If the transaction ID is not set.
     * @return mixed The response from the query.
     */
    public function byTransactionId(array $args)
    {
        if (!isset($args['transaction_id'])) {
            throw new InvalidArgumentException('transaction_id is required', 500);
        }

        $response = $this->request(sprintf('/phiz-microwd-merchapipay/transactions/id/%s?mchid=%s', $args['transaction_id'], $this->config['mchid']), 'GET');

        return $response;
    }

    /**
     * Retrieves an order by its out_trade_no.
     *
     * @param array $args An array containing the out_trade_no.
     * @throws InvalidArgumentException If the out_trade_no is not set.
     * @return mixed The response from the request.
     */
    public function byOutTradeNumber(array $args)
    {
        if (!isset($args['out_trade_no'])) {
            throw new InvalidArgumentException('out_trade_no is required', 500);
        }

        $response = $this->request(sprintf('/phiz-microwd-merchapi/pay/transactions/out-trade-no/%s?mchid=%s', $args['out_trade_no'], $this->config['mchid']), 'GET');

        return $response;
    }
    /**
     * Closes an order by its out_trade_no.
     *
     * @param array $args An array containing the out_trade_no.
     * @throws InvalidArgumentException If the out_trade_no is not set.
     * @return mixed The response from the request.
     */
    public function close(array $args)
    {
        if (!isset($args['out_trade_no'])) {
            throw new InvalidArgumentException('out_trade_no is required', 500);
        }

        $response = $this->request(sprintf('/phiz-microwd-merchapi/pay/transactions/out-trade-no/%s/close', $args['out_trade_no']), 'POST', $args);

        return $response;
    }

}