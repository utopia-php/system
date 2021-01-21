<?php

namespace Utopia\System;

class System
{
    /**
     * Returns the system's OS.
     * @return string
     */
    public function getOS(): string
    {
        return php_uname("s");
    }

    /**
     * Returns the architecture of the system's processor.
     * 
     * @return string
     */
    public function getArch(): string
    {
        return php_uname("m");
    }

    /**
     * Returns the system's hostname.
     * 
     * @return string
     */
    public function getHostname(): string
    {
        return php_uname("n");
    }

    /**
     * Checks if the system is running on an ARM architecture.
     * 
     * @return bool
     */
    public function isArm(): bool
    {
        return !!preg_match('/(aarch*|arm*)/', $this->getArch());
    }

    /**
     * Checks if the system is running on an X86 architecture.
     * 
     * @return bool
     */
    public function isX86(): bool
    {
        return !!preg_match('/(x86*|i386|i686)/', $this->getArch());
    }

    /**
     * Checks if the system is running on an PowerPC architecture.
     * 
     * @return bool
     */
    public function isPPC(): bool
    {
        return !!preg_match('/(ppc*)/', $this->getArch());
    }
}