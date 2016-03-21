<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;

class PackageTestingController extends Controller {

    /**
    * Responds to requests to GET /packagetesting
    */
    public function getIndex() {

        $tomorrow = Carbon::now()->addDay();
        return $tomorrow->diffForHumans();
    }

    
} #eoc