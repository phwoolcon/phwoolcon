<?php
namespace Phwoolcon\Tests\Unit;

use Phwoolcon\Crypt;
use Phwoolcon\Tests\Helper\TestCase;

class CryptTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        Crypt::reset();
    }

    public function testOpensslEncryptDecrypt()
    {
        $key = 'BnIv15w06qnvibLuuRfVSP9qb9MLPKFg';
        $text = json_encode(['abc' => 'def', 'xxx1' => 'ooo', 'xxx2' => 'ooo', 'xxx3' => 'ooo', 'xxx4' => 'ooo']);
        $encrypted = Crypt::opensslEncrypt($text, $key);
        $this->assertNotEmpty($encrypted, 'Unable to encrypt');
        $decrypted = Crypt::opensslDecrypt($encrypted, $key);
        $this->assertNotEmpty($decrypted, 'Unable to decrypt');
        $this->assertEquals($text, $decrypted, 'Bad decrypted text');
    }
}
