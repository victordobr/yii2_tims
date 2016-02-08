$(function () {

    $('.btn-print').on('click', function(e){
        e.preventDefault();

        print();
        location.href = '/print/qc';
    });

});