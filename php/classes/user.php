<?php
    // スーパークラスであるDbdataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class User extends DbData{
        // ログイン認証
        public function authUser($mailaddress){
            $sql = "select * from user where mailaddress = ?";
            $stmt = $this->query($sql, [$mailaddress]);
            return $stmt->fetch();
        }


        // ユーザー登録処理
        public function signUp($name, $password, $mailaddress){
            // 既にメールアドレスが登録されているかの確認
            $sql = "select * from user where mailaddress = ?";
            $stmt = $this->query($sql, [$mailaddress]);
            $result = $stmt->fetch();

            // アカウント登録するメールアドレスのアカウントが既に登録されているとき
            if($result){
                return 'この' . $mailaddress . 'は既に登録されています。';
            }

            // 入力された情報をもとに、データベースにアカウント、ユーザーの追加
            $sql = 'insert into user(name, password, mailaddress) values(?, ?, ?)';
            $result= $this->exec($sql, [$name, $password, $mailaddress]);

            if($result){
                // 登録に成功した場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return '新規アカウント登録できませんでした。管理者にお問い合わせください。';
            }
        }

        
        // ログアウト処理
        public function logout(){
            $_SESSION = array();
            session_destroy();
        }
    }
?>