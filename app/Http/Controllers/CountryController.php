<?php

namespace App\Http\Controllers;

use App\Logic\SearchInterface;
use App\Models\Country;
use App\Models\CountryCode;
use App\Models\Currency;
use App\Models\DiallingCode;
use App\Models\Language;
use App\Models\Region;
use App\Models\Timezone;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\View;

class CountryController extends BaseController{

    public function index(Request $request){
        return view('pages.index');

    }


    public function nameSearch(Request $request){

        $name = $request->input('term');

        $interface = new SearchInterface();
        $results = $interface->nameSearch($name);
        if(is_array($results)){
            return ['success' => true, 'data' => $results];
        }
        return ['success' => false, 'error' => 'invalid search result encountered'];

    }

    public function fullSearch(Request $request){

        $terms = $request->all();

        $interface = new SearchInterface();
        $results = $interface->fullSearch($terms);
        if(is_array($results)){
            return ['success' => true, 'data' => $results];
        }
        return ['success' => false, 'error' => 'invalid search result encountered'];

    }

    public function getCodes(Request $request){

        $term = $request->input('term');

        $codes = Collect();
        foreach(CountryCode::where('two_digit_code', 'like', '%'. $term. '%')->pluck('two_digit_code') as $code){
            $codes->push($code);
        }
        foreach(CountryCode::where('three_digit_code', 'like', '%'. $term. '%')->pluck('three_digit_code') as $code){
            $codes->push($code);
        }
        foreach(CountryCode::where('custom_code', 'like', '%'. $term. '%')->pluck('custom_code') as $code){
            $codes->push($code);
        }

        return ['items' => $codes->unique()];

    }


    public function getCurrencies(Request $request){

        $term = $request->input('term');

        $currencies = Collect();
        foreach(Currency::where('name', 'like', '%'. $term. '%')->pluck('name') as $currency){
            $currencies->push($currency);
        }
        foreach(Currency::where('code', 'like', '%'. $term. '%')->pluck('code') as $currency){
            $currencies->push($currency);
        }
        foreach(Currency::where('symbol', 'like', '%'. $term. '%')->pluck('symbol') as $currency){
            $currencies->push($currency);
        }

        return ['items' => $currencies->unique()];

    }


    public function getLanguages(Request $request){

        $term = $request->input('term');

        $languages = Language::where('name', 'like', '%'. $term. '%')->pluck('name');
        return ['items' => $languages->unique()];

    }

    public function getDiallingCodes(Request $request){

        $term = $request->input('term');

        $codes = DiallingCode::where('code', 'like', '%'. $term. '%')->pluck('code');
        return ['items' => $codes->unique()];

    }
    public function getRegions(Request $request){

        $term = $request->input('term');

        $regions = Region::where('name', 'like', '%'. $term. '%')->pluck('name');
        return ['items' => $regions->unique()];

    }

    private function safeCollectionCombine(Collection $orginal, Collection $new){
        if($orginal->count() && $new->count()){
            return $orginal->combine($new);
        }
        elseif($new->count()){
            return $new;
        }
        else{
            return $orginal;
        }
    }

    public function createCurrencies(Request $request){
        $input = $request->all();
        $currency = Currency::firstOrCreate($input);
        return ['success' => true];

    }


    public function createCountry(Request $request){
        $input = $request->all();

        $region = Region::firstOrCreate([
            'name' => $input['region']
        ]);

        $country = $region->countries()->firstOrCreate([
            'name' => $input['name'],
            'capital' => $input['capital']
        ]);

        foreach($input['codes'] as $code){
            $code_data = ['country_id' => $country->id];
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
            CountryCode::firstOrCreate($code_data);
        }

        $country->currencies()->detach();
        foreach($input['currencies'] as $currency){
            $match = Currency::where('name', $currency)->first();
            if(!isset($match->id)){
                $match = Currency::where('code', $currency)->first();
                if(!isset($match->id)){
                    $match = Currency::where('symbol', $currency)->first();
                }
            }
            if(isset($match->id)){
                $country->currencies()->attach($match->id);
            }
        }

        foreach($input['dialling_codes'] as $dialling_code){
            DiallingCode::firstOrCreate([
                'code' => $dialling_code,
                'country_id' => $country->id
            ]);
        }

        $country->languages()->detach();
        foreach($input['languages'] as $language){
            $language_model = Language::where('name', $language)->first();
            if(!isset($language_model->id)){
                $language_model = new Language();
                $language_model->name = $language;
                $language_model->native_name = $language;
                $language_model->save();
            }
            $country->languages()->attach($language_model->id);
        }

        $country->timezones()->detach();
        foreach($input['timezones'] as $timezone){
            $timezone_model = Timezone::firstOrCreate([
                'name' => 'UTC' . $timezone
            ]);
            $country->timezones()->attach($timezone_model->id);
        }

        $country->save();
        return ['success' => true];

    }

    public function performEditCountry(Request $request){
        $input = $request->all();

        $region = Region::firstOrCreate([
            'name' => $input['region']
        ]);

        $country = Country::find($request->input('country_id'));
        if(!isset($country->id)){
            return ['success' => false, 'error'=> 'unable to find country'];
        }
        $country->region_id = $region->id;

        CountryCode::where('country_id', $country->id)->delete();
        foreach($input['codes'] as $code){
            $code_data = ['country_id' => $country->id];
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
            CountryCode::firstOrCreate($code_data);
        }

        $country->currencies()->detach();
        foreach($input['currencies'] as $currency){
            $match = Currency::where('name', $currency)->first();
            if(!isset($match->id)){
                $match = Currency::where('code', $currency)->first();
                if(!isset($match->id)){
                    $match = Currency::where('symbol', $currency)->first();
                }
            }
            if(isset($match->id)){
                $country->currencies()->attach($match->id);
            }
        }

        DiallingCode::where('country_id', $country->id)->delete();
        foreach($input['dialling_codes'] as $dialling_code){
            DiallingCode::firstOrCreate([
                'code' => $dialling_code,
                'country_id' => $country->id
            ]);
        }

        $country->languages()->detach();
        foreach($input['languages'] as $language){
            $language_model = Language::where('name', $language)->first();
            if(!isset($language_model->id)){
                $language_model = new Language();
                $language_model->name = $language;
                $language_model->native_name = $language;
                $language_model->save();
            }
            $country->languages()->attach($language_model->id);
        }

        $country->timezones()->detach();
        foreach($input['timezones'] as $timezone){
            $timezone_model = Timezone::firstOrCreate([
                'name' => 'UTC' . $timezone
            ]);
            $country->timezones()->attach($timezone_model->id);
        }

        $country->save();
        return ['success' => true];

    }

    public function editCountry(Request $request){

        $country_id = $request->input('country_id');

        $country = Country::find($country_id);
        if(isset($country->id)){

            $html = View::make('modals.edit_country_modal', ['country'=> $country]);

            return ['success' => true, 'html' => $html->render()];

        }
        return ['succes' => false, 'error' => 'unable to find country'];

    }




}
