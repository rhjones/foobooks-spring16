<?php

use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{

    public function run()
    {
        DB::table('authors')->insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'first_name' => 'F. Scott',
        'last_name' => 'Fitzgerald',
        'birth_year' => 1896,
        'bio_url' => 'https://en.wikipedia.org/wiki/F._Scott_Fitzgerald',
        ]);

        DB::table('authors')->insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'first_name' => 'Sylvia',
        'last_name' => 'Plath',
        'birth_year' => 1932,
        'bio_url' => 'https://en.wikipedia.org/wiki/Sylvia_Plath',
        ]);

        DB::table('authors')->insert([
        'created_at' => Carbon\Carbon::now()->toDateTimeString(),
        'updated_at' => Carbon\Carbon::now()->toDateTimeString(),
        'first_name' => 'Maya',
        'last_name' => 'Angelou',
        'birth_year' => 1928,
        'bio_url' => 'https://en.wikipedia.org/wiki/Maya_Angelou',
        ]);

    }
}