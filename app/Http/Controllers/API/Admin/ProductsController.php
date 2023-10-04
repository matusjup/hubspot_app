<?php

namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Services\HubSpotService;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function __construct(HubSpotService $hubspot)
    {
        $this->hubspot = $hubspot;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {

            switch( $request->filter['by'] ):
                case 'id':
                    $search = $request->filter['value'] ?? null;
                    $by = 'id';
                    break;
                case 'name':
                    $search = $request->filter['value'] ?? null;
                    $by = 'name';
                    break;
                default:
                    $search = null;
                    $by = null;
            endswitch;

            $products = $this->hubspot->getProducts( $search, $by );

            return response()->json([
                'products' => $products
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message'   => 'API Error Responses',
                'original'  => $e->getMessage()
            ], $e->getCode() != 0 ? $e->getCode() : 400 );

        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'nullable|numeric'
        ]);

        return $this->hubspot->createProduct( $request->only('name', 'price') );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'  => 'required|string',
            'price' => 'nullable|numeric'
        ]);

        return $this->hubspot->updateProduct( $id, $request->only('name', 'price') );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        return $this->hubspot->deleteProduct( $id );
    }
}
