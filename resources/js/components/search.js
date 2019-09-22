

var loading_html = '<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>';

var showResults = function(data, container){

    $(container).children().remove();
    if(Object.keys(data).length){
        $.each(data, function(id, name){
            var html = '<a class="dropdown-item show-country" href="#" data-country-id="'+id+'" >'+name+'</a>';
            $(container).append(html);
        })
    }
    else{
        var html = '<a class="dropdown-item show-country" href="#" >No Matching Countries</a>';
        $(container).append(html);
    }
    $(container).show();

}

var showSearchLoader = function(input){

    var icon = $(input).closest('.input-group').find('i.fa');
    icon.removeClass('fa-search');
    icon.addClass('fa-circle-notch');
    icon.addClass('fa-spin');

}

var hideSearchLoader = function(input){

    var icon = $(input).closest('.input-group').find('i.fa');
    icon.addClass('fa-search');
    icon.removeClass('fa-circle-notch');
    icon.removeClass('fa-spin');

}


$(function(){

    $('#country_search').on('keyup', function(e){
        $('#name_search_results').hide();
        var input = this
        var term = $(input).val();
        if(!term.length){
            $('#name_search_results').children().remove();
            hideSearchLoader(input);
            return false;
        }
        var data = {
            'term' : term
        };
        showSearchLoader(input);
        setTimeout(function(){
            if(term == $(input).val()){
                makeRequest('/search/name',data, function(response){
                    if(isset(response.success) && response.success && isset(response.data)){
                        if(term == $(input).val()){
                            hideSearchLoader(input);
                            showResults(response.data, '#name_search_results');
                        }

                    }
                    else{
                        var error_message = 'an unkown error occurred';
                        if(isset(response.error)){
                            error_message = response.error;
                        }
                        showError(error_message);
                    }
                });
            }
        }, 300);

    });

    $('body').on('click', 'a.show-country', function(e){
        e.preventDefault();
        if($(this).data('loading') != true){
            $(this).data('loading', true);
            $(this).append(loading_html);
            var that = this;
            var data = {
                'country_id' : $(this).data('country-id')
            };
            makeRequest('/country/edit', data, function(response){
                $(that).find('.spinner-grow').remove();
                $(that).data('loading', false);
                if(isset(response.success) && response.success && isset(response.html)){
                    $('.edit-country-modal').replaceWith(response.html);
                    $('.edit-country-modal').modal();
                    buildSelect2s();
                }
                else{
                    showError('unable to display country');
                }
            })
        }

    });

    $('#advanced_search').on('click', function(){

        var data = $(this).closest('form').serializeArray();

        makeRequest('/search/full', data, function(response){
            if(isset(response.success) && response.success && isset(response.data)){
                showResults(response.data, '#full_search_results');
            }
            else{
                alert('issue searching, please try again');
            }
        })


    });

});
