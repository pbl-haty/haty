<?php

    require_once __DIR__ . '/dbdata.php';

    class GroupMember extends DbData {

        // グループ情報取得
        public function groupconf($groupId){
            $sql = "select * from groupdb where id = ?";
            $stmt = $this->query($sql, [$groupId]);
            $item = $stmt->fetch();
            return $item;
        }

        // グループメンバー表示
        public function member($groupId){
            $sql = "select user.uid, user.name, user.icon
                    from groupjoin join user on groupjoin.user_id = user.uid
                    where groupjoin.group_id = ?
                    order by user.uid desc";
            $stmt = $this->query($sql, [$groupId]);
            $items = $stmt->fetchAll();
            return $items;
        }

    }