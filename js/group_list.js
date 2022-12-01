var clipboard = new Clipboard('.inv-link-sentence');
var clipboard = new Clipboard('.groupcode-copy');

$(function(){
    $('.inv-link-sentence').click(function(){
        $(this).text('コピーしました');    //テキストの書き換え
    });
});

$(function(){
    $('.groupcode-copy').click(function(){
        $('.inv-link-sentence').text('コピーしました');    //テキストの書き換え
    });
});