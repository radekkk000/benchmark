<?php

namespace AppBundle\Entity;

interface ReportInterface {
    public function generateReport($benchmark, $date);
}