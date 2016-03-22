$(function () {

    var
        submit = $('#record-save-changes'),
        wrapper = $(submit.data('wrapper')),
        forms = submit.data('forms');


    submit.on('click', function (e) {
        e.preventDefault();

        $(forms.join(',')).submit();
    });

    $.each(forms, function(i, form){

        wrapper.on('submit', form, function (e) {
            var update = false;

            $.ajax({
                type: 'POST',
                url: null,
                data: $(this).serialize(),
                success: function (response) {
                    if (response['success']) {
                        $.notify(response['success'], 'success');
                        update = true;
                    } else if (response['info']) {
                        //$.notify(response['info'], 'info');
                    } else if (response['error']) {
                        $.notify(response['error'], 'error');
                    }
                },
                dataType: 'json',
                async: false
            });

            return update;
        });
    });

});

$(document).on('pjax:end', function (e) {
    var isCaseDetails = function () {
        return $(e.target).find('form').prop('id') == 'form-case-details';
    };
    if (isCaseDetails()) {
        location.reload();
    }
})