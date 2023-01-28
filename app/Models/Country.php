<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\{
    Language,
    Category
};

class Country extends Model
{
    use HasFactory;

    protected $table = 'countries';
    public $timestamp = false;

    /**
     * Define a many-to-many relationship with the Category model.
     * This function returns the categories that are associated with the country through the 'countries_categories' table.
     * 
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'countries_categories');
    }

    /**
     * Define a many-to-many relationship with the Language model.
     * This function returns the languages that are associated with the country through the 'countries_laguages' table.
     * 
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'countries_languages');
    }
}
