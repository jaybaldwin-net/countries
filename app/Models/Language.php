<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model{

    protected $table = 'languages';
    protected $primaryKey = 'id';
	protected $fillable = ['name','native_name'];
    public $timestamps = false;
    //relationships
    public function countries(){
        return $this->belongsToMany(Country::class, 'countries_languages_link', 'language_id', 'country_id');
    }

}
