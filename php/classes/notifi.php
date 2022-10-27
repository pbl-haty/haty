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
                    where notice.user_rece = ?
                    order by notice.id desc";
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
        // パターン１（申請）gift_detail_backend.phpの32行目追加
        public function notifi_apply($user_send, $user_rece, $giftId){
            $sql = 'insert into notice(user_send, user_rece, pattern_id, gift_id) values(?, ?, ?, ?)';
            $this->exec($sql, [$user_send, $user_rece, 1, $giftId]);
        }

        // パターン4（お気に入り）gift_detail_backend.phpの42行目追加
        public function notifi_good($user_send, $user_rece, $giftId){
            $sql = 'insert into notice(user_send, user_rece, pattern_id, gift_id) values(?, ?, ?, ?)';
            $this->exec($sql, [$user_send, $user_rece, 4, $giftId]);
        }

        // パターン5（コメント）gift_detail_backend.phpの39行目追加
        public function notifi_comment($user_send, $user_rece, $giftId){
            $sql = 'insert into notice(user_send, user_rece, pattern_id, gift_id) values(?, ?, ?, ?)';
            $this->exec($sql, [$user_send, $user_rece, 5, $giftId]);
        }

        // パターン7（参加）GroupJoin.phpの19行目追加
        public function notifi_join($group_send, $user_send, $user_rece){
            $sql = 'insert into notice(group_send, user_send, pattern_id, user_rece) values(?, ?, ?, ?)';
            $this->exec($sql, [$group_send, $user_send, 7, $user_rece]);
        }
    }