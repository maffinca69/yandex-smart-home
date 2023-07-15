<?php

namespace App\Http\Request;

interface RequestInterface
{
    /**
     * @return array
     */
    public function rules(): array;
}
