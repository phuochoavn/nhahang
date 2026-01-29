<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTableSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->has('table')) {
            $tableId = $request->query('table');
            $table = \App\Models\Table::find($tableId);

            if ($table) {
                session(['table_id' => $table->id]);
                return redirect()->route('home'); // Remove query param
            }
        }

        if (! session()->has('table_id')) {
            // Should redirect to a "Scan QR" page, but for now just abort or show view
             return response()->view('scan-qr');
        }

        return $next($request);
    }
}
