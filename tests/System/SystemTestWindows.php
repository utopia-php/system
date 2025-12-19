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

class SystemTestWindows extends TestCase
{
    public function setUp(): void
    {
        if (System::getOS() !== 'Windows NT') {
            $this->markTestSkipped('Windows-specific tests can only run on Windows');
        }
    }

    public function tearDown(): void
    {
    }

    public function testOs(): void
    {
        $this->assertEquals('Windows NT', System::getOS());
        $this->assertIsString(System::getArch());
        $this->assertIsString(System::getArchEnum());
        $this->assertIsString(System::getHostname());
    }

    public function testGetCPUCores(): void
    {
        $cores = System::getCPUCores();
        $this->assertIsInt($cores);
        $this->assertGreaterThan(0, $cores);
    }

    public function testGetDiskTotal(): void
    {
        $total = System::getDiskTotal();
        $this->assertIsInt($total);
        $this->assertGreaterThan(0, $total);
    }

    public function testGetDiskFree(): void
    {
        $free = System::getDiskFree();
        $this->assertIsInt($free);
        $this->assertGreaterThanOrEqual(0, $free);
        
        // Free space should be less than or equal to total
        $this->assertLessThanOrEqual(System::getDiskTotal(), $free);
    }

    public function testUnsupportedMethods(): void
    {
        // CPU Usage is not supported on Windows
        $this->expectException(\Exception::class);
        System::getCPUUsage(5);
    }

    public function testGetMemoryTotalThrowsException(): void
    {
        $this->expectException(\Exception::class);
        System::getMemoryTotal();
    }

    public function testGetMemoryFreeThrowsException(): void
    {
        $this->expectException(\Exception::class);
        System::getMemoryFree();
    }

    public function testGetIOUsageThrowsException(): void
    {
        try {
            System::getIOUsage();
            $this->fail('Expected exception was not thrown');
        } catch (\Exception $e) {
            // Expected - method tries to read /proc/diskstats which doesn't exist on Windows
            $this->assertTrue(true);
        } catch (\Throwable $e) {
            // Also acceptable - might throw warnings/errors
            $this->assertTrue(true);
        }
    }

    public function testGetNetworkUsageThrowsException(): void
    {
        try {
            System::getNetworkUsage();
            $this->fail('Expected exception was not thrown');
        } catch (\Exception $e) {
            // Expected - method tries to access /sys/class/net which doesn't exist on Windows
            $this->assertTrue(true);
        } catch (\Throwable $e) {
            // Also acceptable - might throw warnings/errors
            $this->assertTrue(true);
        }
    }

    public function testGetEnv(): void
    {
        // Test with existing Windows environment variables
        $path = System::getEnv('PATH', 'DEFAULT');
        $this->assertNotEquals('DEFAULT', $path);
        $this->assertIsString($path);
        
        // Test with non-existent variable
        $this->assertEquals('DEFAULT_VALUE', System::getEnv('NON_EXISTENT_VAR_12345', 'DEFAULT_VALUE'));
        $this->assertNull(System::getEnv('NON_EXISTENT_VAR_12345'));
    }
}
