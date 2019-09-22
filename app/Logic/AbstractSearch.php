<?php

namespace App\Logic;


class AbstractSearch{

    public function nameSearch($term){return [];}
    public function abstactSearch($term, $value){
        $results = Collect();
        if(strlen($value)){
            $method_name =$term . 'Search';
            if(method_exists($this, $method_name)){
                $sub_results = $this->{$method_name}($value);
                foreach($sub_results as $sub_result){
                    $results->push($sub_result);
                }
            }
            else{
                print '<pre>';
                print_r($method_name);
                print '<pre>';
                exit;
            }
        }
        return $results;
    }

}
