<?php

namespace App\Services;

class HubSpotService
{
    public function __construct()
    {
        $this->hubspot = $this->hubspot();
        $this->products = $this->hubspot->crm()->products();
        $this->productsBasicApi = $this->hubspot->crm()->products()->basicApi();
        $this->productInput = new \HubSpot\Client\Crm\Products\Model\SimplePublicObjectInput();
    }

    /**
     * Connect to HubSpot
     */
    private function hubspot()
    {
        $handlerStack = \GuzzleHttp\HandlerStack::create();
        $handlerStack->push(
            \HubSpot\RetryMiddlewareFactory::createRateLimitMiddleware(
                \HubSpot\Delay::getConstantDelayFunction()
            )
        );

        $handlerStack->push(
            \HubSpot\RetryMiddlewareFactory::createInternalErrorsMiddleware(
                \HubSpot\Delay::getExponentialDelayFunction(2)
            )
        );

        $client = new \GuzzleHttp\Client(['handler' => $handlerStack]);

        $response = \HubSpot\Factory::createWithAccessToken( config('services.hubspot.token') , $client);

        return $response;

    }

    /**
     * Private get filtered products
     */
    private function getFilteredProducts( string $search, string $by )
    {
        $filter = new \HubSpot\Client\Crm\Products\Model\Filter();
        $filter
            ->setOperator('CONTAINS_TOKEN')
            ->setPropertyName($by)
            ->setValue($search);

        $filterGroup = new \HubSpot\Client\Crm\Products\Model\FilterGroup();
        $filterGroup->setFilters([$filter]);

        $searchRequest = new \HubSpot\Client\Crm\Products\Model\PublicObjectSearchRequest();
        $searchRequest->setFilterGroups([$filterGroup]);

        $searchRequest->setProperties(['id', 'name']);

        return $this->hubspot->crm()->products()->searchApi()->doSearch( $searchRequest );
    }

    /**
     * Private get all products
     */
    private function getAllProducts()
    {
        $response = $this->productsBasicApi->getPage( 100 );

        return $response;
    }

    /**
     * Get products
     */
    public function getProducts( string $search = null, string $by = null )
    {
        if( isset( $search ) && isset( $by ) ):
            $response = $this->getFilteredProducts( $search, $by );
        else:
            $response = $this->getAllProducts();
        endif;

        return $response;
    }

    /**
     * Create product
     */
    public function createProduct(array $items)
    {
        try {

            $product_data = $this->productInput->setProperties([
                'name'  => $items['name'],
                'price' => $items['price'] ?? null
            ]);

            $new_product = $this->productsBasicApi->create( $product_data );

            return response()->json([
                'product' => $new_product
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'API Error Responses',
                'original' => $e->getMessage()
            ], $e->getCode() != 0 ? $e->getCode() : 400 );

        }
    }

    /**
     * Update Product
     */
    public function updateProduct(int $id, array $items)
    {
        try {

            $product_data = $this->productInput->setProperties([
                'name'  => $items['name'],
                'price' => $items['price'] ?? null
            ]);

            $update_product = $this->productsBasicApi->update( $id, $product_data );

            return response()->json([
                'product' => $update_product
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'API Error Responses',
                'original' => $e->getMessage()
            ], $e->getCode() != 0 ? $e->getCode() : 400 );

        }
    }

    /**
     * Delete product
     */
    public function deleteProduct(int $id)
    {
        try {

            $archive_product = $this->productsBasicApi->archive( $id );

            return response()->json([
                'product' => $archive_product
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => 'API Error Responses'
            ], $e->getCode() != 0 ? $e->getCode() : 400 );

        }
    }

}
