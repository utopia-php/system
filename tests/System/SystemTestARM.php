<?php


namespace Utopia\Tests;

use Utopia\System\System;
use PHPUnit\Framework\TestCase;

class SystemTestARM extends TestCase
{
    public function setUp(): void
    {
    }

    public function tearDown(): void
    {
    }

    public function testOs()
    {
        $this->assertTrue(System::isArm());
        $this->assertFalse(System::isPPC());
        $this->assertFalse(System::isX86());

        $this->assertTrue(System::isArch(System::ARM));
        $this->assertFalse(System::isArch(System::PPC));
        $this->assertFalse(System::isArch(System::X86));

        $this->assertEquals(System::ARM, System::getArchEnum());
    }
}
