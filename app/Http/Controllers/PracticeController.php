<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Book;

class PracticeController extends Controller {

    /***
    * Helper function to quickly output the results of $books from our various tests
    * For demo purposes we're echoing data out in the controller, but you
    * should not do this in projects or "real world" examples.
    */
    private function printBooks($books) {
        foreach($books as $book) {
            echo 'id:'.$book->id.' title: '.$book->title.'<br>';
        }
    }

    /**
    * Demonstrate association in a one to many relationship
    */
    public function getEx19() {
        # Create an author we can associate a book with...
        $author = new \App\Author;
        $author->first_name = 'J.K';
        $author->last_name = 'Rowling';
        $author->bio_url = 'https://en.wikipedia.org/wiki/J._K._Rowling';
        $author->birth_year = '1965';
        $author->save();
        dump($author->toArray());
        # Create a new book
        $book = new \App\Book;
        $book->title = "Harry Potter and the Philosopher's Stone";
        $book->published = 1997;
        $book->cover = 'http://prodimage.images-bn.com/pimages/9781582348254_p0_v1_s118x184.jpg';
        $book->purchase_link = 'http://www.barnesandnoble.com/w/harrius-potter-et-philosophi-lapis-j-k-rowling/1102662272?ean=9781582348254';
        $book->author()->associate($author); # <--- Associate the author with this book
        #$book->author_id = $author->id; # <--- Associate the author with this book
        $book->save();
        dump($book->toArray());
    }

    /**
    * Demonstrate importance of eager loading when querying for multiple items
    */
    public function getEx18() {
        # Eager loading
        $books = \App\Book::with('author')->get();
        foreach($books as $book) {
            echo $book->author->first_name.'<br>';
        }
    }
    /**
    * Demonstrate dynamic properties
    */
    public function getEx17() {
        $books = \App\Book::get();
        # Because "author" was not eagerly loaded, it will be dynamically fetched
        # for each iteration in this loop.
        foreach($books as $book) {
            echo $book->author->first_name.'<br>';
        }
    }
    /**
    * Collections
    */
    public function getEx16() {
        $books = Book::all();
        dump($books);
    }
    /**
    * Demonstrate using the Book model without prefixing with \App\Book
    * This works because of the use `App\Book;` statement at the top of this file
    */
    public function getEx15() {
        $books = Book::all();
        $this->printBooks($books);
    }
    /**
    * Practice from notes on Models:
    * Remove any books by the author “J.K. Rowling”
    */
    public function getEx14() {
        \App\Book::where('author','LIKE','J.K. Rowling')->delete();
        # Resulting SQL: delete from `books` where `author` LIKE 'J.K. Rowling'
        return 'Deleted all books where author like J.K. Rowling';
    }
    /**
    * Practice from notes on Models:
    * Find any books by the author Bell Hooks and update the author name to be bell hooks (lowercase).
    */
    public function getEx13() {
        # Approach # 1
        # Get all the books that match the criteria
        $books = \App\Book::where('author','=','Bell Hooks')->get();
        # Loop through each book and update them
        foreach($books as $book) {
            $book->author = 'bell hooks';
            $book->save();
        }
        # Resulting SQL:
        # Always:
        #   1) select * from `books` where `author` = 'Bell Hooks'
        # Only if there's something to update:
        #   2) update `books` set `updated_at` = '2016-04-12 18:46:04', `author` = 'bell hooks' where `id` = '8'
        # Approach #2
        \App\Book::where('author', '=', 'Bell Hooks')->update(['author' => 'bell hooks']);
        # Resulting SQL:
        # Always:
        #   1) update `books` set `author` = 'bell hooks', `updated_at` = '2016-04-12 18:44:46' where `author` = 'Bell Hooks'
        return '"Bell Hooks" => "bell hooks"';
    }
    /**
    * Practice from notes on Models:
    * Retrieve all the books in descending order according to published date
    */
    public function getEx12() {
        $books = \App\Book::orderBy('published','desc')->get();
        $this->printBooks($books);
        # Underlying SQL: select * from `books` order by `published` desc
    }
    /**
    * Practice from notes on Models:
    * Retrieve all the books in alphabetical order by title
    */
    public function getEx11() {
        $books = \App\Book::orderBy('title','asc')->get();
        $this->printBooks($books);
        # Underlying SQL: select * from `books` order by `title` asc
    }
    /**
    * Practice from notes on Models:
    * Retrieve all the books published after 1950
    */
    public function getEx10() {
        $books = \App\Book::where('published','>',1950)->get();
        $this->printBooks($books);
        # Underlying SQL: select * from `books` where `published` > '1950'
    }
    /**
    * Practice from notes on Models:
    * Show the last 5 books that were added to the books table
    */
    public function getEx9() {
        # Ref: https://laravel.com/docs/5.2/queries#ordering-grouping-limit-and-offset
        $books = \App\Book::orderBy('id', 'desc')->get()->take(5);
        $this->printBooks($books);
        # Underlying SQL: select * from `books` order by `id` desc
    }
    /**
    * Comparing get() and all()
    */
    public function getEx8() {
        # Get all the books
        $books = \App\Book::all();
        $this->printBooks($books);
        # get() without any query constraints is the equivalent of all()
        $books = \App\Book::get();
        $this->printBooks($books);
    }
    /**
    * Demonstrate deletion with the Book Model
    */
    public function getEx7() {
        # First get a book to delete
        $book = \App\Book::where('author', 'LIKE', '%Scott%')->first();
        # If we found the book, delete it
        if($book) {
            # Goodbye!
            $book->delete();
            return "Deletion complete; check the database to see if it worked...";
        }
        else {
            return "Can't delete - Book not found.";
        }
    }
    /**
    * Demonstrate updating with the Book Model
    */
    public function getEx6() {
        # First get a book to update
        $book = \App\Book::where('author', 'LIKE', '%Scott%')->first();
        # If we found the book, update it
        if($book) {
            # Give it a different title
            $book->title = 'The Really Great Gatsby';
            # Save the changes
            $book->save();
            echo "Update complete; check the database to see if your update worked...";
        }
        else {
            echo "Book not found, can't update.";
        }
    }
    /**
    * Demonstrate reading with the Book Model
    */
    public function getEx5() {
        $books = \App\Book::all();
        $this->printBooks($books);
    }
    /**
    * Demonstrate creation with the Book Model
    */
    public function getEx4() {
        # Instantiate a new Book Model object
        $book = new \App\Book();
        # Set the parameters
        # Note how each parameter corresponds to a field in the table
        $book->title = 'Harry Potter';
        $book->author = 'J.K. Rowling';
        $book->published = 1997;
        $book->cover = 'http://prodimage.images-bn.com/pimages/9780590353427_p0_v1_s484x700.jpg';
        $book->purchase_link = 'http://www.barnesandnoble.com/w/harry-potter-and-the-sorcerers-stone-j-k-rowling/1100036321?ean=9780590353427';
        # Invoke the Eloquent save() method
        # This will generate a new row in the `books` table, with the above data
        $book->save();
        return 'Added: '.$book->title;
    }
    /**
    * Demonstrate reading with a constraint with the QueryBuilder
    */
    public function getEx3() {
        # Use the QueryBuilder to get all the books where author is like "%Scott%"
        $books = \DB::table('books')->where('author', 'LIKE', '%Scott%')->get();
        # Output the results
        $this->printBooks($books);
    }
    /**
    * Demonstrate insertion with the QueryBuilder
    */
    public function getEx2() {
        // Use the QueryBuilder to insert a new row into the books table
        // i.e. create a new book
        \DB::table('books')->insert([
            'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'updated_at' => \Carbon\Carbon::now()->toDateTimeString(),
            'title' => 'The Great Gatsby',
            'author' => 'F. Scott Fitzgerald',
            'published' => 1925,
            'cover' => 'http://img2.imagesbn.com/p/9780743273565_p0_v4_s114x166.JPG',
            'purchase_link' => 'http://www.barnesandnoble.com/w/the-great-gatsby-francis-scott-fitzgerald/1116668135?ean=9780743273565',
        ]);
        return 'Added book.';
    }
    /**
    * Demonstrate reading with the QueryBuilder
    */
    public function getEx1() {
        # Use the QueryBuilder to get all the books
        $books = \DB::table('books')->get();
        $this->printBooks($books);

    }




} #eoc