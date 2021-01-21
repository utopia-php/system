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
        return preg_match('/(aarch*|arm*)/', $this->getArch());
    }
}