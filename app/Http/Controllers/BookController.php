<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller {

    /**
    * Responds to requests to GET /books
    */
    public function getIndex() {
        $books = \App\Book::with('author')->orderBy('id','desc')->get();
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
        $authors_for_dropdown = \App\Author::authorsForDropdown();
        $tags_for_checkboxes = \App\Tag::getTagsForCheckboxes();
        return view('books.create')
            ->with('authors_for_dropdown', $authors_for_dropdown)
            ->with('tags_for_checkboxes', $tags_for_checkboxes);
    }

    /**
     * Responds to requests to POST /book/create
     */
    public function postCreate(Request $request) {
        $this->validate($request,[
            'title' => 'required|min:3',
            'author_id' => 'required',
            'published' => 'required|min:4',
            'cover' => 'required|url',
            'purchase_link' => 'required|url',
            'author_first' => 'required_if:author_id,other',
            'author_last' => 'required_if:author_id,other',
            'author_year' => 'required_if:author_id,other|digits:4',
            'author_bio' => 'required_if:author_id,other|active_url',
        ]);


        // Mass Assignment
        // $book = \App\Book::create([
        //     'title' => $request->title,
        //     'published' => $request->published,
        //     'cover' => $request->cover,
        //     'purchase_link' => $request->purchase_link,
        //     ]);

        $book = new \App\Book;
        $book->title = $request->title;
        $book->published = $request->published;
        $book->cover = $request->cover;
        $book->purchase_link = $request->purchase_link;

        if($request->author_id == 'other') {

            $author = new \App\Author;
            $author->first_name = $request->author_first;
            $author->last_name = $request->author_last;
            $author->birth_year = $request->author_year;
            $author->bio_url = $request->author_bio;
            $author->save();

            // set the book's author to be this newly aded author
            $book->author()->associate($author);

        } else {

            // otherwise, just set the book's author id to the author_id chosen from the dropdown menu
            $book->author_id = $request->author_id;
        }

        $book->save();

        // sync tags
        if($request->tags) {
            $tags = $request->tags;
        }
        else {
            $tags = [];
        }
        $book->tags()->sync($tags);

        // Flash message
        \Session::flash('message','Your book was added');

        return redirect('/books');
    }

    /**
     * Responds to requests to GET /book/edit
     */
    public function getEdit($id) {
        $book = \App\Book::with('tags')->find($id);

        $tags_for_checkboxes = \App\Tag::getTagsForCheckboxes();

        $tags_for_this_book = [];
        foreach($book->tags as $tag) {
            $tags_for_this_book[] = $tag->id;
        }

        $authors_for_dropdown = \App\Author::authorsForDropdown();

        return view('books.edit')
            ->with([
                'book' => $book,
                'authors_for_dropdown' => $authors_for_dropdown,
                'tags_for_checkboxes' => $tags_for_checkboxes,
                'tags_for_this_book' => $tags_for_this_book,
            ]);
    }

    /**
     * Responds to requests to POST /book/edit
     */
    public function postEdit(Request $request) {

        /* set up validation logic
         * using 'required_if' to required author fields when author_id is set to 'other'
         * https://laravel.com/docs/5.2/validation#rule-required-if
         * if 'other' is selected from the author dropdown, then:
         *  - require a first and last name, birth year, and bio URL
         *  - author_year must be four digits long
         *  - bio URL must be a valid URL
         */

        $this->validate($request,[
            'title' => 'required|min:3',
            'author_id' => 'required',
            'published' => 'required|min:4',
            'cover' => 'required|url',
            'purchase_link' => 'required|url',
            'author_first' => 'required_if:author_id,other',
            'author_last' => 'required_if:author_id,other',
            'author_year' => 'required_if:author_id,other|digits:4',
            'author_bio' => 'required_if:author_id,other|active_url',
        ]);

        
        $book = \App\Book::find($request->id);
        $book->title = $request->title;


        // if author_id is 'other', save a new book
        if($request->author_id == 'other') {

            $author = new \App\Author;
            $author->first_name = $request->author_first;
            $author->last_name = $request->author_last;
            $author->birth_year = $request->author_year;
            $author->bio_url = $request->author_bio;
            $author->save();

            // set the book's author to be this newly aded author
            $book->author()->associate($author);

        } else {

            // otherwise, just set the book's author id to the author_id chosen from the dropdown menu
            $book->author_id = $request->author_id;
        }

        $book->cover = $request->cover;
        $book->published = $request->published;
        $book->purchase_link = $request->purchase_link;
        
        // sync tags
        if($request->tags) {
            $tags = $request->tags;
        }
        else {
            $tags = [];
        }
        $book->tags()->sync($tags);

        $book->save();
        \Session::flash('message','Your changes were saved.');
        return redirect('/book/edit/'.$request->id);

    }

} #eoc