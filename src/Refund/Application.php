<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 10:30:05
 */
namespace PhizPay\Refund;

use PhizPay\Kernel\BaseService;
use PhizPay\Kernel\Exceptions\InvalidArgumentException;

class Application extends BaseService
{
    /**
     * Applies a refund by making a POST request to the '/phiz-microwd-merchapi/refund/domestic/refunds' endpoint.
     *
     * @param array $args An associative array containing the refund details. It must have the 'out_refund_no' key set.
     * @throws InvalidArgumentException If the 'out_refund_no' key is not set in the $args array.
     * @return mixed The response from the refund request.
     */
    public function apply(array $args)
    {
        if (!isset($args['out_refund_no'])) {
            throw new InvalidArgumentException('out_refund_no is required', 500);
        }

        $response = $this->request('/phiz-microwd-merchapi/refund/domestic/refunds', 'POST', $args);

        return $response;
    }

    /**
     * Queries a refund by making a GET request to the '/phiz-microwd-merchapi/refund/domestic/refunds/{out_refund_no}?mchid={mchid}' endpoint.
     *
     * @param array $args An associative array containing the 'out_refund_no' key.
     * @throws InvalidArgumentException If the 'out_refund_no' key is not set in the $args array.
     * @return mixed The response from the refund query request.
     */
    public function query(array $args)
    {
        if (!isset($args['out_refund_no'])) {
            throw new InvalidArgumentException('out_refund_no is required', 500);
        }

        $response = $this->request(sprintf('/phiz-microwd-merchapi/refund/domestic/refunds/%s?mchid=%s', $args['out_refund_no'], $this->config['mchid']), 'GET', $args);

        return $response;
    }
}