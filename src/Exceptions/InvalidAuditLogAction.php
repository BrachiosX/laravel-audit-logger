<?php

namespace BrachiosX\AuditLogger\Exceptions;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class InvalidAuditLogAction extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        Log::error(
            sprintf(
                "Cannot update audit-log information. \n[stacktrace]: %s",
                $this->getTraceAsString()
            )
        );

        abort(403, 'Cannot update audit log information');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return response(
            'Cannot update audit log information',
            Response::HTTP_FORBIDDEN
        );
    }
}
