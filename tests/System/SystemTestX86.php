<?php

/**
 * Utopia PHP Framework
 *
 *
 * @link https://github.com/utopia-php/framework
 *
 * @author Eldad Fux <eldad@appwrite.io>
 *
 * @version 1.0 RC4
 *
 * @license The MIT License (MIT) <http://www.opensource.org/licenses/mit-license.php>
 */

namespace Utopia\Tests;

use PHPUnit\Framework\TestCase;
use Utopia\System\System;

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
        $this->assertFalse(System::isArm64());
        $this->assertFalse(System::isArmV7());
        $this->assertFalse(System::isArmV8());
        $this->assertFalse(System::isPPC());
        $this->assertTrue(System::isX86());

        $this->assertFalse(System::isArch(System::ARM64));
        $this->assertFalse(System::isArch(System::ARMV7));
        $this->assertFalse(System::isArch(System::ARMV8));
        $this->assertFalse(System::isArch(System::PPC));
        $this->assertTrue(System::isArch(System::X86));

        $this->assertEquals(System::X86, System::getArchEnum());
    }
}
