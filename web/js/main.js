
$(document).ready(function() {
    initHintBlocks();

    $("#pjax-frontend-search").on("pjax:start", function() {
        $("#pjax-frontend-search").addClass("page-loading");
    });

    $("#pjax-frontend-search").on("pjax:end", function() {
        $("#pjax-frontend-search").removeClass("page-loading");
    });
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