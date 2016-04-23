<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title','author','published','cover','purchase_link'];

    public function author() {
        # Book belongs to Author
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('\App\Author');
    }

}
