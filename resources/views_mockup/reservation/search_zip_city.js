require('../layout/base');
var arg = new Object;
var searchZipCity = {

    /**
     * パラメーターを取得します
     */
    getParameter: function () {
        var pair = location.search.substring(1).split('&');
        for (var i = 0; pair[i]; i++) {
            var kv = pair[i].split('=');
            arg[kv[0]] = kv[1];
        }
    },

    /**
     * 値をサブミットします
     * @param elem
     */
    formSubmit: function (elem) {
        $('input[name=target_index]').val(arg.target_index);
        $('input[name=select_city]').val($(elem).text());
        $('form#city').submit();
    }
};

$(function () {

    searchZipCity.getParameter();

    $('.city_name').on('click', function () {
        searchZipCity.formSubmit(this);
    });
});

