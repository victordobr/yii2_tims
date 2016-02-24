$(function () {
    var
        form = $('#form-record-reports-filter'),
        selectors = [
            '#record-filter_author_id',
            'input[name="Record[filter_created_at]"]',
            '#record-filter_created_at_from',
            '#record-filter_created_at_to',
            '#record-filter_bus_number',
        ];

    form.on('change', selectors.join(','), function (e) {
        e.preventDefault();
        $(this).parents('form').submit();
    });

    form.on('click', '.btn-reset', function(e){
        e.preventDefault();

        var form = $(this).parents('form');

        form[0].reset();
        form.submit();
    });
});