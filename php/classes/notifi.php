<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class notifi extends DbData {

        // データベースから通知を取得
        public function notifi_view($userId){
            $sql = "(
                        select 
                            notice.id, notice.group_send, notice.user_send, notice.user_rece, notice.pattern_id, notice.gift_id, notice.not_con,
                            groupdb.groupname, user.name, gift.gift_name, pattern.pattern_name,
                            notice.time, 1 as count,
                            case
                                when pattern.id in (2, 3, 7) then groupdb.icon
                                else gift.image
                            end as image
                        from notice 
                            left join groupdb on notice.group_send = groupdb.id
                            left join user on notice.user_send = user.uid
                            left join pattern on notice.pattern_id = pattern.id
                            left join gift on notice.gift_id = gift.id
                        where notice.user_rece = ? and pattern.id not in (1, 4, 5, 8)
                    )
                    union all
                    (
                        select 
                            notice.id, notice.group_send, notice.user_send, notice.user_rece, notice.pattern_id, notice.gift_id, notice.not_con,
                            groupdb.groupname, user.name, gift.gift_name, pattern.pattern_name,
                            max(notice.time) as max, count(notice.user_send) as count, gift.image
                        from notice 
                            left join groupdb on notice.group_send = groupdb.id
                            left join user on notice.user_send = user.uid
                            left join pattern on notice.pattern_id = pattern.id
                            left join gift on notice.gift_id = gift.id
                        where notice.user_rece = ? and pattern.id in (1, 4,  5, 8)
                        group by pattern.id, notice.user_send, notice.gift_id, notice.not_con
                    )
                    order by time desc";
            $stmt = $this->query($sql, [$userId, $userId]);
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

        // データベースの未読を既読に変更
        public function notifi_update($userId){
            $sql = "update notice set not_con = 1 where user_rece = ? and not_con is null";
            $this->exec($sql, [$userId]);
        }

        // データベースに通知を追加
        // パターン１,4,5,8（申請, いいね, コメント, 完了）
        public function notifi_gift($user_send, $user_rece, $pattern, $giftId){
            $sql = 'insert into notice(user_send, user_rece, pattern_id, gift_id) values(?, ?, ?, ?)';
            $this->exec($sql, [$user_send, $user_rece, $pattern, $giftId]);
        }

        // パターン2,3（開催、終了）
        public function notifi_trade($group_send, $user_rece, $pattern){
            $sql = 'insert into notice(group_send, user_rece, pattern_id) values(?, ?, ?)';
            $this->exec($sql, [$group_send, $user_rece, $pattern]);
        }

        // パターン7（参加）GroupJoin.phpの19行目追加
        public function notifi_join($group_send, $user_send, $user_rece){
            $sql = 'insert into notice(group_send, user_send, pattern_id, user_rece) values(?, ?, ?, ?)';
            $this->exec($sql, [$group_send, $user_send, 7, $user_rece]);
        }
    }