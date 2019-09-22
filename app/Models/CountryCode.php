<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CountryCode extends Model{

    protected $table = 'country_codes';
    protected $primaryKey = 'id';
    protected $fillable = ['country_id','two_digit_code', 'three_digit_code', 'custom_code'];
    public $timestamps = false;

    //relationships
    public function country() {
        return $this->hasOne(Country::class,'id','country_id');
    }

    public function getCode(){
        if($this->two_digit_code){
            return $this->two_digit_code;
        }
        if($this->three_digit_code){
            return $this->three_digit_code;
        }
        return $this->custom_code;
    }


}
