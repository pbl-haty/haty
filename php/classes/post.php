<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class Post extends DbData {
    // 商品をカートに入れる ・・ テーブルcartに登録する

        public function giftpost($userId, $conditions, $gift_name, $giftcomment, $image){
            /* カテゴリあり */
            /* $sql = 'insert into gift(user_id, conditions, gift_name, giftcomment, category, image) values(?, ?, ?, ?, ?, ?)'; */
            /* カテゴリなし */
            $sql = 'insert into gift(user_id, conditions, gift_name, giftcomment, image) values(?, ?, ?, ?, ?)';
            $result = $this->exec($sql, [$userId, $conditions, $gift_name, $giftcomment, $image]);
            return $this->pdo->lastInsertId();
        }

        public function grouppost($gift_id, $group_id){
            $sql = 'insert into giftgroup(gift_id, group_id) values(?, ?)';
            $this->exec($sql, [$gift_id, $group_id]);
        }

        public function imagepost($gift_id, $image){
            $sql = 'insert into giftimage(gift_id, image) values(?, ?)';
            $this->exec($sql, [$gift_id, $image]);
        }
    }