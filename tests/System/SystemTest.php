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

class SystemTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function tearDown(): void
    {
    }

    public function testOs()
    {
        $this->assertIsString(System::getOS());
        $this->assertIsString(System::getArch());
        $this->assertIsString(System::getHostname());
        $this->assertIsBool(System::isArm());
        $this->assertIsBool(System::isPPC());
        $this->assertIsBool(System::isX86());
        $this->assertIsBool(System::isArch(System::ARM));
        $this->assertIsBool(System::isArch(System::X86));
        $this->assertIsBool(System::isArch(System::PPC));
    }
}
