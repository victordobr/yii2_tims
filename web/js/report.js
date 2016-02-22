$(function () {
    var
        form = $('#form-record-reports-filter'),
        selectors = [
            'input[name="Record[filter_created_at]"]',
            '#record-filter_created_at_from',
            '#record-filter_created_at_to',
        ];
    console.log(123);
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