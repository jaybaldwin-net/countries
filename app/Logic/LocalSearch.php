<?php

namespace App\Logic;

use App\Models\Country;
use App\Models\CountryCode;
use App\Models\Currency;
use App\Models\DiallingCode;
use App\Models\Language;
use App\Models\Region;

class LocalSearch extends AbstractSearch{

    public function nameSearch($term){

        $matches = Country::where('name', 'like', '%'.$term.'%')->get();
        return $matches;

    }

    public function capitalSearch($term){

        $matches = Country::where('capital', 'like', '%'.$term.'%')->get();
        return $matches;

    }


    public function codeSearch($code){
        $code_data =[];
        switch (strlen($code)) {
            case 2:
                $code_data['two_digit_code'] = $code;
                break;
            case 3:
                $code_data['three_digit_code'] = $code;
                break;
            default:
                $code_data['custom_code'] = $code;
                break;
        }
        $code_matches = CountryCode::where($code_data)->get();
        $matches = collect();
        foreach($code_matches as $match){
            $countries = $match->countries()->get();
            foreach($countries as $country){
                $matches->push($country);
            }
        }
        return $matches;
    }

    public function currencySearch($term){
        $currency_matches = Currency::where(function($query) use ($term){
            $query->where('name', 'like', '%'.$term. '%')
                ->orWhere('code', 'like', '%'.$term. '%')
                ->orWhere('symbol', 'like','%'.$term.'%' );
        })->get();
        $matches = collect();
        foreach($currency_matches as $match){
            $countries = $match->countries()->get();
            foreach($countries as $country){
                $matches->push($country);
            }
        }
        return $matches;
    }

    public function dialling_codeSearch($term){
        $code_matches = DiallingCode::where('code', 'like', '%'.$term. '%')->get();
        $matches = collect();
        foreach($code_matches as $match){
            $country = $match->country()->first();
            if(isset($country->id)){
                $matches->push($country);
            }
        }
        return $matches;
    }
    public function regionSearch($term){
        $region_matches = Region::where('name', 'like', '%'.$term. '%')->get();
        $matches = collect();
        foreach($region_matches as $match){
            $countries = $match->countries()->get();
            foreach($countries as $country){
                $matches->push($country);
            }
        }
        return $matches;
    }

    public function languageSearch($term){
        $language_matches = Language::where('name', 'like', '%'.$term. '%')->get();
        $matches = collect();
        foreach($language_matches as $match){
            $countries = $match->countries()->get();
            foreach($countries as $country){
                $matches->push($country);
            }
        }
        return $matches;
    }

}
