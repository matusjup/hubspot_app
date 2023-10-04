<?php

namespace App\Http\Controllers;

use App\Services\HubSpotService;

class AdministrationController extends Controller
{
    public function __construct(HubSpotService $hubspot)
    {
        $this->hubspot = $hubspot;
    }

    /**
     * Home page admin
     */
    public function index()
    {
        $products = $this->hubspot->getProducts();

        return view('admin.home', [
            'products' => $products
        ]);
    }
}
