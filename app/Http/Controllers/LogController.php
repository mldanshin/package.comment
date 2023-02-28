<?php

namespace Danshin\Comment\Http\Controllers;

use Danshin\Comment\Http\Requests\LogRequest;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\Log;

final class LogController extends Controller
{
    public function __invoke(LogRequest $request): void
    {
        Log::error("Error frontend danshin comment. " . $request->message);
    }
}
