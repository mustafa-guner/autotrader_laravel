<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ExpirationDate implements Rule
{
    /**
     * Determine if the validation rule passes.
     */
    public function passes($attribute, $value): bool
    {
        // Check the format first
        if (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $value)) {
            return false; // Invalid format
        }

        // Split the expiration date into month and year
        [$month, $year] = explode('/', $value);

        // Get the current year and month
        $currentYear = Carbon::now()->format('y');
        $currentMonth = Carbon::now()->format('m');

        // Check if the month is valid (01-12)
        if ((int)$month < 1 || (int)$month > 12) {
            return false; // Month out of valid range
        }

        // Convert year to a full year (e.g., "24" becomes "2024")
        $fullYear = '20' . $year;

        // Check if the expiration date is in the past
        if ($fullYear < Carbon::now()->year ||
            ($fullYear == Carbon::now()->year && (int)$month < (int)$currentMonth)) {
            return false; // Expiration date is in the past
        }

        return true; // Valid expiration date
    }

    /**
     * Get the validation error message.
     */
    public function message(): string
    {
        return 'The expiration date must be a valid future date and the month must be between 01 and 12.';
    }
}
