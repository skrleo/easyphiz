<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 13:49:44
 */

namespace PhizPay\Tests;

use PhizPay\Factory;
use PhizPay\Kernel\Support\Str;
use PHPUnit\Framework\TestCase;

class OrderTest extends TestCase
{
    public function testUnify()
    {
        $config = array(
            'appid' => '662f08a9d13b7b00015fbdbd',
            'mchid' => 'merchno',
            'serial_no' => '206ECAD6C0CB931EF19E384C505D07400F0C56AB',

            'is_debug' => true,
            'cert_path' => 'D:\powerbank\package_builder\easyphiz\doc\merchno_private_key.pem',
        );

        $response = Factory::Order($config)->unify(array(
            'trade_type' => 'jsapi', # jsapi| native | micropay
            'out_trade_no' => date('Ymd') . Str::random_int(13),
            'description' => 'mch_10_store_17',
            'amount' => array(
                'total' => '0.01',
                'currency' => 'BRL'
            ),
            'detail' => array(
                'goods_detail' => array(
                    array(
                        'merchant_goods_id' => '243',
                        'quantity' => 1,
                        'unit_price' => '0.01',
                        'goods_name' => 'NongFuSpring'
                    )
                )
            ),
            'payer' => array(
                'openid' => '589e37b9a9ca67b5e269701d3e50a2493719149c',
            ),
            'attach' => array(
                'path' => 'pages/order/myOrderDetail/myOrderDetail?order_no=202405092658004622',
                'appletsId' => '6490171c3b17b00001f52197'
            )
        ));
        var_dump($response);
        $this->assertTrue(true);
    }

    public function testByTransactionId()
    {
        $config = array(
            'appid' => '6490171c3b17b00001f52197',
            'mchid' => '1900009191',
            'serial_no' => '5157F09EFDC096DE15EBE81A47057A7232F1B8E1',

            'is_debug' => true,
            'cert_path' => 'D:\powerbank\package_builder\easyphiz\doc\657032b7216265.163385334216.pem'
        );

        $response = Factory::Order($config)->byTransactionId(array(
            'transaction_id' => 'PHIZ20240509070741503002',
        ));
        var_dump($response);
        $this->assertTrue(true);
    }

    public function testByOutTradeNumber()
    {
        $config = array(
            'appid' => '6490171c3b17b00001f52197',
            'mchid' => '1900009191',
            'serial_no' => '5157F09EFDC096DE15EBE81A47057A7232F1B8E1',

            'is_debug' => true,
            'cert_path' => 'D:\powerbank\package_builder\easyphiz\doc\657032b7216265.163385334216.pem'
        );

        $response = Factory::Order($config)->byOutTradeNumber(array(
            'out_trade_no' => '202405098459004628',
        ));
        var_dump($response);
        $this->assertTrue(true);
    }

    public function testClose()
    {
        $config = array(
            'appid' => '6490171c3b17b00001f52197',
            'mchid' => '1900009191',
            'serial_no' => '5157F09EFDC096DE15EBE81A47057A7232F1B8E1',

            'cert_path' => 'D:\powerbank\package_builder\easyphiz\doc\657032b7216265.163385334216.pem'
        );

        $response = Factory::Order($config)->close(array(
            'out_trade_no' => '202405101672004646',
        ));
        var_dump($response);
        $this->assertTrue(true);
    }
}
