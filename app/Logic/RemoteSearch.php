<?php

namespace App\Logic;

use App\Models\Country;
use App\Models\Currency;
use App\Models\DiallingCode;
use App\Models\Language;
use App\Models\Region;
use App\Models\Timezone;

class RemoteSearch extends AbstractSearch{

    private $api;

    public function __construct(){
        $this->api = new RemoteRequest();
    }

    public function nameSearch($term){

        $remote_results = $this->api->nameSearch($term);
        return $this->storeCountries($remote_results);

    }

    public function codeSearch($term){

        $remote_results = $this->api->codeSearch($term);
        return $this->storeCountries($remote_results);

    }

    public function capitalSearch($term){

        $remote_results = $this->api->capitalSearch($term);
        return $this->storeCountries($remote_results);

    }

    public function currencySearch($term){

        $remote_results = $this->api->currencySearch($term);
        return $this->storeCountries($remote_results);

    }

    public function dialling_codeSearch($term){

        $remote_results = $this->api->dialling_codeSearch($term);
        return $this->storeCountries($remote_results);

    }

    public function regionSearch($term){

        $remote_results = $this->api->regionSearch($term);
        return $this->storeCountries($remote_results);

    }

    public function languageSearch($term){

        $remote_results = $this->api->languageSearch($term);
        return $this->storeCountries($remote_results);

    }

    private function storeCountries($countries){
        $results = Collect();
        if(is_array($countries)){
            foreach($countries as $country){

                $region = Region::firstOrCreate([
                    'name' => $country->region
                ]);

                $local_country = $region->countries()->firstOrCreate([
                    'name' => $country->name,
                    'capital' => $country->capital
                ]);
                $local_country->flag = $country->flag;

                $local_country->region()->firstOrCreate([
                    'name' => $country->region
                ]);
                $local_country->codes()->firstOrCreate([
                    'two_digit_code' => $country->alpha2Code,
                    'three_digit_code' => $country->alpha3Code
                ]);

                $local_country->currencies()->detach();
                foreach($country->currencies as $currency){
                    if($currency->name){
                        $currency_model = Currency::firstOrCreate([
                            'name'=> $currency->name,
                            'code'=>$currency->code,
                            'symbol'=> $currency->symbol
                        ]);

                        $local_country->currencies()->attach($currency_model->id);
                    }
                }
                foreach($country->callingCodes as $calling_code){
                    DiallingCode::firstOrCreate([
                        'code'=> $calling_code,
                        'country_id' => $local_country->id
                    ]);
                }
                $local_country->languages()->detach();
                foreach($country->languages as $language){
                    $language_model = Language::firstOrCreate([
                        'name' => $language->name,
                        'native_name' => $language->nativeName
                    ]);
                    $local_country->languages()->attach($language_model->id);
                }

                $local_country->timezones()->detach();
                foreach($country->timezones as $timezone){
                    $timezone_model = Timezone::firstOrCreate([
                        'name'=> $timezone
                    ]);
                    $local_country->timezones()->attach($timezone_model->id);
                }

                $local_country->save();

                $results->push($local_country);
            }
        }
        return $results;
    }

}
