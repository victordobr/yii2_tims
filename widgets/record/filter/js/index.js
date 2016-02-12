$(function () {
    var
        wrapper = $('#record-search-filter'),
        form = $('#form-record-search-filter-basic, #form-record-search-filter-advanced'),
        selectors = [
            '#record-filter_author_id',
            'input[name="Record[filter_created_at]"]',
            'input[name="Record[filter_status][]"]',
            '#record-filter_state',
        ];

    form.on('change', selectors.join(','), function () {
        if ($(this).prop('name') == 'Record[filter_created_at]' && $(this).val() == 3) {
            $(this).parent('label').find('input[type="text"]').focus();
        } else {
            $(this).parents('form').submit();
        }
    });

    form.on('keyup', 'input[name="Record[X]"], #record-filter_elapsed_time_x_days', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    wrapper.on('click', '.panel-subtitle > a', function(e){
        e.preventDefault();

        wrapper.find('.panel-section').toggleClass('hide');
    });

});