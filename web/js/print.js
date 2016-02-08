$(function () {

    $.fn.or = function( fallbackSelector ) {
        return this.length ? this : $( fallbackSelector || 'body' );
    };

    var
        wrapper = $('#wrapper-record-print').or('#wrapper-print-qc'),
        pjax = $('#pjax-record-print').or('#wrapper-print-qc'),
        grid = $('#grid-record-print').or('#grid-print-qc');

    wrapper.on('click', '.print-selected', function (e) {
        var ids = grid.yiiGridView('getSelectedRows');
        if (ids.length > 0) {
            $.post('/print/send', {ids: ids}, function(sent){
                if((sent.length > 0)) {
                    window.location.href = '/print/preview?' + $.param({ids: sent});
                }
            }, 'json');
        }
    });

    wrapper.on('click', '.qc-confirm-selected', function (e) {
        var ids = grid.yiiGridView('getSelectedRows');
        if (ids.length > 0) {
            $.post('/print/confirm', {ids: ids}, function(confirmed){
                console.log(confirmed);
                //if((sent.length > 0)) {
                //    window.location.href = '/print/qc';
                //}
            }, 'json');
        }
    });

    wrapper.on('click', '.qc-reject-selected', function (e) {
        var ids = grid.yiiGridView('getSelectedRows');
        if (ids.length > 0) {
            $.post('/print/reject', {ids: ids}, function(rejected){
                console.log(rejected);
                //if((sent.length > 0)) {
                //    window.location.href = '/print/qc?' + $.param({ids: sent});
                //}
            }, 'json');
        }
    });

    wrapper.on('change', 'input[type=checkbox]', initPrintSelectedButton);

    wrapper.on('pjax:start', '#pjax-record-print', function () {
        pjax.addClass('page-loading');
    });

    wrapper.on('pjax:end', '#pjax-record-print', function () {
        pjax.removeClass('page-loading');
    });

    function initPrintSelectedButton(){
        var ids = grid.yiiGridView('getSelectedRows');
        wrapper.find('[class$=-selected]').prop('disabled', ids.length == 0);
    }

    $(document).ready(function(){
        initPrintSelectedButton();
    });

});