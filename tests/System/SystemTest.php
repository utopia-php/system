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

class SystemTest extends TestCase
{
    public function setUp(): void
    {
    }

    public function tearDown(): void
    {
    }

    public function testOs(): void
    {
        $this->assertIsString(System::getOS());
        $this->assertIsString(System::getArch());
        $this->assertIsString(System::getArchEnum());
        $this->assertIsString(System::getHostname());
        $this->assertIsBool(System::isArm64());
        $this->assertIsBool(System::isArmV7());
        $this->assertIsBool(System::isArmV8());
        $this->assertIsBool(System::isPPC());
        $this->assertIsBool(System::isX86());
        $this->assertIsBool(System::isArch(System::ARM64));
        $this->assertIsBool(System::isArch(System::ARMV7));
        $this->assertIsBool(System::isArch(System::ARMV8));
        $this->assertIsBool(System::isArch(System::X86));
        $this->assertIsBool(System::isArch(System::PPC));
        $this->expectException('Exception');
        System::isArch('throw');
    }

    public function testGetCPUCores(): void
    {
        $this->assertIsInt(System::getCPUCores());
    }

    public function testGetDiskTotal(): void
    {
        $this->assertIsInt(System::getDiskTotal());
    }

    public function testGetDiskFree(): void
    {
        $this->assertIsInt(System::getDiskFree());
    }

    // Methods only implemented for Linux
    public function testGetCPUUsage(): void
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsNumeric(System::getCPUUsage(5));
        } else {
            $this->expectException('Exception');
            System::getCPUUsage(5);
        }
    }

    public function testGetMemoryTotal(): void
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsInt(System::getMemoryTotal());
        } else {
            $this->expectException('Exception');
            System::getMemoryTotal();
        }
    }

    public function testGetMemoryFree(): void
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsInt(System::getMemoryFree());
        } else {
            $this->expectException('Exception');
            System::getMemoryFree();
        }
    }

    public function testGetIOUsage(): void
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsArray(System::getIOUsage());
        } else {
            $this->expectException('Exception');
            System::getIOUsage();
        }
    }

    public function testGetNetworkUsage(): void
    {
        if (System::getOS() === 'Linux') {
            $this->assertIsArray(System::getNetworkUsage());
        } else {
            $this->expectException('Exception');
            System::getNetworkUsage();
        }
    }

    public function testGetEnv(): void
    {
        $this->assertEquals(System::getEnv('TESTA', 'DEFAULTA'), 'VALUEA');
        $this->assertEquals(System::getEnv('TESTB', 'DEFAULTB'), 'VALUEB');
        $this->assertEquals(System::getEnv('TESTC', 'DEFAULTC'), 'DEFAULTC');
    }
}
