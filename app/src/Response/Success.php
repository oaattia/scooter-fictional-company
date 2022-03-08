<?php

namespace App\Response;

use OpenApi\Annotations as OA;

abstract class Success
{
    /**
     * @var boolean indicates if the request was successful
     * @OA\Property(example=true)
     */
    public $success = true;
}
