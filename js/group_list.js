var clipboard = new Clipboard('.inv-link-sentence');
var clipboard = new Clipboard('.groupcode-copy')

$(function(){
    $('.inv-link-sentence').click(function(){
        $(this).addClass('copied');       //ボタンの色などを変更するためにクラスを追加
        $(this).text('コピーしました');    //テキストの書き換え
    });
});

$(function(){
    $('.groupcode-copy').click(function(){
        $('.inv-link-sentence').addClass('copied');       //ボタンの色などを変更するためにクラスを追加
        $('.inv-link-sentence').text('コピーしました');    //テキストの書き換え
    });
});