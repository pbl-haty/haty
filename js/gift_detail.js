$(document).ready(function() {
  $('.slider').bxSlider({
      auto: false,
  });

  //スクロールバーの位置をリストの最下部に設定
  const display_comment = document.getElementById('comment_content');
  display_comment.style.display = "block";
  const list = document.getElementById('scroll');
  list.scrollTo(0, list.scrollHeight);
  display_comment.style.display = null;
});