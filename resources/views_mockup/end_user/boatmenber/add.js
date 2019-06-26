require('../../layout/base');

$(document).on('change', 'input[name=club_member]', function() {
    // $('.general').toggle();
    // $('.member').toggle();
    if ($(this).val() == 'general') {
        $('.general').find('input, select').prop('disabled', false);
        $('.member').find('input, select').prop('disabled', true);
    } else {
        $('.general').find('input, select').prop('disabled', true);
        $('.member').find('input, select').prop('disabled', false);
    }
});



