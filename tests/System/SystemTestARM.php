<?php

/**
 * Utopia PHP Framework
 *
 * @package System
 * @subpackage Tests
 *
 * @link https://github.com/utopia-php/framework
 * @author Eldad Fux <eldad@appwrite.io>
 * @version 1.0 RC4
 * @license The MIT License (MIT) <http://www.opensource.org/licenses/mit-license.php>
 */

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

    public function testOs():void
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
