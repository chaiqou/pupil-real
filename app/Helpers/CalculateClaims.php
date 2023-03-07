<?php

namespace App\Helpers;

use DateInterval;
use DateTime;

class CalculateClaims
{
    private $validate;

    public function __construct($validate)
    {
        $this->validate = $validate;
    }

    public function calculateClaimsJson()
    {
        $claimDates = [];

        // Get correct claims days and add each of them 1 day

        foreach ($this->validate['claims'] as $date) {
            $date = new DateTime($date);
            $date->add(new DateInterval('P1D'));
            $claimDates[] = $date->format('Y-m-d');
        }

        // Generates claims json for each days and also loops over claimables

        $claimJson = [];

        foreach ($claimDates as $date) {
            $claimables = [];

            foreach ($this->validate['claimables'] as $claimable) {
                $claimables[] = [
                    'name' => $claimable,
                    'claimed' => false,
                    'claimed_date' => null,
                    'menu' => '',
                    'menu_code' => null,
                ];
            }

            $claimJson[$date] = $claimables;
        }

        return [
            'claimDates' => $claimDates,
            'claimJson' => $claimJson,
        ];
    }
}
