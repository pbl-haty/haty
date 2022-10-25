window.addEventListener('DOMContentLoaded', function(){
  
    // input要素を取得
    var input_name = document.getElementById("text-check");
  
    input_name.addEventListener("change",function(){
        if(this.value.indexOf( "http://localhost/haty/php/GroupJoin.php?code=") == 0) {
            this.value = this.value.slice('-20');
        } else if(this.value.indexOf( "http://ec2-35-78-185-213.ap-northeast-1.compute.amazonaws.com/haty/php/GroupJoin.php?code=") == 0) {
            this.value = this.value.slice('-20');
        }
    });
  
    // イベントリスナーでイベント「input」を登録
    input_name.addEventListener("input",function(){
        if(this.value.indexOf( "http://localhost/haty/php/GroupJoin.php?code=") == 0) {
            this.value = this.value.slice('-20');
        } else if(this.value.indexOf( "http://ec2-35-78-185-213.ap-northeast-1.compute.amazonaws.com/haty/php/GroupJoin.php?code=") == 0) {
            this.value = this.value.slice('-20');
        }
    });
  });