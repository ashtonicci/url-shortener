$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $("#url-form .btn-primary").click(function (e) {
        e.preventDefault();
        var url = $("input[name=full_url]").val();
        var description = $("input[name=description]").val();
        $.ajax({
            type: 'POST',
            url: "/urls",
            data: { full_url: url, description: description },
            success: function (data) {
                location.reload();
                $('<div class="alert alert-success"><span>success</span></div>').insertAfter('#url-form');
            },
            error: function (data) {
                var errors = data.responseJSON.errors;
                var errorsHtml = '<div class="alert alert-danger"><ul>';
                $.each(errors, function(key, value) 
                {
                    errorsHtml += '<li>'+value[0]+'</li>';
                });
                errorsHtml += '</ul></div>'
                $(errorsHtml).insertAfter('#url-form');
            } 
        });
    });
});