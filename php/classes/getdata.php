<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class GetData extends DbData {
    // 商品をカートに入れる ・・ テーブルcartに登録する

        // 自分が「いいね」している商品を取得(未取引の物のみ表示)
        public function mygoodlist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from good join gift on good.gift_id = gift.id
                    where good.user_id = ? and gift.judge is null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }
            
        // 自分が申請して成立した商品の履歴
        public function myjudgelist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift
                    where gift.applicant = ? and gift.judge is not null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }
            
        // 自分が相手に対して申請中の商品
        public function myapplicationlist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift
                    where gift.judge is null and gift.applicant = ?
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // 相手が「いいね」している商品を取得(未取引の物のみ表示)
        public function yourgoodlist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from good join gift on good.gift_id = gift.id
                    where gift.user_id = ? and gift.judge is null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // 相手が申請して成立した商品の履歴
        public function yourjudgelist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift
                    where gift.user_id = ? and gift.judge is not null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // 相手が自分に対して申請中の商品
        public function yourapplicationlist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift
                    where gift.user_id = ? and gift.judge is null and gift.applicant is not null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }
    }