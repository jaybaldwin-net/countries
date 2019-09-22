var new_country_validation = {
    'name' : '^.{3,45}$',
    'codes' : '^.{2,20}$',
    'capital' : '^.{3,45}$',
    'currencies' : '^.{1,45}$',
    'languages' : '^.{2,45}$',
    'dialling_codes' : '^.{1,8}$',
    'region' : '^.{2,45}$',
    'timezones' : '^-?\\d{1,2}.?\\d{1,2}?$',
}

var createError = function(error_message){
    $('#create_modal_error_message').find('span.error-text').text(error_message);
    $('#create_modal_error_message').fadeIn();
}

var validate = function(value, regex){
    var regex_object = new RegExp(regex);
    if(!regex_object.test(value)){
        return false;
    }
    return true;
}

window.buildSelect2s = function(){
    $.each($('.select2'), function(i, select){
        var options = {
            'width' : '100%',
        }
        if($(this).hasClass('multi')){
            options.tokenSeparators = [',', ' '];
        }
        if($(this).hasClass('tags')){
            options.tags = true;
        }
        if($(this).data('ajax')){
            options.ajax = {
                delay: 250,
                url: '/' + $(this).data('ajax') + '/get',
                dataType: 'json',
                processResults: function (data) {
                    var results = [];
                    $.each(data.items, function(i, item){
                        results.push({'id' : item, 'text' : item});
                    })
                    return {
                      'results': results
                    };
                  }
            }
        }
        $(select).select2(options);
    })
}

$(function(){

    buildSelect2s();


    $('#add_new_currency').on('click', function(){
        $('.new-currency-group').toggle();
    })

    $('#add_currency').on('click', function(){
        var data = {
            'name' : $('#currency_name').val(),
            'code' : $('#currency_code').val(),
            'symbol' : $('#currency_symbol').val(),
        };
        makeRequest('/currency/create', data, function(response){
            $('.new-currency-group :input').val('');
            $('.new-currency-group').toggle();
            var new_option = $("<option selected='selected'></option>").val(data.name).text(data.name)
            $('#country_currencies').append(new_option).trigger('change');

        });
    });


    $('#create_country_submit').on('click', function(){
        var data = {
            'name' : $('#country_name').val(),
            'codes' : $('#country_codes').val(),
            'capital' : $('#country_capital').val(),
            'currencies' : $('#country_currencies').val(),
            'languages' : $('#country_languages').val(),
            'dialling_codes' : $('#country_dialling').val(),
            'region' : $('#country_region').val(),
        }
        data.timezones = [];
        $.each($('.create-country-modal .slider-container:not(.clonable) input.timezones'), function(i, slider){
            data.timezones.push($(slider).val());
        });

        var pass = true;
        $.each(new_country_validation, function(key, regex){
            if(isset(data[key])){
                if(typeof(data[key]) == 'object'){
                    if(!data[key].length){
                        pass = false;
                    }
                    $.each(data[key], function(i, sub_value){
                        if(!validate(sub_value, regex)){
                            pass = false;
                        }
                    });
                }
                else{
                    if(!validate(data[key], regex)){
                        pass = false;
                    }
                }
            }
            else{
                pass = false;
            }
            if(!pass){
                createError('Please enter '+(key.charAt(key.length-1) != 's' ? 'a' : '')+' valid ' + key);
                return false;
            }
        })

        if(pass){

            makeRequest('/country/create', data, function(response){

                if(isset(response.success) && response.success){
                    $('.create-country-modal').modal('hide');
                }
                else{
                    var error_message = 'Unable to create country';
                    if(isset(response.error)){
                        error_message = response.error;
                    }
                    createError(error_message);
                }
            });

        }

    });

    $('.edit-country-modal').on('click', '#edit_country_submit', function(){
        var data = {
            'name' : $('#edit_country_name').val(),
            'codes' : $('#edit_country_codes').val(),
            'capital' : $('#edit_country_capital').val(),
            'currencies' : $('#edit_country_currencies').val(),
            'languages' : $('#edit_country_languages').val(),
            'dialling_codes' : $('#edit_country_dialling').val(),
            'region' : $('#edit_country_region').val(),
            'country_id' : $(this).data('country-id')
        }
        data.timezones = [];
        $.each($('.edit-country-modal .slider-container:not(.clonable) input.timezones'), function(i, slider){
            data.timezones.push($(slider).val());
        });

        var pass = true;
        $.each(new_country_validation, function(key, regex){
            if(isset(data[key])){
                if(typeof(data[key]) == 'object'){
                    if(!data[key].length){
                        pass = false;
                    }
                    $.each(data[key], function(i, sub_value){
                        if(!validate(sub_value, regex)){
                            pass = false;
                        }
                    });
                }
                else{
                    if(!validate(data[key], regex)){
                        pass = false;
                    }
                }
            }
            else{
                pass = false;
            }
            if(!pass){
                createError('Please enter '+(key.charAt(key.length-1) != 's' ? 'a' : '')+' valid ' + key);
                return false;
            }
        })

        if(pass){

            makeRequest('/country/submit_edit', data, function(response){

                if(isset(response.success) && response.success){
                    $('.edit-country-modal').modal('hide');
                }
                else{
                    var error_message = 'Unable to edit country';
                    if(isset(response.error)){
                        error_message = response.error;
                    }
                    createError(error_message);
                }
            });

        }

    });

    $('body').on('input','.slider', function(){
        $(this).parent().find('.slider-output').val($(this).val());
    });

    $('body').on('input', '.slider-output', function(){
        $(this).parent().find('.slider').val($(this).val());
    });


    $('#add_timezone').on('click', function(){
        var template = $(this).parent().find('.clonable');
        var clone = $(template).clone();
        clone.removeClass('clonable');
        $(clone).insertBefore(template).show();
    });
    $('#remove_timezone').on('click', function(){
        $(this).parent().find('.slider-container:not(.clonable)').last().remove();
    });

})
