<div class="modal fade edit-country-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="edit_country_name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="edit_country_name" @if(isset($country->name)) value='{{$country->name}}' @endif >
                    </div>
                    <div class="form-group">
                        <label for="edit_country_codes" class="col-form-label">codes:</label>
                        <select class="form-control select2 multi tags" data-ajax='codes' multiple="multiple" id='edit_country_codes'>
                            @if($country != false && $country->codes()->count())
                                @foreach($country->codes()->get() as $code)
                                    <option value='{{$code->getCode()}}' selected='selected'>{{$code->getCode()}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_country_capital" class="col-form-label">Capital:</label>
                        <input type="text" class="form-control" id="edit_country_capital" @if(isset($country->capital)) value='{{$country->capital}}' @endif>
                    </div>
                    <div class="form-group relative">
                        <label for="edit_country_currencies" class="col-form-label">Currencies:</label>
                        <select class="form-control select2 multi" data-ajax='currencies' multiple="multiple" id='edit_country_currencies'>
                            @if($country != false)
                                @foreach($country->currencies()->get() as $currency)
                                    <option value='{{$currency->name}}' selected='selected'>{{$currency->name}}</option>
                                @endforeach
                            @endif
                        </select>
                        <div class='inner-icon' id='add_new_currency'>
                            <i class='fa fa-plus'></i>
                        </div>
                    </div>
                    <div class="form-group new-currency-group" style='display:none'>
                        <label for="cedit_urrency_name" class="col-form-label">New Currency:</label>
                        <div class="container">
                            <div class="row">
                                <input class="col form-control" type="text" id="edit_currency_name" placeholder="name">
                                <input class="col form-control" type="text" id="edit_currency_code" placeholder="code">
                                <input class="col form-control" type="text" id="edit_currency_symbol" placeholder="symbol">
                                <button id='edit_add_currency' type="button" class="col btn btn-outline-primary">Add</button>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="edit_country_languages" class="col-form-label">Language:</label>
                        <select class="form-control select2 multi tags" data-ajax='languages' multiple="multiple" id='edit_country_languages'>
                            @if($country != false)
                                @foreach($country->languages()->get() as $language)
                                    <option value='{{$language->name}}' selected='selected'>{{$language->name}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cedit_ountry_dialling" class="col-form-label">Dialling Codes:</label>
                        <select class="form-control select2 multi tags" data-ajax='dialling-codes' multiple="multiple" id='edit_country_dialling'>
                            @if($country != false)
                                @foreach($country->diallingCodes()->get() as $dialling_code)
                                    <option value='{{$dialling_code->code}}' selected='selected'>{{$dialling_code->code}}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_country_region" class="col-form-label">Region:</label>
                        <select class="form-control select2 tags" data-ajax='regions' id='edit_country_region'>
                            @if($country != false)
                                @if(isset($country->region()->first()->id))
                                    <option value='{{$country->region()->first()->name}}' selected='selected'>{{$country->region()->first()->name}}</option>
                                @endif
                            @endif
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_country_timezones" class="col-form-label">Timezones (UTC offset):</label>
                        @if($country != false)
                            @foreach($country->timezones()->get() as $timezone)
                                <div class="slider-container">
                                    <input type="range" min="-12" max="14" value="{{str_replace('UTC', '', str_replace(':', '.', $timezone->name))}}" step='0.25' class="slider timezones" id="edit_country_timezones">
                                    <input type="number" min="-12" max="14" class="form-control slider-output" value='{{str_replace('UTC', '', str_replace(':', '.', $timezone->name))}}' id="edit_country_timezone">
                                </div>
                            @endforeach
                        @else
                            <div class="slider-container">
                                <input type="range" min="-12" max="14" value="0" step='0.25' class="slider timezones" id="edit_country_timezones">
                                <input type="number" min="-12" max="14" class="form-control slider-output" value='0' id="edit_country_timezone">
                            </div>
                        @endif
                        <div class="slider-container clonable" style='display:none'>
                            <input type="range" min="-12" max="14" value="0" step='0.25' class="slider timezones" >
                            <input type="number" min="-12" max="14" class="form-control slider-output" value='0'>
                        </div>
                        <button type="button" class="btn btn-outline-danger" id='remove_timezone'>Remove Timezone</button>
                        <button type="button" class="btn btn-outline-primary float-right" id='add_timezone'>Add Timezone</button>
                    </div>
                    <div class="form-group">
                        <label for="country-flag" class="col-form-label">Flag:</label>
                        @if($country != false)
                            <img class='col' src='{{$country->flag}}'/>
                        @endif
                    </div>
                </form>
                <div class="alert alert-danger alert-dismissible" style='display:none' id='edit_modal_error_message' role="alert">
                    <span class='error-text'></span>
                    <button type="button" class="close" data-hide="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" @if($country != false) data-country-id='{{$country->id}}' @endif id='edit_country_submit'>Edit</button>
            </div>
        </div>
    </div>
</div>
