<?php

namespace App\Http\Responses\V1;

use Illuminate\Contracts\Support\Responsable;

class SuccessfulMessageResponse implements Responsable
{
    /** @var string */
    protected $message;

    /**
     * SuccessfulMessageResponse constructor.
     *
     * @param  string  $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * The response for a successful message. Normally used
     * when an action is being performed with success.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        return response()->json([
            'data' => [
                'message' => $this->message
            ],
        ], 200);
    }
}
