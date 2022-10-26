<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class notifi extends DbData {

        // データベースから通知を取得
        public function notifi_view($userId){
            $sql = "select *
                    from notice 
                    left join groupdb on notice.group_send = groupdb.id
                    left join user on notice.user_send = user.uid
                    left join pattern on notice.pattern_id = pattern.id
                    left join gift on notice.gift_id = gift.id
                    where notice.user_rece = ?";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // データベースから通知を取得
        public function notifi_count($userId){
            $sql = "select count(*)
                    from notice 
                    where user_rece = ? and not_con is null";
            $stmt = $this->query($sql, [$userId]);
            $item = $stmt->fetch();
            return $item;
        }

        // データベースから通知を取得
        public function notifi_update($userId){
            $sql = "update notice set not_con = 1 where user_rece = ? and not_con is null";
            $this->exec($sql, [$userId]);
        }

        // データベースに通知を追加
    }