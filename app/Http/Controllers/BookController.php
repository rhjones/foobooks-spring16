<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller {

    /**
    * Responds to requests to GET /books
    */
    public function getIndex() {
        return view('books.index');
    }

    /**
     * Responds to requests to GET /book/show/{title}
     */
    public function getShow($title) {

        // generates lorem ipsum text
        // creates sample users

        return view('books.show')->with('title', $title);

        // alternate method of passing data to view
        /*
        return view('books.show',[
            'title' => $title,
        ]);
        */
    }

    /**
     * Responds to requests to GET /book/create
     */
    public function getCreate() {
        return view('books.create');
    }

    /**
     * Responds to requests to POST /book/create
     */
    public function postCreate(Request $request) {
        $this->validate($request,[
            'title' => 'required|min:3',
            'author' => 'required'
        ]);
        return 'Add the book: '.$request->input('title');
        // return redirect('/books');
    }

} #eoc