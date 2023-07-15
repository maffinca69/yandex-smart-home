<?php

namespace App\Http\Request;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Routing\Controller;

abstract class AbstractFormRequest extends Controller implements RequestInterface
{
    /**
     * @param Request $request
     * @throws ValidationException
     */
    public function __construct(Request $request)
    {
        $this->validate($request, $this->rules());
    }
}
