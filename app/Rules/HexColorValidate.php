<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class HexColorValidate implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! preg_match('/^#([a-f0-9]{6}|[a-f0-9]{3})$/i', $value)) {
            $fail('The value must be a valid hex color code (e.g., #FFAA00 or #abc).');
        }
    }
}
