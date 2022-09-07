<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Session;

class Greeting
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('app.env') == 'production') {
            if (!Session::get('locale')) {
                $defaultLocale = 'en';

                try {
                    $client = new Client();

                    $response = $client->request('GET', "http://www.geoplugin.net/json.gp?ip=" . $request->ip());
        
                    $result = json_decode($response->getBody()->getContents(), true);

                    if ($result['geoplugin_countryCode'] == 'ID') {
                        $defaultLocale = 'id';
                    }

                } catch (\Throwable $th) {
                    //throw $th;
                }

                Session::put('locale', $defaultLocale);
            }
        }


        return $next($request);
    }
}
