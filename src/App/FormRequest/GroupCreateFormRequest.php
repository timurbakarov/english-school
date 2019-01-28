<?php

namespace App\FormRequest;

use Illuminate\Foundation\Http\FormRequest;

class GroupCreateFormRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'price_per_hour' => 'required|integer|min:1',
            'schedule' => 'required',
        ];
    }
}
