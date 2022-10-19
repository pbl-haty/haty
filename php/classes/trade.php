<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class Trade extends DbData {
        // 交換会を作成
        public function createtrade($group_id, $trade_name, $trade_explain, $end_date){
            $sql = 'insert into trade(group_id, trade_name, trade_explain, end_date) values(?, ?, ?, ?)';
            $this->exec($sql, [$group_id, $trade_name, $trade_explain, $end_date]);
            return $this->pdo->lastInsertId();
        }

        // 交換会のテーマを作成
        public function createthemes($trade_id, $theme_1, $theme_2, $theme_3){
            $sql = 'insert into trade_theme(trade_id, theme_1, theme_2, theme_3) values(?, ?, ?, ?)';
            $this->exec($sql, [$trade_id, $theme_1, $theme_2, $theme_3]);
        }

        // 交換会にグッズを追加
        public function postgoods($group_id, $pass_id, $goods_name, $goods_hint, $goods_image){
            $sql = 'insert into trade_goods(group_id, pass_id, goods_name, goods_hint, goods_image) values(?, ?, ?, ?, ?)';
            $this->exec($sql, [$group_id, $pass_id, $goods_name, $goods_hint, $goods_image]);
        }

        // グループIDから交換会の情報を取得
        public function tradeInfo($group_id){
            $sql = 'select trade_name, trade_explain, begin_date, end_date from trade where group_id = ?';
            $stmt = $this->query($sql, [$group_id]);
            $items = $stmt->fetch();
            return $items;
        }


    }