$(function () {

    var
        wrapper = $('.wrapper-grid-view'),
        form = $('#form-record-reports-filter');

    wrapper.on('click', '.grid-view-refresh', function (e) {
        e.preventDefault();

        form.is(':visible') ? form.submit() : false;
    });

});
