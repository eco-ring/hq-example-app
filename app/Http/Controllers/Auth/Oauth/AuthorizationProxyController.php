<?php

namespace App\Http\Controllers\Auth\Oauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\ApproveAuthorizationController as PApprove;
use Laravel\Passport\Http\Controllers\AuthorizationController as PAuthorize;
use Laravel\Passport\Http\Controllers\DenyAuthorizationController as PDeny;

class AuthorizationProxyController extends Controller
{
    public function show(Request $request)
    {
        // (Hook) e.g., audit log before showing consent
        return app(PAuthorize::class)->authorize($request);
    }

    public function approve(Request $request)
    {
        // (Hook) e.g., massage scopes: $request->merge(['scopes' => array_values(array_unique($request->scopes ?? []))]);
        return app(PApprove::class)->approve($request);
    }

    public function deny(Request $request)
    {
        // (Hook) e.g., audit log denial
        return app(PDeny::class)->deny($request);
    }
}
