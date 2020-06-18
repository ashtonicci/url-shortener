$(document).ready(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(".shortened-url").click(function (e) {
        e.preventDefault();
        var urlLink = $(this);
        var closestUrlCard = urlLink.closest('.url-card');
        var id = closestUrlCard.data('url-id');
        $.ajax({
            type: 'PATCH',
            url: "/urls/" + id,
            data: { id: id },
            success: function (data) {
               var timesUsedSpan = closestUrlCard.find('span.times-used');
               timesUsedSpan.text(data.times_used);
               window.open(urlLink.attr('href'));
            },
            error: function (data) {
                
            } 
        });
    });
});