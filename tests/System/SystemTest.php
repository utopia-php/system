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
        $this->assertIsString(System::getArchEnum());
        $this->assertIsString(System::getHostname());
        $this->assertIsBool(System::isArm());
        $this->assertIsBool(System::isPPC());
        $this->assertIsBool(System::isX86());
        $this->assertIsBool(System::isArch(System::ARM));
        $this->assertIsBool(System::isArch(System::X86));
        $this->assertIsBool(System::isArch(System::PPC));
        $this->expectException("Exception");
        System::isArch("throw");
    }

    public function testGetCPUCores()
    {
        $this->assertIsInt(System::getCPUCores());
    }

    public function testGetDiskTotal()
    {
        $this->assertIsInt(System::getDiskTotal());
    }

    public function testGetDiskFree()
    {
        $this->assertIsInt(System::getDiskFree());
    }
    
    // Methods only implemented for Linux
    public function testGetCPUUtilisation()
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsInt(System::getCPUUtilisation());
        } else {
            $this->expectException("Exception");
            System::getCPUUtilisation();
        }
    }

    public function testGetMemoryTotal()
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsInt(System::getMemoryTotal());
        } else {
            $this->expectException("Exception");
            System::getMemoryTotal();
        }
    }

    public function testGetMemoryFree()
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsInt(System::getMemoryFree());
        } else {
            $this->expectException("Exception");
            System::getMemoryFree();
        }
    }

    public function testGetIOUsage()
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsArray(System::getIOUsage());
        } else {
            $this->expectException("Exception");
            System::getIOUsage();
        }
    }

    public function testGetNetworkUsage() {
        if (System::getOS() === 'Linux') {
            $this->assertIsArray(System::getNetworkUsage());
        } else {
            $this->expectException("Exception");
            System::getNetworkUsage();
        }
    }
}
