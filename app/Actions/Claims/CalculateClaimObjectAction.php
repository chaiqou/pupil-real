<?php

namespace App\Actions\Claims;

use DateInterval;
use DateTime;

class CalculateClaimObjectAction
{
    public static function execute(array $validate)
    {

        $claimDates = [];

        // Get correct claims days and add each of them 1 day

        foreach ($validate['claims'] as $date) {
            $date = new DateTime($date);
            $date->add(new DateInterval('P1D'));
            $claimDates[] = $date->format('Y-m-d');
        }

        // Generates claims json for each days and also loops over claimables

        $claimJson = [];

        foreach ($claimDates as $date) {
            $claimables = [];

            foreach ($validate['claimables'] as $claimable) {
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
