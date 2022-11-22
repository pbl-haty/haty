<?php
    // 配列の中身を同一の添え字で一致しないようシャッフルする関数
    function array_shuffle($array){
        $flag = 0;                          // 終了フラグ
        $return_array = $array;             // 受け取った配列を返す配列に代入
        $array_count = count($array);       // 配列の要素数を取得

        // シャッフルが成り立つまでループ
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

        // シャッフル後の配列を返す
        return $return_array;
    }

    // trade.phpを読み込み、トレードオブジェクトを生成
    require_once __DIR__ . '/classes/trade.php';
    require_once __DIR__ . '/classes/notifi.php';
    $trade = new Trade();
    $notifi = new notifi();

    // データベースで設定した終了日の23:59:59などに実行する場合
    // $date = date("Y-m-d");

    // データベースで設定した　終了日+１日　00:00:00に実行する場合
    $date = date("Y-m-d" , strtotime('-1 day'));

    // 日付からデータベースの交換会の情報を取得
    $tradeid_array = $trade->getTradeId($date);

    foreach ($tradeid_array as $tradeid){
        // トレードIDから交換会に参加しているユーザーを取得
        $trade_id = $tradeid['trade_id'];
        $goods_users = $trade->getuserid($trade_id);
        $trade_info = $trade->gettradeInfo_tID($trade_id);

        $array = [];
        foreach($goods_users as $good_user) {
            // 渡す人のIDがデータベースで挿入されていない時
            if(is_null($good_user['receive_id'])){
                array_push($array, $good_user['pass_id']);
                $notifi->notifi_trade($trade_info['group_id'], $good_user['pass_id'], 3);
            }
        }

        // 受け取ったユーザーIDをシャッフルする関数を呼び出す
        $receive_id_array = array_shuffle($array);

        // シャッフルした配列を元にデータベースに追加
        for($i = 0; $i < count($receive_id_array); $i++){
            $trade->updateReceiveid($trade_id, $array[$i], $receive_id_array[$i]);
        }
    }

?>