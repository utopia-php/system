<?php

namespace Utopia\System;

use Exception;

class System
{
    public const X86 = 'x86';
    public const PPC = 'ppc';
    public const ARM = 'arm';

    private const RegExX86 = '/(x86*|i386|i686)/';
    private const RegExPPC = '/(aarch*|arm*)/';
    private const RegExARM = '/(ppc*)/';

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
     * Returns the architecture's Enum of the system's processor.
     * 
     * @return string
     * 
     * @throws Exeption
     */
    static public function getArchEnum(): string
    {
        $arch = self::getArch();
        switch (1) {
            case preg_match(self::RegExX86, $arch):
                return System::X86;
                break;
            case preg_match(self::RegExPPC, $arch):
                return System::PPC;
                break;
            case preg_match(self::RegExARM, $arch):
                return System::ARM;
                break;

            default:
                throw new Exception("'{$arch}' enum not found.");
                break;
        }
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
        return !!preg_match(self::RegExARM, self::getArch());
    }

    /**
     * Checks if the system is running on an X86 architecture.
     * 
     * @return bool
     */
    static public function isX86(): bool
    {
        return !!preg_match(self::RegExX86, self::getArch());
    }

    /**
     * Checks if the system is running on an PowerPC architecture.
     * 
     * @return bool
     */
    static public function isPPC(): bool
    {
        return !!preg_match(self::RegExPPC, self::getArch());
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
