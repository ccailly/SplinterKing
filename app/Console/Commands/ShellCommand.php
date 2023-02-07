<?php

namespace App\Console\Commands;

use Exception;
use Symfony\Component\Process\Process;

class ShellCommand
{
    public static function execute($cmd): string
    {
        $process = Process::fromShellCommandline($cmd);

        $processOutput = '';

        $captureOutput = function ($type, $line) use (&$processOutput) {
            $processOutput .= $line;
        };

        $process->setTimeout(60)
            ->run($captureOutput);

        if ($process->getExitCode()) {
            $exception = new Exception($cmd . " - " . $processOutput);
            report($exception);

            throw $exception;
        }

        return $processOutput;
    }
}
