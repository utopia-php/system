<?php



namespace Utopia\Tests;

use Utopia\System\System;
use PHPUnit\Framework\TestCase;

class SystemTestX86 extends TestCase
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
        $this->assertFalse(System::isPPC());
        $this->assertTrue(System::isX86());

        $this->assertFalse(System::isArch(System::ARM));
        $this->assertFalse(System::isArch(System::PPC));
        $this->assertTrue(System::isArch(System::X86));

        $this->assertEquals(System::X86, System::getArchEnum());
    }
}
