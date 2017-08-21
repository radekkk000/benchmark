<?php

namespace AppBundle\Entity;
use AppBundle\Entity\Page;
use AppBundle\Entity\ReportContext;
use AppBundle\Entity\ReportInterface;
use AppBundle\Entity\ReportNow;
use AppBundle\Entity\Logger;
use AppBundle\Entity\CurlRequest;

class PageBenchmark
{
    private $basePage;
    private $competitors = array();
    private $currentBenchmark;

    function __construct($basePage, $competitors)
    {
        $this->basePage = $basePage;
        foreach($competitors as $competitor) {
            $this->competitors[] = $competitor;
        }
    }

    private function getUrlLoadingTime($url) {
        $curl = new CurlRequest();
        return $curl->getUrlLoadingTime($url);
    }

    private function isSlower($benchmark) {
        $base = $benchmark[0];

        foreach($benchmark as $bench)
        {
            if( $base->getTime() > $bench->getTime() )
            {
                return true;
            }
        }

        return false;
    }

    private function isTwiceSlower($benchmark) {
        $base = $benchmark[0];

        foreach($benchmark as $bench)
        {
            if( $base->getTime() > 2*$bench->getTime() )
            {
                return true;
            }
        }

        return false;
    }

    public function execute() {

        $basePage = new Page();
        $basePage->setUrl($this->basePage);
        $basePage->setTime($this->getUrlLoadingTime($this->basePage));

        $benchmark[] = $basePage;

        foreach($this->competitors as $comp) {
            $page = new Page();
            $page->setUrl($comp);
            $page->setTime($this->getUrlLoadingTime($comp));
            $benchmark[] = $page;
        }

        $this->currentBenchmarkDateTime = date("Y-m-d H:i:s");

        if( $this->isSlower($benchmark) ) {
            $mail = new Mail();
            $mail->send();
        }

        if( $this->isTwiceSlower($benchmark) ) {
            $sms = new Sms();
            $sms->send();
        }

        $this->writeLog($benchmark, $this->getCurrentBenchmarkDateTime());

        return $this->currentBenchmark = $benchmark;
    }

    private function writeLog($benchmark, $dateTime) {
        $logger = new Logger();
        $logger->writeToFile($benchmark, $dateTime);
    }

    /*
     * type - now, weekly, monthly
     */
    public function generateReport($type) {
        $strategy = new ReportContext($type);
        return $strategy->generateReport($this->getCurrentBenchmark(),$this->getCurrentBenchmarkDateTime());
    }

    /**
     * @return mixed
     */
    public function getCurrentBenchmark()
    {
        return $this->currentBenchmark;
    }

    /**
     * @param mixed $currentBenchmark
     */
    public function setCurrentBenchmark($currentBenchmark)
    {
        $this->currentBenchmark = $currentBenchmark;
    }
    private $currentBenchmarkDateTime;

    /**
     * @return mixed
     */
    public function getCurrentBenchmarkDateTime()
    {

        return $this->currentBenchmarkDateTime;
    }

    /**
     * @param mixed $currentBenchmarkDateTime
     */
    public function setCurrentBenchmarkDateTime($currentBenchmarkDateTime)
    {
        $this->currentBenchmarkDateTime = $currentBenchmarkDateTime;
    }

}