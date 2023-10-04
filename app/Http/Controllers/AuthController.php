<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Index login
     */
    public function index()
    {
        // $handlerStack = \GuzzleHttp\HandlerStack::create();
        // $handlerStack->push(
        //     \HubSpot\RetryMiddlewareFactory::createRateLimitMiddleware(
        //         \HubSpot\Delay::getConstantDelayFunction()
        //     )
        // );

        // $handlerStack->push(
        //     \HubSpot\RetryMiddlewareFactory::createInternalErrorsMiddleware(
        //         \HubSpot\Delay::getExponentialDelayFunction(2)
        //     )
        // );

        // $client = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        // $hubspot = \HubSpot\Factory::createWithAccessToken( config('services.hubspot.token') , $client);

        // $response = $hubspot->crm()->products()->basicApi()->getPage();


        // // Filter
        // $search = 'DELL';

        // $filter = new \HubSpot\Client\Crm\Products\Model\Filter();
        // $filter
        //     ->setOperator('CONTAINS_TOKEN')
        //     ->setPropertyName('name')
        //     ->setValue($search);

        // $filterGroup = new \HubSpot\Client\Crm\Products\Model\FilterGroup();
        // $filterGroup->setFilters([$filter]);

        // $searchRequest = new \HubSpot\Client\Crm\Products\Model\PublicObjectSearchRequest();
        // $searchRequest->setFilterGroups([$filterGroup]);

        // // Get specific properties
        // $searchRequest->setProperties(['id', 'name']);

        // $products = $hubspot->crm()->products()->searchApi()->doSearch($searchRequest);

        // dd( $response, $filter, $products );

        return view('auth.login');
    }

    /**
     * Login method
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password'  => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if( Auth::attempt( $credentials ) ):

            User::whereId( Auth::user()->id )->update([ 'api_token' => Str::random(80) ]);

            $request->session()->regenerate();

            return redirect()->route( $this->admin_index_route )->withSuccess('Prihlásenie bolo úspešné.');

        endif;

        return redirect()->route('login-page')->withErrors([ 'error_login' => 'Prihlásenie bolo neúspešné!' ]);
    }

    /**
     * Logout method
     */
    public function logout()
    {
        Session::flush();
        Auth::logout();

        return redirect()->route('login-page');
    }
}
