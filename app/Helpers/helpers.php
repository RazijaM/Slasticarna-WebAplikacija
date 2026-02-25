<?php

if (! function_exists('format_km')) {
    /**
     * Format a numeric price as KM (BAM) with 2 decimals.
     * European format: comma for decimals, dot for thousands.
     * Example: 3517.41 -> "3.517,41 KM"
     */
    function format_km(?float $amount): string
    {
        return number_format((float) $amount, 2, ',', '.') . ' KM';
    }
}
