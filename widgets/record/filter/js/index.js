$(function () {
    var
        wrapper = $('#record-search-filter'),
        form = $('#form-record-search-filter-basic, #form-record-search-filter-advanced'),
        selectors = [
            '#record-filter_author_id',
            'input[name="Record[filter_created_at]"]',
            'input[name="Record[filter_status][]"]',
            '#record-filter_state',
            '#record-filter_created_at_from',
            '#record-filter_created_at_to',
            '#record-filter_elapsed_time_x_days',
            '#record-filter_case_number',
            '#record-filter_smart_search_text',
            'input[name="Record[filter_smart_search_type]"]'
        ];

    form.on('change', selectors.join(','), function () {
        var name = $(this).prop('name');

        if (name == 'Record[filter_created_at]' && $(this).val() == 3) { //todo: magic number
            $(this).parent('label').find('input[type="text"]').focus();
        } else if (name == 'Record[filter_smart_search_type]') {
            form.find('#record-filter_smart_search_text').focus();
        } else {
            $(this).parents('form').submit();
        }
    });

    form.on('click', '.btn-reset', function(e){
        e.preventDefault();

        var form = $(this).parents('form');

        form[0].reset();
        form.submit();
    });

    form.on('keyup', 'input[name="Record[X]"], #record-filter_elapsed_time_x_days, #record-filter_case_number', function (e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    wrapper.on('click', '.panel-subtitle > a', function(e){
        e.preventDefault();

        wrapper.find('.panel-section').toggleClass('hide');
    });

});