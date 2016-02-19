$("#record-save-changes").on("click", function(e){
    e.preventDefault();

    var attributes = '';

    $.each($(this).data('elements'), function (wrapper, selectors) {
        if (attributes.length > 0) {
            attributes += '&'
        }
        $.each(selectors, function (i, selector) {
            attributes += $(wrapper).find(selector).serialize();
        });
    });

    $.post(null, attributes, function (response) {
        if (!$.isEmptyObject(response['status']) && response['status'].length > 0) {
            $('#case-details').find('tr:nth-child(5) > td').text(response['status']);
        }
    }, 'json');

});