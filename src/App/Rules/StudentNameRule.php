<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class StudentNameRule implements Rule
{

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->correctNumberOfSegments($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string|array
     */
    public function message()
    {
        return 'Укажите Фамилию и Имя';
    }

    /**
     * @param $value
     * @return int
     */
    private function correctNumberOfSegments($value)
    {
        return count(explode(' ', $value)) == 2;
    }
}
