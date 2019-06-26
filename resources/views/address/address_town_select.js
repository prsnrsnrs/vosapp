/**
 * 町名クリックイベント
 */
$(document).on('click', '.zip_code', function () {
    let zipCode = $(this).data('zip_code');
    window.opener.$($('#parent_target').val()).val(zipCode).trigger('change',true);
});


