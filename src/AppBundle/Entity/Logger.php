<?php

namespace AppBundle\Entity;

class Logger
{
    const LOG_FILE = 'log.txt';

    public function writeToFile($benchmark, $currentBenchmarkDateTime) {
        file_put_contents(Logger::LOG_FILE, $currentBenchmarkDateTime.' '.print_r($benchmark, true), FILE_APPEND);
    }
}