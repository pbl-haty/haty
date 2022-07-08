var clipboard = new Clipboard('.inv-link-sentence');

$(function(){
    $('.inv-link-sentence').click(function(){
        $(this).addClass('copied');       //ボタンの色などを変更するためにクラスを追加
        $(this).text('コピーしました');    //テキストの書き換え
    });
});