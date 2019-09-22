

window.makeRequest = function (url, data, callback = function (response) { }, type ='POST') {
    $.ajax({
        cache: false,
        url: url,
        type: type,
        dataType: 'json',
        data: data,
        success: function (response) {
            callback(response);
        },
        error: function (error) {
            var result = {
                'success': false,
                'error': 'an unknown error orccured'
            };
            if (isset(error.responseText)) {
                result.details = error.responseText;
            }
            callback(result);
        }
    });
};

window.isset = function(value) {
	if(value != undefined && value != null) {
		return true;
	}
	else {
		return false;
	}
};

window.showError = function(error_message){
    $('#error_message').find('span.error-text').text(error_message);
    $('#error_message').fadeIn();
}

$(function(){
    $("[data-hide]").on("click", function(){
        $("." + $(this).attr("data-hide")).hide()
    })

    $("[data-toggle='toggle']").on("click", function(){
        $( $(this).attr("href")).toggle()
    })
});
