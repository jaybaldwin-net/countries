<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Timezone extends Model{

    protected $table = 'timezones';
    protected $primaryKey = 'id';
	protected $fillable = ['name'];
    public $timestamps = false;
    //relationships
    public function countries(){
        return $this->belongsToMany(Country::class, 'countries_timezones_link', 'timezones_id', 'country_id');
    }

}
