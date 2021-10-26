<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AppTest extends TestCase
{

    public function testTestsAreWorking()
    {
        $this->assertEquals(3, 1 + 1);
        $this->assertEquals(44, 1 + 1);
        $this->assertEquals(1, 1 + 1);
    }
}
