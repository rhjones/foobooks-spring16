@extends('layouts.master')

@section('title')
    Edit book: {{ $book->title }}
@stop

@section('head')
    <link href='/css/addauthor.css' rel='stylesheet'>
@stop

@section('content')

    <h1>Edit book {{ $book->title }}</h1>

    <form method='POST' action='/book/edit'>

        <input type='hidden' name='id' value='{{$book->id}}'>

        {{ csrf_field() }}

        <div class='form-group'>

          <!-- note the new syntax for retaining old form data:
               if there is old user input, use that; otherwise use data from the book entry in the database -->
           <label>Title:</label>
            <input
                type='text'
                id='title'
                name='title'
                value='{{ old('title') ? old('title') : $book->title }}'
            >
           <div class='error'>{{ $errors->first('title') }}</div>
        </div>

        <div class='form-group'>
           <label for='author_id'>Author:</label>
           <select name='author_id' id='author_id'>

               @foreach($authors_for_dropdown as $author_id => $author_name)
                    <option value='{{$author_id}}' {{ ($book->author_id == $author_id) ? 'SELECTED' : '' }}>
                        {{$author_name}}
                    </option>
                @endforeach

                    <!-- new option in the dropdown to add a new author -->
                    <option value="other" {{ (old('author_id') == 'other') ? 'SELECTED' : '' }}>Add new author</option>
           </select>
           <div class='error'>{{ $errors->first('author_id') }}</div>
        </div>


        <!-- add a new section to the form (#add_author) that contains the necessary fields to add a new author -->

        <div id="add_author">

          <p class="lead">Add a new author</p>

          <div class='form-group'>
             <label>First Name:</label>
             <input
                 type='text'
                 id='author_first'
                 name='author_first'
                 value='{{ old('author_first') }}'
             >
             <div class='error'>{{ $errors->first('author_first') }}</div>
          </div>

          <div class='form-group'>
             <label>Last Name:</label>
             <input
                 type='text'
                 id='author_last'
                 name='author_last'
                 value='{{ old('author_last') }}'
             >
             <div class='error'>{{ $errors->first('author_last') }}</div>
          </div>

          <div class='form-group'>
             <label>Birth Year:</label>
             <input
                 type='text'
                 id='author_year'
                 name='author_year'
                 value='{{ old('author_year') }}'
             >
             <div class='error'>{{ $errors->first('author_year') }}</div>
          </div>

          <div class='form-group'>
             <label>URL of Bio:</label>
             <input
                 type='text'
                 id='author_bio'
                 name='author_bio'
                 value='{{ old('author_bio') }}'
             >
             <div class='error'>{{ $errors->first('author_bio') }}</div>
          </div>

        </div>

        <div class='form-group'>
           <label>Published Year (YYYY):</label>
           <input
               type='text'
               id='published'
               name='published'
               value='{{ old('published') ? old('published') : $book->published }}'
           >
           <div class='error'>{{ $errors->first('published') }}</div>
        </div>

        <div class='form-group'>
           <label>URL of cover image:</label>
           <input
               type='text'
               id='cover'
               name='cover'
               value='{{ old('cover') ? old('cover') : $book->cover }}'
           >
           <div class='error'>{{ $errors->first('cover') }}</div>
        </div>

        <div class='form-group'>
           <label>URL to purchase this book:</label>
           <input
               type='text'
               id='purchase_link'
               name='purchase_link'
               value='{{ old('purchase_link') ? old('purchase_link') : $book->purchase_link }}'
           >
           <div class='error'>{{ $errors->first('purchase_link') }}</div>
        </div>

        <div class='form-instructions'>
            All fields are required
        </div>

        <button type="submit" class="btn btn-primary">Save changes</button>

        <div class='error'>
            @if(count($errors) > 0)
                Please correct the errors above and try again.
            @endif
        </div>

    </form>


@stop