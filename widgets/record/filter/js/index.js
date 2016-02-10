$(function () {
    var
        form = $('#form-record-search-filter'),
        selectors = [
            '#record-user_id',
            'input[name="Record[filter_created_at]"]',
            'input[name="Record[filter_status][]"]'
        ];

    form.on('change', selectors.join(','), function () {
        if ($(this).prop('name') == 'Record[filter_created_at]' && $(this).val() == 3) {
            $(this).parent('label').find('input[type="text"]').focus();
        } else {
            $(this).parents('form').submit();
        }
    });

    form.on('keyup', 'input[name="Record[X]"]', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

});