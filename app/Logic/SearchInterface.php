<?php

namespace App\Logic;

class SearchInterface {

    private $search_control = [
        'local',
        'remote'
    ];

    private $search_objects = [];

    public function __construct(){

        foreach($this->search_control as $search_type){

            $target = 'App\Logic\\'.ucfirst($search_type).'Search';
			if(class_exists($target)){
				$this->search_objects[] = new $target();
			}

        }

    }


    public function nameSearch($term){
        $results = Collect();
        if(strlen($term)){
            foreach($this->search_objects as $search_object){
                $results = $search_object->nameSearch($term);
                if($results->count()){
                   break;
                }
            }
        }
        return $results->unique()->pluck('name', 'id')->toArray();
    }

    public function fullSearch($terms){
        $results = Collect();
        foreach($terms as $term => $value){
            if(strlen($value)){
                foreach($this->search_objects as $search_object){
                    $sub_results = $search_object->abstactSearch($term, $value);
                    if($sub_results->count()){
                        foreach($sub_results as $sub_result){
                            $results->push($sub_result);
                        }
                        break;
                    }
                }
            }
        }
        return $results->unique()->pluck('name', 'id')->toArray();
    }


}
