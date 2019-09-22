<div class="modal fade create-country-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Create New Country</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="country_name" class="col-form-label">Name:</label>
                        <input type="text" class="form-control" id="country_name">
                    </div>
                    <div class="form-group">
                        <label for="country_codes" class="col-form-label">codes:</label>
                        <select class="form-control select2 multi tags" data-ajax='codes' multiple="multiple" id='country_codes'>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country_capital" class="col-form-label">Capital:</label>
                        <input type="text" class="form-control" id="country_capital">
                    </div>
                    <div class="form-group relative">
                        <label for="country_currencies" class="col-form-label">Currencies:</label>
                        <select class="form-control select2 multi" data-ajax='currencies' multiple="multiple" id='country_currencies'>
                        </select>
                        <div class='inner-icon' id='add_new_currency'>
                            <i class='fa fa-plus'></i>
                        </div>
                    </div>
                    <div class="form-group new-currency-group" style='display:none'>
                        <label for="currency_name" class="col-form-label">New Currency:</label>
                        <div class="container">
                            <div class="row">
                                <input class="col form-control" type="text" id="currency_name" placeholder="name">
                                <input class="col form-control" type="text" id="currency_code" placeholder="code">
                                <input class="col form-control" type="text" id="currency_symbol" placeholder="symbol">
                                <button id='add_currency' type="button" class="col btn btn-outline-primary">Add</button>
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="country_languages" class="col-form-label">Language:</label>
                        <select class="form-control select2 multi tags" data-ajax='languages' multiple="multiple" id='country_languages'>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country_dialling" class="col-form-label">Dialling Codes:</label>
                        <select class="form-control select2 multi tags" data-ajax='dialling-codes' multiple="multiple" id='country_dialling'>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country_region" class="col-form-label">Region:</label>
                        <select class="form-control select2 tags" data-ajax='regions' id='country_region'>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="country_timezones" class="col-form-label">Timezones (UTC offset):</label>
                        <div class="slider-container">
                            <input type="range" min="-12" max="14" value="0" step='0.25' class="slider timezones" id="country_timezones">
                            <input type="number" min="-12" max="14" class="form-control slider-output" value='0' id="country_timezone">
                        </div>
                        <div class="slider-container clonable" style='display:none'>
                            <input type="range" min="-12" max="14" value="0" step='0.25' class="slider timezones" >
                            <input type="number" min="-12" max="14" class="form-control slider-output" value='0'>
                        </div>
                        <button type="button" class="btn btn-outline-danger" id='remove_timezone'>Remove Timezone</button>
                        <button type="button" class="btn btn-outline-primary float-right" id='add_timezone'>Add Timezone</button>
                    </div>
                </form>
                <div class="alert alert-danger alert-dismissible" style='display:none' id='create_modal_error_message' role="alert">
                    <span class='error-text'></span>
                    <button type="button" class="close" data-hide="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-outline-primary" id='create_country_submit'>Create</button>
            </div>
        </div>
    </div>
</div>
