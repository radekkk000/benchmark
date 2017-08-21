<?php

namespace AppBundle\Entity;

class ReportWeekly implements ReportInterface
{
    public function generateReport($benchmark, $date)
    {
        $report = 'weekly report';
        return $report;
    }

}