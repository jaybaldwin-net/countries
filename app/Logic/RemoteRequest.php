<?php

namespace App\Logic;

class RemoteRequest {

    private $base_url = 'https://restcountries.eu/rest/v2/';

    private function makeRequest($url){
        $url = $this->base_url . $url;
        $curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_HTTPGET, true);

        $response = curl_exec($curl);
		curl_close($curl);
        if (!empty($response)) {
			$response = json_decode($response);
			return $response;
		}
		return false;

    }

    public function nameSearch($name){
        $url = 'name/' . $name;
        return $this->makeRequest($url);
    }

    public function codeSearch($name){
        $url = 'alpha/' . $name;
        return $this->makeRequest($url);
    }

    public function capitalSearch($name){
        $url = 'capital/' . $name;
        return $this->makeRequest($url);
    }

    public function currencySearch($name){
        $url = 'currency/' . $name;
        return $this->makeRequest($url);
    }

    public function dialling_codeSearch($name){
        $url = 'callingcode/' . $name;
        return $this->makeRequest($url);
    }

    public function regionSearch($name){
        $url = 'region/' . $name;
        return $this->makeRequest($url);
    }

    public function languageSearch($name){
        $url = 'lang/' . $name;
        return $this->makeRequest($url);
    }

}
