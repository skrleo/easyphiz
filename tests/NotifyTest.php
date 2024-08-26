<?php
/*
 * @author: Rio
 * @Date: 2024-04-29 13:49:44
 */

namespace PhizPay\Tests;

use PhizPay\Factory;
use PhizPay\Kernel\Support\Str;
use PHPUnit\Framework\TestCase;

class NotifyTest extends TestCase
{
    /**
     * @group notify
     */
    public function testPaid()
    {
        $config = array(
            'appid' => '661e112cd13b7b00015fbda6',
            'mchid' => '20240402',
            'serial_no' => '5E26E9D42322E0937B4AC2587BCEA8F80387224B',
        );

        $response = Factory::Notify($config)->paid([
            'id' => 'PHIZ20240826065538515001',
            'resource' => array(
                'algorithm' => 'EAD_AES_256_GCM',
                'ciphertext' => "G+mVqVYpkaE8qSk/Hj/PK7fWr5JvXLDR7oaC+3CJ+yw62zAfsbPNnDu7x41bSXrqCtO/klM5azpOOI0FiydMPo6SgcNVaKQZfXvAi59i1Snpggapq3IGBqamgKwnKkornCqJIPbPcJMLxL1FfIGhpISiarDGd0HWK5+XOioVENTkgA1MXXmZpb3PWKDi/wTuPehimmjOS6PKbT8vQcH4h4ZER4I/qFmU1zsJsHtcfuS2foiMM7AbLj+6g6okDQiwEaGly8qsemG435ko7q+e1ugjCp/XzBatddTSgd4JDeFgM3tYboloJqBxdCNO8BIIHUcPUS6n9oc1THv/eDGKbykuaVA3ZIJ+UhSt8IioAsAZpCsrwkjGymqqglfIGdPO9io2kNDhh4UgPg6o9CzJtZq2Y05YtPFGLuZgxk7NttKIfn0/WqGQdy/1MpBTJRIct2pSRl7K37vxAEnkBtqIwVLsi1kWLa7iTAgUx2S18AiCJFiIpzGI/7KfGpryzwbjU9AVb4nTX7z2Zz+ihzaZT7gz9IyCsQnWQKjNJ9/iWqEI25C8pMTX/SvIucs7AYsP+7XLOR6F/ME+VIHhc5cL0rTpeNlYtwDtJNmcneH++TRpI13a4v8oufpRXFN6ORSSYF3XEK8z+La87bBItOeq/RantCf/20+ZxX7H25pfoeEF/kcd2dUrfXydbSerURYfask9kOSma3s2guP5FvOzNBjzvC9Fy9oLJ7lB/c5/uHOX6QCa",
                'nonce' => "JwyMpYEAfrOd",
                'associated_data' => '',
                'original_type' => 'transaction',
            ),
            'summary' => 'SUCCESS',
            'create_time' => '20240826065538',
            'event_type' => 'TRANSACTION.SUCCESS',
            'resource_type' => 'encrypt-resource'
        ]);
        echo $response;
        $this->assertTrue(true);
    }
}
