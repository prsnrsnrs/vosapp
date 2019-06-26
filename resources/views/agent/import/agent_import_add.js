/**
 * 販売店一括登録用JavaScript
 */
$(function () {

    /**
     * 取り込みファイル変更イベント Step1
     */
    $('#import_csv_file').on('change', function (e) {
        //イベントキャンセル
        e.preventDefault();
        //Step2非表示
        $('.step2').hide();

        swal({
            title: '読み込み中',
            allowOutsideClick: false
        });
        swal.showLoading();

        let $this = $(this);
        let data = new FormData();
        data.append($this.attr('name'), $this.prop('files')[0]);
        let $form = $('#agent_import');
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            dataType: 'json',
            data: data,
            processData: false,
            contentType: false
        }).done(function (data) {
            voss.unlock();
            let option_data;
            let $header_code = data.header_data;

            // セレクトボックスに初期値を追加
            let $selectBoxes = $('.option_data');
            $selectBoxes.children().remove();

            //CSV1行目のデータをセレクトボックスに追加
            $.each($header_code, function (index, elem) {
                option_data = $("<option value='" + index + "'>" + elem + "</option>");
                $selectBoxes.append(option_data);
            });

            // 初期値を設定
            $.each($selectBoxes, function (index) {
                $selectBox = $(this);
                $selectBox.prepend($("<option value=' '>----------</option>"));
                $selectBox.find('option').eq(index + 1).attr("selected", "selected");
            });

            //Step2表示
            $('.step2').show();
            swal.close();
        }).fail(function (data) {
            swal.close();
        });
    });

    /**
     * 確認ボタンイベント Step2
     */
    $('#done').on('click', function (e) {
        e.preventDefault();
        swal({
            title: '取り込み中',
            allowOutsideClick: false
        });
        swal.showLoading();
        let $form = $('#import_file');
        $.ajax({
            url: $form.attr('action'),
            type: $form.attr('method'),
            dataType: 'json',
            data: new FormData($form.get()[0]),
            processData: false,
            contentType: false
        }).done(function (data) {
            location.href = data.redirect;
        }).fail(function (data) {
            swal.close();
        });
    });
});

