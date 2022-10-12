<?php


namespace Utopia\Tests;

use Utopia\System\System;
use PHPUnit\Framework\TestCase;

class SystemTestPPC extends TestCase
{
    public function setUp(): void
    {
    }

    public function tearDown(): void
    {
    }

    public function testOs()
    {
        $this->assertFalse(System::isArm());
        $this->assertTrue(System::isPPC());
        $this->assertFalse(System::isX86());

        $this->assertFalse(System::isArch(System::ARM));
        $this->assertTrue(System::isArch(System::PPC));
        $this->assertFalse(System::isArch(System::X86));

        $this->assertEquals(System::PPC, System::getArchEnum());
    }
}
