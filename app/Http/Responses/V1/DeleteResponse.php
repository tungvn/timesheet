<?php

namespace App\Http\Responses\V1;

use Illuminate\Contracts\Support\Responsable;

class DeleteResponse implements Responsable
{
    /** @var string */
    protected $message;

    /**
     * DeleteResponse constructor.
     *
     * @param string $message
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * The patch Response. Patch responses must come with a message.
     * If no message provided please use or create a PutResponse
     * instead with a 204 No Content Status.
     *
     * @see https://jsonapi.org/format/#crud-deleting
     *
     * @param \Illuminate\Http\Request $request
     *
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
