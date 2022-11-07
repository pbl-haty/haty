<?php
    // 配列の中身を同一の添え字で一致しないようシャッフルする関数
    function array_shuffle($array){
        $flag = 0;                          // 終了フラグ
        $return_array = $array;             // 受け取った配列を返す配列に代入
        $array_count = count($array);       // 配列の要素数を取得

        // シャッフルが成り立つまループ
        while($flag == 0){
            // ランダムにシャッフル
            shuffle($return_array);
            $cnt = 0;
            // 受け取った配列と返す配列がそれぞれ一致しているか判定
            for($i  = 0; $i < $array_count; $i++){
                if($array[$i] == $return_array[$i]){
                    continue;
                }else{
                    $cnt += 1;
                }
            }
            // 同一の添え字で一致しないようにシャッフル出来ていた場合
            if($cnt == $array_count){
                $flag = 1;
            }
        }

        return $return_array;
    }

    // trade.phpを読み込み、トレードオブジェクトを生成
    require_once __DIR__ . '/classes/trade.php';
    $trade = new Trade();

?>