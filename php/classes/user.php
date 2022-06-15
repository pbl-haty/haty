<?php
    // スーパークラスであるDbdataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class User extends DbData{
        // ログイン認証
        public function authUser($mailaddress, $password){
            $sql = "select * from user where mailaddress = ? and password = ?";
            $stmt = $this->query($sql, [$mailaddress, $password]);
            return $stmt->fetch();
        }
    }
?>