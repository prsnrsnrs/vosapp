window.$ = window.jQuery = require('jquery');
require('core-js');

/**
 * ホバーテーブルのhover処理
 */
$(document).on('mouseenter', 'table.hover_rows tr', function(e){
    var $elem = $(this);
    if ($elem.closest('table').find('td[rowspan]').length == 0) {
        return false;
    }

    if ($elem.has('td[rowspan]').length == 0) {
        $(this).prev('tr').addClass('hover');
    }
    else {
        $(this).next('tr').addClass('hover');
    }
});
/**
 * ホバーテーブルのhover処理
 */
$(document).on('mouseleave', 'table.hover_rows tr', function(e){
    $('table.hover_rows tr.hover').removeClass('hover');
});

