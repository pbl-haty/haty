<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class Group extends DbData {
        public function groupjoin($userId){
            $sql = "select groupjoin.user_id, groupjoin.group_id, groupdb.groupname, groupdb.icon
                    from groupjoin join groupdb on groupjoin.group_id = groupdb.id 
                    where user_id = ?";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        public function giftgroup($groupId, $userId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post, user.icon
                    from giftgroup join gift on giftgroup.gift_id = gift.id join user on user.uid = gift.user_id
                    where giftgroup.group_id = ? and gift.user_id != ? and gift.applicant is null and gift.judge is null
                    order by gift.post desc, gift.id desc
                    limit 5";
            $stmt = $this->query($sql, [$groupId, $userId]);
            $items = $stmt->fetchAll();
            return $items;
        }

    }