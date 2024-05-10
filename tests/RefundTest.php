<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 13:49:44
 */

namespace PhizPay\Tests;

use PhizPay\Factory;
use PHPUnit\Framework\TestCase;

class RefundTest extends TestCase
{

    public function testApply()
    {
        // 公共参数
        $config = array(
            'appid' => '6490171c3b17b00001f52197',
            'mchid' => '1900009191',
            'serial_no' => '5157F09EFDC096DE15EBE81A47057A7232F1B8E1',

            'cert_path' => 'D:\powerbank\package_builder\easyphiz\doc\657032b7216265.163385334216.pem'
        );

        $response = Factory::Refund($config)->apply(array(
            'mchid' => '1900009191',
            'transaction_id' => 'PHIZ20230803134053218002',
            'out_refund_no' => 'refund_202405098459004628',
            "reason" => "return test",
            "funds_account" => "AVAILABLE",
            "amount" => array(
                "refund" => "0.01",
                "from" => array(
                    array(
                        "account" => "AVAILABLE",
                        "amount" => "0.01",
                    ),
                ),
                "total" =>  "0.01",
                "currency" => "BRL",
            ),
            "goods_detail" => array(
                array(
                    "merchant_goods_id" => "111-11-11",
                    "pay_goods_id" => "1001",
                    "goods_name" => "goods_name",
                    "unit_price" => "0.01",
                    "refund_amount" => "0.01",
                    "refund_quantity" => 1,
                )
            )
        ));
        var_dump($response);
        $this->assertTrue(true);
    }

    public function testQuery()
    {
        // 公共参数
        $config = array(
            'appid' => '6490171c3b17b00001f52197',
            'mchid' => '1900009191',
            'serial_no' => '5157F09EFDC096DE15EBE81A47057A7232F1B8E1',

            'cert_path' => 'D:\powerbank\package_builder\easyphiz\doc\657032b7216265.163385334216.pem'
        );

        $response = Factory::Refund($config)->query(array(
            'transaction_id' => 'PHIZ20230803134053218002',
            'out_refund_no' => 'refund_202405098459004628',
        ));
        var_dump($response);
        $this->assertTrue(true);
    }
}
