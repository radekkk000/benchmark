<?php

namespace AppBundle\Entity;

class CurlRequest
{
    public function getUrlLoadingTime($url) {

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_exec($ch);

        if (!curl_errno($ch)) {
            $info = curl_getinfo($ch);
            $time = $info['total_time'];
        }

        curl_close($ch);

        return $time;
    }
}