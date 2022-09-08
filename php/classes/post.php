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

        public function giftedit($conditions, $gift_name, $giftcomment, $category_id, $image, $gift_id){
            $sql = 'update gift set conditions = ?, gift_name = ?, giftcomment = ?, category_id = ?, image = ? where id = ?';
            $this->exec($sql, [$conditions, $gift_name, $giftcomment, $category_id, $image, $gift_id]);
        }

        // 既存写真削除、新規写真追加処理
        public function groupedit($gift_id){
            $sql = "delete from giftgroup where gift_id = ?";
            $this->exec($sql, [$gift_id]);
        }

        // 既存グループ削除、新規グループ追加処理
        public function imageedit($gift_id){
            $sql = "delete from giftimage where gift_id = ?";
            $this->exec($sql, [$gift_id]);
        }
    }