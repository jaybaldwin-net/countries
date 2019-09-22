<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiallingCode extends Model{

    protected $table = 'dialling_codes';
    protected $primaryKey = 'id';
	protected $fillable = ['country_id','code'];
    public $timestamps = false;
    //relationships
    public function country() {
        return $this->hasOne(Country::class,'id','country_id');
    }


}
