<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $admin_index_route;

    public function __construct( $admin_index_route = 'admin.index' ) {
        $this->admin_index_route = $admin_index_route;
    }
}
