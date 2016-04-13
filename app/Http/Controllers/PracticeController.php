<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PracticeController extends Controller {

    /**
    * Responds to requests to GET /practice/ex0
    */
    public function getEx0() {
        // update
        // switch cover image
        DB::table('books')
            ->where('author', 'LIKE', '%Scott%')
            ->update(['cover' => 'http://cdn.pastemagazine.com/www/system/images/photo_albums/greatgatsbycovers/large/photo_16696_1.jpeg?1384968217']);
    }

    

    /**
    * Responds to requests to GET /practice/ex1
    */
    public function getEx1() {
        return 'example 1';
        
    }




} #eoc