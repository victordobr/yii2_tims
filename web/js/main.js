$(function(){
    $('#img').click(function(){
        //alert('hello');
        $('#modal').modal('show')
            .find('#modalContent')
            .load($(this).attr('value'));
    });
});