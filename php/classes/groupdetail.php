<?php

    require_once __DIR__ . '/dbdata.php';

    class GroupDetail extends DbData {

        // グループに所属しているか確認
        public function groupjoinconf($userId, $groupId){
            $sql = "select groupjoin.user_id, groupjoin.group_id, groupdb.groupname
                    from groupjoin join groupdb on groupjoin.group_id = groupdb.id 
                    where groupjoin.user_id = ? and groupjoin.group_id = ?";
            $stmt = $this->query($sql, [$userId, $groupId]);
            $items = $stmt->fetch();
            return $items;
        }

        public function giftgroupall($groupId){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post, gift.user_id
                    from giftgroup join gift on giftgroup.gift_id = gift.id
                    where giftgroup.group_id = ?  and gift.applicant is null
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$groupId]);
            $items = $stmt->fetchAll();
            return $items;
        }

        public function giftgroupacategory($groupId, $category_id){
            $sql = "select gift.id, gift.gift_name, gift.image, gift.post, gift.user_id
                    from giftgroup join gift on giftgroup.gift_id = gift.id
                    where giftgroup.group_id = ?  and gift.applicant is null and gift.category_id = ?
                    order by gift.post desc, gift.id desc";
            $stmt = $this->query($sql, [$groupId, $category_id]);
            $items = $stmt->fetchAll();
            return $items;
        }

    }