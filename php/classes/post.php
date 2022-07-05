<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class Post extends DbData {
    // 商品をカートに入れる ・・ テーブルcartに登録する

        public function giftpost($userId, $conditions, $gift_name, $giftcomment, $category_id, $image){
            $sql = 'insert into gift(user_id, conditions, gift_name, giftcomment, category_id, image) values(?, ?, ?, ?, ?, ?)';
            $result = $this->exec($sql, [$userId, $conditions, $gift_name, $giftcomment, $category_id, $image]);
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

        public function giftcategory() {
            $sql = "select * from category";
            $stmt = $this->query($sql, []);
            $items = $stmt->fetchAll();
            return $items;
        }
    }