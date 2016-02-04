
$(document).ready(function() {
    initHintBlocks();
});

var initHintBlocks = function () {
    $('.hint-block').each(function () {
        var $hint = $(this);
        var lable = $hint.parent().find('label');
        var placement = 'right';
        if (lable.hasClass('right'))
            placement = 'left';

        $hint.parent().find('label').addClass('help').popover({
            html: true,
            trigger: 'hover',
            placement: placement,
            content: $hint.html()
        });
    });
};