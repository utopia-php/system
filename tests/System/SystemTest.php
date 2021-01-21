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
        $system = new System();

        $this->assertIsString($system->getArch());
        $this->assertIsString($system->getOS());
        $this->assertIsString($system->getHostname());
        $this->assertIsBool($system->isArm());
        $this->assertTrue($system->isPPC());
        $this->assertIsBool($system->isX86());
    }
}
