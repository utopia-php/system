<?php

namespace Utopia\System;

use Exception;

class System
{
    static public const X86 = 'x86';
    static public const PPC = 'ppc';
    static public const ARM = 'arm';

    /**
     * Returns the system's OS.
     * @return string
     */
    static public function getOS(): string
    {
        return php_uname('s');
    }

    /**
     * Returns the architecture of the system's processor.
     * 
     * @return string
     */
    static public function getArch(): string
    {
        return php_uname('m');
    }

    /**
     * Returns the system's hostname.
     * 
     * @return string
     */
    static public function getHostname(): string
    {
        return php_uname('n');
    }

    /**
     * Checks if the system is running on an ARM architecture.
     * 
     * @return bool
     */
    static public function isArm(): bool
    {
        return !!preg_match('/(aarch*|arm*)/', self::getArch());
    }

    /**
     * Checks if the system is running on an X86 architecture.
     * 
     * @return bool
     */
    static public function isX86(): bool
    {
        return !!preg_match('/(x86*|i386|i686)/', self::getArch());
    }

    /**
     * Checks if the system is running on an PowerPC architecture.
     * 
     * @return bool
     */
    static public function isPPC(): bool
    {
        return !!preg_match('/(ppc*)/', self::getArch());
    }

    /**
     * Checks if the system is the passed architecture. 
     * You should pass `System::X86`, `System::PPC`, `System::ARM` or an equivalent string.
     * 
     * @param string $arch
     * 
     * @return bool
     * 
     * @throws Exeption
     */
    static public function isArch(string $arch): bool
    {
        switch ($arch) {
            case self::X86:
                return self::isX86();
                break;
            case self::PPC:
                return self::isPPC();
                break;
            case self::ARM:
                return self::isArm();
                break;

            default:
                throw new Exception("'{$arch}' not found.");
                break;
        }
    }
}
