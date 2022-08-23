<?php

if (!function_exists('get_start_and_end_of_week')) {
    /**
     * @throws Exception
     */
    function get_start_and_end_of_week(string $currentDate): array
    {
        $currentDate = new DateTime($currentDate);
        $dayOfWeek   = $currentDate->format('w');
        $currentDate->modify('- '.(($dayOfWeek - 1 + 7) % 7).'days');
        $sunday = clone $currentDate;
        $sunday->modify('+ 6 days');

        return ['start_date' => $currentDate->format('Y-m-d'), 'end_date' => $sunday->format('Y-m-d')];
    }
}

