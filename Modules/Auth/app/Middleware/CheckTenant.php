<?php

namespace Modules\Auth\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\Core\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;

class CheckTenant
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user?->tenant_id) {
            return response()->json([
                'message' => 'Tenant information is missing.',
            ], 403);
        }

        $tenant = Tenant::find($user->tenant_id);

        if (!$tenant || $tenant->status !== 'active') {
            return response()->json([
                'message' => 'Your tenant is not active or does not exist.',
            ], 403);
        }

        app()->instance('current.tenant', $tenant);
    
        return $next($request);
    }
}