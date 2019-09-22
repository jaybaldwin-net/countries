
require('./bootstrap');

$(function(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $('body').data("token")
        }
    });

})

require('./components/utils')
require('./components/search')
require('./components/create')
