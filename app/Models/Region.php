<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Region extends Model{

    protected $table = 'regions';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    public $timestamps = false;

    //relationships
    public function countries(){
        return $this->hasMany(Country::class, 'region_id', 'id');
    }

}
