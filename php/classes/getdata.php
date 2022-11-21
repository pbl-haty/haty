<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class GetData extends DbData {
    // 商品をカートに入れる ・・ テーブルcartに登録する

        // 自分が現在投稿している商品で未申請一覧
        public function postlist($userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift
                    where gift.user_id = ? and gift.applicant is null and gift.judge is null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }    

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

        // 自分、相手が申請して成立した商品の履歴
        public function judgelist($userId){
            $sql = "(
                        select gift.id, gift.gift_name, gift.image, gift.post
                        from gift
                        where gift.applicant = ? and gift.judge is not null
                    )
                    union all
                    (
                        select gift.id, gift.gift_name, gift.image, gift.post
                        from gift
                        where gift.user_id = ? and gift.judge is not null
                    )
                    order by post desc, id desc";
            $stmt = $this->query($sql, [$userId, $userId]);
            $items = $stmt->fetchAll();
            return $items;
        }
            
        // 自分が申請して成立した商品の履歴
        // public function myjudgelist($userId){
        //     $sql = "select gift.id, gift.gift_name, gift.image, gift.post
        //             from gift
        //             where gift.applicant = ? and gift.judge is not null
        //             order by gift.post desc, gift.id desc";
        //     $stmt = $this->query($sql, [$userId]);
        //     $items = $stmt->fetchAll();
        //     return $items;
        // }
            
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
        // public function yourgoodlist($userId){
        //     $sql = "select gift.id, gift.gift_name, gift.image, gift.post
        //             from good join gift on good.gift_id = gift.id
        //             where gift.user_id = ? and gift.judge is null
        //             order by gift.post desc, gift.id desc";
        //     $stmt = $this->query($sql, [$userId]);
        //     $items = $stmt->fetchAll();
        //     return $items;
        // }

        // 相手が申請して成立した商品の履歴
        // public function yourjudgelist($userId){
        //     $sql = "select gift.id, gift.gift_name, gift.image, gift.post
        //             from gift
        //             where gift.user_id = ? and gift.judge is not null
        //             order by gift.post desc, gift.id desc";
        //     $stmt = $this->query($sql, [$userId]);
        //     $items = $stmt->fetchAll();
        //     return $items;
        // }

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

        // ログイン中のユーザーと同じグループに投稿されていて、未申請のギフト一覧を取得
        public function getGiftList($user_id, $group_id){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift join giftgroup on gift.id = giftgroup.gift_id
                    where gift.user_id = ? and gift.applicant is null and giftgroup.group_id in (".implode(",",$group_id).");
                    order by gift.post desc, gift.id desc";
            $stmt = $stmt = $this->query($sql, [$user_id]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // ログイン中のユーザーと同じグループに投稿されていて、いいねを押しているギフト一覧を取得
        public function getGoodGiftlist($user_id, $group_id){
                $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                        from good join gift on good.gift_id = gift.id right join giftgroup on gift.id = giftgroup.gift_id
                        where good.user_id = ? and gift.judge is null and giftgroup.group_id in (".implode(",",$group_id).");
                        order by gift.post desc, gift.id desc";
                $stmt = $this->query($sql, [$user_id]);
                $items = $stmt->fetchAll();
                return $items;
        }

        // ログイン中のユーザーと同じグループに投稿されていて、取引が終了しているギフト一覧を取得
        public function getJudgeGiftlist($user_id, $group_id){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from gift join giftgroup on gift.id = giftgroup.gift_id
                    where gift.user_id = ? and gift.judge is not null and giftgroup.group_id in (".implode(",",$group_id).");
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$user_id]);
            $items = $stmt->fetchAll();
            return $items;
        }
    }