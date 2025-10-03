<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AuditLogger
{
    public static function log($message, $context = [])
    {
        Log::channel('audit')->info($message, $context);
    }
}
