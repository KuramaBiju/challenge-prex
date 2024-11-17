<?php

namespace App\Http\Middleware;

use App\Jobs\CreateLogService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response =  $next($request);

        $user = Auth::user();

        $serviceName = $this->getServiceName($request->path());

        CreateLogService::dispatch([
            'user_id' => $user ? $user->id : null,
            'service' => $serviceName,
            'body_request' => json_encode(array_merge($request->all(), $request->route()->parameters())),
            'http_status' => $response->getStatusCode(),
            'body_response' => json_encode(json_decode($response->getContent(), true)),
            'ip_address' => $request->ip(),
        ])->onQueue('createServiceLog');

        return $response;
    }

    private function getServiceName(string $path): string
    {
        $dictionaryPath = [
            'api/v1/login' => 'login',
            'api/v1/register' => 'save_user',
            'api/v1/gif/search/*' => 'search_gif_by_id',
            'api/v1/gif/search' => 'search_gif_by_phrase',
            'api/v1/gif/save' => 'save_gif'
        ];

        if (isset($dictionaryPath[$path])) {
            return $dictionaryPath[$path];
        }

        foreach ($dictionaryPath as $key => $name) {
            if (fnmatch($key, $path)) {
                return $name;
            }
        }

        return 'unknown';
    }
}
