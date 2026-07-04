<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Vite;

class DebugHttpsDiagnosticsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $data = [
            'request_scheme' => $request->getScheme(),
            'request_is_secure' => $request->isSecure(),
            'request_host' => $request->getHost(),
            'app_url' => config('app.url'),
            'asset_url' => config('app.asset_url'),
            'app_env' => config('app.env'),
            'generated_home_url' => url('/'),
            'generated_route_home' => route('home'),
            'generated_appointments_url' => route('appointments.store'),
            'vite_css_example' => Vite::asset('resources/css/app.css'),
            'server_https' => $request->server('HTTPS'),
            'server_x_forwarded_proto' => $request->server('HTTP_X_FORWARDED_PROTO'),
            'server_x_forwarded_host' => $request->server('HTTP_X_FORWARDED_HOST'),
            'server_x_forwarded_port' => $request->server('HTTP_X_FORWARDED_PORT'),
            'server_x_forwarded_for' => $request->server('HTTP_X_FORWARDED_FOR'),
        ];

        // #region agent log
        $logLine = json_encode([
            'sessionId' => 'e5826c',
            'runId' => 'pre-fix',
            'hypothesisId' => 'A,B,C,D',
            'location' => 'DebugHttpsDiagnosticsController.php',
            'message' => 'HTTPS diagnostics snapshot',
            'data' => $data,
            'timestamp' => (int) (microtime(true) * 1000),
        ], JSON_UNESCAPED_SLASHES);

        @file_put_contents(base_path('debug-e5826c.log'), $logLine.PHP_EOL, FILE_APPEND | LOCK_EX);
        // #endregion

        return response()->json($data);
    }
}
