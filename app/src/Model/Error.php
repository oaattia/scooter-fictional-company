<?php

namespace App\Model;

use OpenApi\Annotations as OA;

class Error
{
    /**
     * @var array unique error-code for the related error
     *
     * @OA\Property(type="object",
     *      @OA\Property(property="message", type= "string", example="This error occurred here", description="human-readable error-message"),
     *      @OA\Property(property="code", type= "string", example="E_XXXX", description="unique error-code for the related error")
     * )
     */
    public $error;

    /**
     * @var boolean indicates if the request failed
     * @OA\Property(example=false)
     */
    public $success = false;

    public function __construct(string $code, string $message) {
        $this->error = ['code' => $code, 'message' => $message];
    }
}
