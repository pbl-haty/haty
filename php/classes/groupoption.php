<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class Groupoption extends DbData {
    // 商品をカートに入れる ・・ テーブルcartに登録する

        public function codeuniq() {
            do {
                $code = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 20);
                $sql = "select code from groupdb where code = ?";
                $stmt = $this->query($sql, [$code]);
                $item = $stmt->fetch();
            } while(!empty($item));
            return $code;
        }

        public function groupcreate($userId, $groupname, $code, $grouppass, $image) {
            // グループ数が5以下の場合のみ作成可能処理↓
            /*    $sql = "select groupjoin.user_id, groupjoin.group_id, groupdb.groupname
                    from groupjoin join groupdb on groupjoin.group_id = groupdb.id 
                    where user_id = ?";
            $stmt = $this->query($sql, [$userId]);
            $items = $stmt->fetchAll();
            if(count($items,COUNT_RECURSIVE) <= 5){
                return '所属グループが多すぎます。';
            }else{
                $sql = 'insert into groupdb(groupname, code, password, icon) values(?, ?, ?, ?)';
                $this->exec($sql, [$groupname, $code, $grouppass, $image]);
                return '';
            } */

            $sql = 'insert into groupdb(groupname, code, password, icon) values(?, ?, ?, ?)';
            $this->exec($sql, [$groupname, $code, $grouppass, $image]);
            $id = $this->pdo->lastInsertId();
            $sql = 'insert into groupjoin(user_id, group_id) values(?, ?)';
            $this->exec($sql, [$userId , $id]);
        }

        public function groupjoin($userId, $groupId) {
            $sql = "insert into groupjoin(user_id, group_id) values(?, ?)";
            $this->exec($sql, [$userId, $groupId]);
        }

        public function groupjoin_room($code) {
            $sql = 'select * from groupdb where code = ?';
            $stmt = $this->query($sql, [$code]);
            $item = $stmt->fetch();
            return $item;
        }

        public function groupjoin_member($userId, $groupId) {
            $sql = 'select * from groupjoin where user_id = ? and group_id = ?';
            $stmt = $this->query($sql, [$userId, $groupId]);
            $item = $stmt->fetch();
            return $item;
        }
      
        // グループコードからグループ情報を取得
        public function getGroupdb($code){
            $sql = 'select * from groupdb where code = ?';
            $stmt = $this->query($sql, [$code]);
            return $stmt->fetch();
        }

        // コードで入力からグループに参加する
        public function joinGroupCode($user_id, $group_id){
            $sql = 'select * from groupjoin where user_id = ? and group_id = ?';
            $stmt = $this->query($sql, [$user_id, $group_id]);
            $check_result = $stmt->fetch();

            if(empty($check_result)){
                $sql = 'insert into groupjoin(user_id, group_id) values(?, ?)';
                $result = $this->exec($sql, [$user_id, $group_id]);
                if($result){
                    return '';
                }else{
                    return 'グループの参加が出来ませんでした。再度入力してください。';
                }
            }else{
                return 'あなたは既にこのグループに参加しています。';
            }
        }


        public function groupwithdrawal($userId, $groupId) {
            $sql = 'delete from groupjoin where user_id = ? and group_id = ?';
            $this->exec($sql, [$userId, $groupId]);

            // グループに誰も所属していない場合そのグループを削除
            $sql = 'select * 
                    from groupdb join groupjoin on groupdb.id = groupjoin.group_id
                    where groupdb.id = ?';
            $stmt = $this->query($sql, [$groupId]);
            $items = $stmt->fetchAll();
            if(empty($items)) {
                $sql = 'delete from groupdb where id = ?';
                $this->exec($sql, [$groupId]);
            }

        }
    }