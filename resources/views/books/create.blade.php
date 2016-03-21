@extends('layouts.master')

@section('title')
    Add a new book
@stop

@section('content')

    <h1>Add a new book</h1>

    <form method='POST' action='/book/create'>

        {{ csrf_field() }}

        <div class='form-group'>
           <label>* Title:</label>
           <input
               type='text'
               id='title'
               name='title'
               value='{{ old('title') }}'
           >
           <div class='error'>{{ $errors->first('title') }}</div>
        </div>

        <div class='form-group'>
           <label>* Author:</label>
           <input
               type='text'
               id='author'
               name='author'
               value='{{ old('author') }}'
           >
           <div class='error'>{{ $errors->first('author') }}</div>
        </div>

        <button type="submit" class="btn btn-primary">Add book</button>

        {{--
        <ul class=''>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        --}}

        <div class='error'>
            @if(count($errors) > 0)
                Please correct the errors above and try again.
            @endif
        </div>

    </form>


@stop