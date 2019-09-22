<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model{

    protected $table = 'countries';
    protected $primaryKey = 'id';
	protected $fillable = ['name','capital', 'region_id', 'flag'];

    //relationships
    public function region() {
        return $this->hasOne(Region::class,'id','region_id');
    }

    public function timezones(){
        return $this->belongsToMany(Timezone::class, 'countries_timezones_link', 'country_id', 'timezone_id');
    }

    public function currencies(){
        return $this->belongsToMany(Currency::class, 'countries_currencies_link', 'country_id', 'currency_id');
    }

    public function languages(){
        return $this->belongsToMany(Language::class, 'countries_languages_link', 'country_id', 'language_id');
    }

    public function codes(){
        return $this->hasMany(CountryCode::class, 'country_id', 'id');
    }

    public function diallingCodes(){
        return $this->hasMany(DiallingCode::class, 'country_id', 'id');
    }



}
