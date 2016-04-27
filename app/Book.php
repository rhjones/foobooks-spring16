<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = ['title','author_id','published','cover','purchase_link'];

    public function author() {
        # Book belongs to Author
        # Define an inverse one-to-many relationship.
        return $this->belongsTo('\App\Author');
    }

    public function tags()
	{
	    # With timestamps() will ensure the pivot table has its created_at/updated_at fields automatically maintained
	    return $this->belongsToMany('\App\Tag')->withTimestamps();
	}

}
