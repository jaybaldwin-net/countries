<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model{

    protected $table = 'currencies';
    protected $primaryKey = 'id';
	protected $fillable = ['name','code','symbol'];
    public $timestamps = false;
    //relationships
    public function countries(){
        return $this->belongsToMany(Country::class, 'countries_currencies_link', 'currency_id', 'country_id');
    }

}
