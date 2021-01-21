<?php

namespace Utopia\System;

class System
{
    public function getOS(): string
    {
        return php_uname("s");
    }

    public function getArch(): string
    {
        return php_uname("m");
    }

    public function getHostname(): string
    {
        return php_uname("n");
    }
}