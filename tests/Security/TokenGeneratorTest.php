<?php


namespace App\Tests\Security;


use App\Security\TokenGenerator;
use PHPUnit\Framework\TestCase;

class TokenGeneratorTest extends TestCase
{
    public function testTokenGeneration(){
        $tokenGenerator = new TokenGenerator();
        $token = $tokenGenerator->getRandomSecureToken(40);

        $this->assertEquals(40, strlen($token));
        $this->assertTrue(ctype_alnum($token), 'Token contains incorrect characters.');
    }
}