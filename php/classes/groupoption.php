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
        }

    }