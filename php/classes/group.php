<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class Group extends DbData {
    // 商品をカートに入れる ・・ テーブルcartに登録する

        public function groupjoin($userId){
            $sql = "select groupjoin.user_id, groupjoin.group_id, groupdb.groupname
                    from groupjoin join groupdb on groupjoin.group_id = groupdb.id 
                    where user_id = ?";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        public function giftgroup($groupId, $userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post
                    from giftgroup join gift on giftgroup.gift_id = gift.id
                    where giftgroup.group_id = ? and gift.user_id != ?
                    order by gift.post desc, gift.id desc
                    limit 3";
            $stmt = $this->query($sql, [$groupId, $userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

    }