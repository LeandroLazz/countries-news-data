<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Country;

class Language extends Model
{
    use HasFactory;

    protected $table = 'languages';
    public $timestamp = false;

    /**
     * Define a many-to-many relationship with the Country model.
     * This function returns the countries that are associated with the language through the 'countries_laguages' table.
     * 
     */
    public function countries()
    {
        return $this->belongsToMany(Country::class, 'countries_languages');
    }
}
