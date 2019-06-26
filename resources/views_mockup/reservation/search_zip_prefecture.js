require('../layout/base');
var arg = new Object;
var searchZipPrefecture = {

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
        $('input[name=select_prefecture]').val($(elem).text());
        $('form#prefecture').submit();
    }
};

$(function () {

    searchZipPrefecture.getParameter();

    $('.prefecture_name').on('click', function () {
        searchZipPrefecture.formSubmit(this);
    });
});

