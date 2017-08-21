<?php

namespace AppBundle\Entity;

class ReportContext {

    private $strategy = NULL;

    public function __construct($strategy_ind_id) {
        switch ($strategy_ind_id) {
            case "now":
                $this->strategy = new ReportNow();
                break;
            case "weekly":
                $this->strategy = new ReportWeekly();
                break;
            case "monthly":
                $this->strategy = new ReportMonthly();
                break;
        }
    }

    public function generateReport($benchmark, $date) {
        return $this->strategy->generateReport($benchmark, $date);
    }
}