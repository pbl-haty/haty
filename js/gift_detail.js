$(document).ready(function() {
  var slider = $('.slider').bxSlider({
      auto: false,
  });

  // スクロールバーの位置をリストの最下部に設定
  const all_content = document.getElementById('all_content');
  const display_comment = document.getElementById('comment_content');
  display_comment.style.display = "block";
  const list = document.getElementById('scroll');
  list.scrollTo(0, list.scrollHeight);
  if(document.getElementById('all').checked == true) {
    display_comment.style.display = "none";
    all_content.style.display= "block";
    slider.reloadSlider();
  }
  
  // タブクリックでスライダーをリロード
  document.getElementById('button').onclick = function() {
    all_content.style.display= "block";
    slider.reloadSlider();
    display_comment.style.display = "none";
  };

  document.getElementById('scroll-btn').onclick = function() {
    display_comment.style.display= "block";
    all_content.style.display= "none";
  };

  // 更新時に警告を表示
  
});