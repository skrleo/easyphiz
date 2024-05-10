<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 13:49:44
 */

namespace PhizPay\Tests;

use PhizPay\Factory;
use PHPUnit\Framework\TestCase;

class BillTest extends TestCase
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

        $response = Factory::Bill($config)->apply(array(
            'bill_date' => "2024-04-01",
        ));
        var_dump($response);
        $this->assertTrue(true);
    }

    public function testDownload()
    {
        // 公共参数
        $config = array(
            'appid' => '6490171c3b17b00001f52197',
            'mchid' => '1900009191',
            'serial_no' => '5157F09EFDC096DE15EBE81A47057A7232F1B8E1',

            'cert_path' => 'D:\powerbank\package_builder\easyphiz\doc\657032b7216265.163385334216.pem'
        );

        $response = Factory::Bill($config)->download(array(
            'bill_date' => "2024-04-01",
        ));
        var_dump($response);
        $this->assertTrue(true);
    }
}
