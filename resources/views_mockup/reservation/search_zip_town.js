require('../layout/base');
var arg = new Object;
var searchZipTown = {
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
     * 親画面に郵便番号をセットします
     * @param elem
     */
    setZip: function (elem) {
        var zip = $(elem).closest('tr').children('td.zip').text();
        window.opener.$('#' + arg.target_index).find('input[name=post_number]').val(zip);
        window.close();
    },
};

$(function () {

    searchZipTown.getParameter();

    $('.town_name').on('click', function () {
        searchZipTown.setZip(this);
    });
});

