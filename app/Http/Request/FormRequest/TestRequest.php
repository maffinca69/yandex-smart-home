<?php

namespace App\Http\Request\FormRequest;

use App\Http\Request\AbstractFormRequest;

class TestRequest extends AbstractFormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
//            'id' => 'required|int'
        ];
    }
}
