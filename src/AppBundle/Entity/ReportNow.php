<?php

namespace AppBundle\Entity;

class ReportNow implements ReportInterface
{
    public function generateReport($benchmark, $date)
    {
        echo $date.' now report:'.'</br></br>';
        foreach($benchmark as $benchmark) {
            echo $benchmark->getTime().' '.$benchmark->getUrl().''.'</br>';
        }
        echo '</br>';
    }
}