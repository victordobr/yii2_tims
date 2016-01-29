$(function () {
    var
        selectors = [
            '#record-user_id',
            'input[name="Record[filter_created_at]"]',
            'input[name="Record[filter_status][]"]'
        ];

    $('#form-record-search-filter').on('change', selectors.join(','), function () {
        $(this).parents('form').submit();
    });
});