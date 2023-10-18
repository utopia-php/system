<?php

namespace Utopia\System;

use Exception;

class System
{
    public const X86 = 'x86';

    public const PPC = 'ppc';

    public const ARM64 = 'arm64';

    public const ARMV7 = 'armv7';

    public const ARMV8 = 'armv8';

    private const RegExX86 = '/(x86*|i386|i686)/';

    private const RegexARM64 = '/(arm64|aarch64)/';

    private const RegexARMV7 = '/(armv7)/';

    private const RegexARMV8 = '/(armv8)/';

    private const RegExPPC = '/(ppc*)/';

    /**
     * A list of Linux Disks that are not considered valid
     * These are usually virtual drives or other non-physical devices such as loopback or ram.
     *
     * This list is ran through a contains, meaning for example if 'loop' was in the list,
     * A 'loop0' interface would be considered invalid and not computed.
     *
     * Documentation:
     * Loop - https://man7.org/linux/man-pages/man4/loop.4.html
     * Ram - https://man7.org/linux/man-pages/man4/ram.4.html
     *
     * @var array<int, string>
     */
    private const INVALID_DISKS = [
        'loop',
        'ram',
    ];

    /**
     * A list of Linux Network Interfaces that are not considered valid
     * These are usually virtual interfaces created by tools such as Docker or VirtualBox
     *
     * This list is ran through a contains, meaning for example if 'vboxnet' was in the list,
     * A 'vboxnet0' interface would be considered invalid and not computed.
     *
     * Documentation:
     * veth - https://man7.org/linux/man-pages/man4/veth.4.html
     * docker - https://docs.docker.com/network/
     * lo - Localhost Loopback device, https://man7.org/linux/man-pages/man4/loop.4.html
     * tun - Linux Layer 3 Interface, https://www.kernel.org/doc/html/v5.8/networking/tuntap.html
     * vboxnet - Virtual Machine Networking Interface, https://www.virtualbox.org/manual/ch06.html
     * bonding_masters - https://www.kernel.org/doc/Documentation/networking/bonding.txt
     */
    private const INVALIDNETINTERFACES = [
        'veth',
        'docker',
        'lo',
        'tun',
        'vboxnet',
        '.',
        'bonding_masters',
    ];

    /**
     * Returns the system's OS.
     */
    public static function getOS(): string
    {
        return php_uname('s');
    }

    /**
     * Returns the architecture of the system's processor.
     */
    public static function getArch(): string
    {
        return php_uname('m');
    }

    /**
     * Returns the architecture's Enum of the system's processor.
     *
     *
     * @throws Exception
     */
    public static function getArchEnum(): string
    {
        $arch = self::getArch();

        return match (1) {
            preg_match(self::RegExX86, $arch) => System::X86,
            preg_match(self::RegExPPC, $arch) => System::PPC,
            preg_match(self::RegexARM64, $arch) => System::ARM64,
            preg_match('/'.self::ARMV7.'/', $arch) => System::ARMV7,
            preg_match('/'.self::ARMV8.'/', $arch) => System::ARMV8,
            default => throw new Exception("'{$arch}' enum not found."),
        };
    }

    /**
     * Returns the system's hostname.
     */
    public static function getHostname(): string
    {
        return php_uname('n');
    }

    /**
     * Checks if the system is running on an ARM64 architecture.
     */
    public static function isArm64(): bool
    {
        return (bool) preg_match(self::RegexARM64, self::getArch());
    }

    /**
     * Checks if the system is running on an ARMV7 architecture.
     */
    public static function isArmV7(): bool
    {
        return (bool) preg_match(self::RegexARMV7, self::getArch());
    }

    /**
     * Checks if the system is running on an ARM64 architecture.
     */
    public static function isArmV8(): bool
    {
        return (bool) preg_match(self::RegexARMV8, self::getArch());
    }

    /**
     * Checks if the system is running on an X86 architecture.
     */
    public static function isX86(): bool
    {
        return (bool) preg_match(self::RegExX86, self::getArch());
    }

    /**
     * Checks if the system is running on an PowerPC architecture.
     */
    public static function isPPC(): bool
    {
        return (bool) preg_match(self::RegExPPC, self::getArch());
    }

    /**
     * Checks if the system is the passed architecture.
     * You should pass `System::X86`, `System::PPC`, `System::ARM` or an equivalent string.
     *
     *
     * @throws Exception
     */
    public static function isArch(string $arch): bool
    {
        return match ($arch) {
            self::X86 => self::isX86(),
            self::PPC => self::isPPC(),
            self::ARM64 => self::isArm64(),
            self::ARMV7 => self::isArmV7(),
            self::ARMV8 => self::isArmV8(),
            default => throw new Exception("'{$arch}' not found."),
        };
    }

    /**
     * Gets the system's total amount of CPU cores.
     *
     *
     * @throws Exception
     */
    public static function getCPUCores(): int
    {
        switch (self::getOS()) {
            case 'Linux':
                $cpuInfo = file_get_contents('/proc/cpuinfo');
                $matches[] = [];

                if ($cpuInfo) {
                    preg_match_all('/^processor/m', $cpuInfo, $matches);
                }

                return count($matches[0]);
            case 'Darwin':
                return intval(shell_exec('sysctl -n hw.ncpu'));
            case 'Windows':
                return intval(shell_exec('wmic cpu get NumberOfCores'));
            default:
                throw new Exception(self::getOS().' not supported.');
        }
    }

    /**
     * Helper function to read a Linux System's /proc/stat data and convert it into an array.
     *
     * @return array<int|string, array<string, mixed>>
     */
    private static function getProcStatData(): array
    {
        $data = [];

        $totalCPUExists = false;

        $cpustats = file_get_contents('/proc/stat');

        if (! $cpustats) {
            throw new Exception('Unable to read /proc/stat');
        }

        $cpus = explode("\n", $cpustats);

        // Remove non-CPU lines
        $cpus = array_filter($cpus, function ($cpu) {
            return preg_match('/^cpu[0-999]/', $cpu);
        });

        foreach ($cpus as $cpu) {
            $cpu = explode(' ', $cpu);

            // get CPU number
            $cpuNumber = substr($cpu[0], 3);

            if ($cpu[0] === 'cpu') {
                $totalCPUExists = true;
                $cpuNumber = 'total';
            }

            $data[$cpuNumber]['user'] = $cpu[1] ?? 0;
            $data[$cpuNumber]['nice'] = $cpu[2] ?? 0;
            $data[$cpuNumber]['system'] = $cpu[3] ?? 0;
            $data[$cpuNumber]['idle'] = $cpu[4] ?? 0;
            $data[$cpuNumber]['iowait'] = $cpu[5] ?? 0;
            $data[$cpuNumber]['irq'] = $cpu[6] ?? 0;
            $data[$cpuNumber]['softirq'] = $cpu[7] ?? 0;

            // These might not exist on older kernels.
            $data[$cpuNumber]['steal'] = $cpu[8] ?? 0;
            $data[$cpuNumber]['guest'] = $cpu[9] ?? 0;
        }

        if (! $totalCPUExists) {
            // Combine all values
            $data['total'] = [
                'user' => 0,
                'nice' => 0,
                'system' => 0,
                'idle' => 0,
                'iowait' => 0,
                'irq' => 0,
                'softirq' => 0,
                'steal' => 0,
                'guest' => 0,
            ];

            foreach ($data as $cpu) {
                $data['total']['user'] += intval($cpu['user']);
                $data['total']['nice'] += intval($cpu['nice']);
                $data['total']['system'] += intval($cpu['system']);
                $data['total']['idle'] += intval($cpu['idle']);
                $data['total']['iowait'] += intval($cpu['iowait']);
                $data['total']['irq'] += intval($cpu['irq']);
                $data['total']['softirq'] += intval($cpu['softirq']);
                $data['total']['steal'] += intval($cpu['steal']);
                $data['total']['guest'] += intval($cpu['guest']);
            }
        }

        return $data;
    }

    /**
     * Get percentage CPU usage (between 0 and 100)
     * Reference for formula: https://stackoverflow.com/a/23376195/17300412
     *
     *
     * @throws Exception
     */
    public static function getCPUUsage(int $duration = 1): float
    {
        switch (self::getOS()) {
            case 'Linux':
                $startCpu = self::getProcStatData()['total'];
                \sleep($duration);
                $endCpu = self::getProcStatData()['total'];

                $prevIdle = $startCpu['idle'] + $startCpu['iowait'];
                $idle = $endCpu['idle'] + $endCpu['iowait'];

                $prevNonIdle = $startCpu['user'] + $startCpu['nice'] + $startCpu['system'] + $startCpu['irq'] + $startCpu['softirq'] + $startCpu['steal'];
                $nonIdle = $endCpu['user'] + $endCpu['nice'] + $endCpu['system'] + $endCpu['irq'] + $endCpu['softirq'] + $endCpu['steal'];

                $prevTotal = $prevIdle + $prevNonIdle;
                $total = $idle + $nonIdle;

                $totalDiff = $total - $prevTotal;
                $idleDiff = $idle - $prevIdle;

                $percentage = ($totalDiff - $idleDiff) / $totalDiff;

                return $percentage * 100;
            default:
                throw new Exception(self::getOS().' not supported.');
        }
    }

    /**
     * Returns the total amount of RAM available on the system as Megabytes.
     *
     *
     * @throws Exception
     */
    public static function getMemoryTotal(): int
    {
        switch (self::getOS()) {
            case 'Linux':
                $memInfo = file_get_contents('/proc/meminfo');

                if (! $memInfo) {
                    throw new Exception('Unable to read /proc/meminfo');
                }
                preg_match('/MemTotal:\s+(\d+)/', $memInfo, $matches);

                if (isset($matches[1])) {
                    return intval(intval($matches[1]) / 1024);
                } else {
                    throw new Exception('Unable to find memtotal in /proc/meminfo.');
                }
            case 'Darwin':
                return intval((intval(shell_exec('sysctl -n hw.memsize'))) / 1024 / 1024);
            default:
                throw new Exception(self::getOS().' not supported.');
        }
    }

    /**
     * Returns the total amount of Free RAM available on the system as Megabytes.
     *
     *
     * @throws Exception
     */
    public static function getMemoryFree(): int
    {
        switch (self::getOS()) {
            case 'Linux':
                $meminfo = file_get_contents('/proc/meminfo');

                if (! $meminfo) {
                    throw new Exception('Unable to read /proc/meminfo');
                }

                preg_match('/MemFree:\s+(\d+)/', $meminfo, $matches);
                if (isset($matches[1])) {
                    return intval(intval($matches[1]) / 1024);
                } else {
                    throw new Exception('Could not find MemFree in /proc/meminfo.');
                }
            case 'Darwin':
                return intval(intval(shell_exec('sysctl -n vm.page_free_count')) / 1024 / 1024);
            default:
                throw new Exception(self::getOS().' not supported.');
        }
    }

    /**
     * Returns the total amount of Disk space on the system as Megabytes.
     *
     *
     * @throws Exception
     */
    public static function getDiskTotal(): int
    {
        $totalSpace = disk_total_space(__DIR__);

        if ($totalSpace === false) {
            throw new Exception('Unable to get disk space');
        }

        return intval($totalSpace / 1024 / 1024);
    }

    /**
     * Returns the total amount of Disk space free on the system as Megabytes.
     *
     *
     * @throws Exception
     */
    public static function getDiskFree(): int
    {
        $totalSpace = disk_free_space(__DIR__);

        if ($totalSpace === false) {
            throw new Exception('Unable to get free disk space');
        }

        return intval($totalSpace / 1024 / 1024);
    }

    /**
     * Helper function to read a Linux System's /proc/diskstats data and convert it into an array.
     *
     * @return array<string, array<int, mixed>>
     */
    private static function getDiskStats(): array
    {
        // Read /proc/diskstats
        $diskStats = file_get_contents('/proc/diskstats');

        if (! $diskStats) {
            throw new Exception('Unable to read /proc/diskstats');
        }

        // Split the data
        $diskStats = explode("\n", $diskStats);

        // Remove excess spaces
        $diskStats = array_map(function ($data) {
            return preg_replace('/\t+/', ' ', trim($data));
        }, $diskStats);

        // Remove empty lines
        $diskStats = array_filter($diskStats, function ($data) {
            return ! empty($data);
        });

        $data = [];
        foreach ($diskStats as $disk) {
            // Breakdown the data
            $disk = explode(' ', $disk);

            $data[$disk[2]] = $disk;
        }

        return $data;
    }

    /**
     * Returns an array of all the available storage devices on the system containing
     * the current read and write usage in Megabytes.
     * There is also a ['total'] key that contains the total amount of read and write usage.
     *
     * @return array<string, array<string, mixed>>
     *
     * @throws Exception
     */
    public static function getIOUsage(int $duration = 1): array
    {
        $diskStat = self::getDiskStats();
        sleep($duration);
        $diskStat2 = self::getDiskStats();

        $diskStat = array_filter($diskStat, function (array $disk) {
            foreach (self::INVALID_DISKS as $filter) {
                if (! isset($disk[2]) || ! \is_string($disk[2])) {
                    return false;
                }
                if (str_contains($disk[2], $filter)) {
                    return false;
                }
            }

            return true;
        });

        $diskStat2 = array_filter($diskStat2, function ($disk) {
            foreach (self::INVALID_DISKS as $filter) {
                if (! isset($disk[2]) || ! \is_string($disk[2])) {
                    return false;
                }

                if (str_contains($disk[2], $filter)) {
                    return false;
                }
            }

            return true;
        });

        $stats = [];

        // Compute Delta
        foreach ($diskStat as $key => $disk) {
            $read1 = $diskStat2[$key][5];
            $read2 = $disk[5];

            $write1 = $diskStat2[$key][9];
            $write2 = $disk[9];

            /**
             * @phpstan-ignore-next-line
             */
            $stats[$key]['read'] = (((intval($read1) - intval($read2)) * 512) / 1048576);

            /**
             * @phpstan-ignore-next-line
             */
            $stats[$key]['write'] = (((intval($write1) - intval($write2)) * 512) / 1048576);
        }

        $stats['total']['read'] = array_sum(array_column($stats, 'read'));
        $stats['total']['write'] = array_sum(array_column($stats, 'write'));

        return $stats;
    }

    /**
     * Returns an array of all the available network interfaces on the system
     * containing the current download and upload usage in Megabytes.
     * There is also a ['total'] key that contains the total amount of download
     * and upload
     *
     * @param  int  $duration The buffer duration to fetch the data points
     * @return array<int|string, array<string, float|int>>
     *
     * @throws Exception
     */
    public static function getNetworkUsage(int $duration = 1): array
    {
        // Create a list of interfaces
        $interfaces = scandir('/sys/class/net', SCANDIR_SORT_NONE);

        if (! $interfaces) {
            throw new Exception('Unable to read /sys/class/net');
        }

        // Remove all unwanted interfaces
        $interfaces = array_filter($interfaces, function ($interface) {
            foreach (self::INVALIDNETINTERFACES as $filter) {
                if (str_contains($interface, $filter)) {
                    return false;
                }
            }

            return true;
        });

        // Get the total IO Usage
        $IOUsage = [];

        foreach ($interfaces as $interface) {
            $tx1 = intval(file_get_contents('/sys/class/net/'.$interface.'/statistics/tx_bytes'));
            $rx1 = intval(file_get_contents('/sys/class/net/'.$interface.'/statistics/rx_bytes'));
            sleep($duration);
            $tx2 = intval(file_get_contents('/sys/class/net/'.$interface.'/statistics/tx_bytes'));
            $rx2 = intval(file_get_contents('/sys/class/net/'.$interface.'/statistics/rx_bytes'));

            $IOUsage[$interface]['download'] = round(($rx2 - $rx1) / 1048576, 2);
            $IOUsage[$interface]['upload'] = round(($tx2 - $tx1) / 1048576, 2);
        }

        $IOUsage['total']['download'] = array_sum(array_column($IOUsage, 'download'));
        $IOUsage['total']['upload'] = array_sum(array_column($IOUsage, 'upload'));

        return $IOUsage;
    }
}
