$(function () {

    var
        wrapper = $('.wrapper-grid-view'),
        basic = $('#form-record-search-filter-basic'),
        advanced = $('#form-record-search-filter-advanced');

    wrapper.on('click', '.grid-view-refresh', function (e) {
        e.preventDefault();

        basic.is(':visible') ? basic.submit() : advanced.is(':visible') && advanced.submit();
    });

});