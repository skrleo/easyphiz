<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 10:30:08
 */
namespace PhizPay\Bill;

use PhizPay\Kernel\BaseService;
use PhizPay\Kernel\Exceptions\InvalidArgumentException;

class Application extends BaseService
{
    /**
     * Applies for a bill.
     *
     * @param array $args An array containing the bill date.
     * @throws InvalidArgumentException If the bill_date is not set.
     * @return mixed The response from the request.
     */
    public function apply(array $args)
    {
        if (!isset($args['bill_date'])) {
            throw new InvalidArgumentException('bill_date is required', 500);
        }

        $response = $this->request(sprintf('/phiz-microwd-merchapi/pay/bill/tradebill?bill_date=%s', $args['bill_date']), 'GET');

        return $response;
    }

    /**
     * Downloads a bill based on the provided arguments.
     *
     * @param array $args An array containing the bill date.
     * @throws InvalidArgumentException If the bill_date is not set.
     * @return mixed The response from the request.
     */
    public function download(array $args)
    {
        if (!isset($args['bill_date'])) {
            throw new InvalidArgumentException('bill_date is required', 500);
        }

        $response = $this->request(sprintf('/phiz-microwd-merchapi/pay/bill/fundflowbill?bill_date=%s', $args['bill_date']), 'GET');

        return $response;
    }
}