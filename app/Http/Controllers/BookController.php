<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller {

    /**
    * Responds to requests to GET /books
    */
    public function getIndex() {
        $books = \App\Book::all();
        return view('books.index')->with('books',$books);
    }

    /**
     * Responds to requests to GET /book/show/{title}
     */
    public function getShow($title) {

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
            'author' => 'required',
            'published' => 'required|min:4',
            'cover' => 'required|url',
            'purchase_link' => 'required|url',
        ]);

        // Mass Assignment
        $data = $request->only('title','author','published','cover','purchase_link');
        \App\Book::create($data);

        // Flash message
        \Session::flash('message','Your book was added');

        return redirect('/books');
    }

    /**
     * Responds to requests to GET /book/edit
     */
    public function getEdit($id) {
        $book = \App\Book::find($id);
        return view('books.edit')->with('book',$book);
    }

    /**
     * Responds to requests to POST /book/edit
     */
    public function postEdit(Request $request) {
        $book = \App\Book::find($request->id);
        $book->title = $request->title;
        $book->author = $request->author;
        $book->cover = $request->cover;
        $book->published = $request->published;
        $book->purchase_link = $request->purchase_link;
        $book->save();
        \Session::flash('message','Your changes were saved.');
        return redirect('/book/edit/'.$request->id);
    }

} #eoc