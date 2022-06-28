<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class GetData extends DbData {
    // 商品をカートに入れる ・・ テーブルcartに登録する

        public function goodlist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from good join gift on good.gift_id = gift.id
                    where good.user_id = ?
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        public function judgelist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift
                    where gift.user_id = ? and gift.judge is not null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

    }