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

        // 自動ログイン用のトークンを設定
        public function setLoginToken($user_id){
            if(isset($_COOKIE['token'])){
                $sql = 'delete from user_token where token = ?';
                $this->exec($sql, [$_COOKIE['token']]);
            }

            // 新しいトークンを生成
            $token = '';
            $sql = "select * from user_token where token = ?";
            for($i = 0; $i < 100; $i++) {
                $token_temp = bin2hex(openssl_random_pseudo_bytes(16));
                $stmt = $this->query($sql, [$token_temp]);
                if(!$stmt->fetch()) {
                    $token = $token_temp;
                    break;
                }
            }
            if ($token == '') {
                throw new Exception('token error');
            }

            // テーブルへトークンを保存
            $sql = "insert into user_token(token, userid) values (?, ?)";
            $stmt = $this->exec($sql, [$token, $user_id]);
            // クッキーへトークンを保存（1週間保持）
            setcookie('token', $token, time() + 60 * 60 * 24 * 7, '/');
        }

        // 自動ログインの処理
        public function auto_login(){
            // セッションのロック
            $_SESSION['dummy'] = 1;
            $sql = 'select * from user_token where token = ?';
            $stmt = $this->query($sql, array($_COOKIE['token']));
            return $stmt->fetch();
        }

        // ユーザーIDからユーザー情報を取得
        public function getUser($user_id){
            $sql = "select * from user where uid = ?";
            $stmt = $this->query($sql, [$user_id]);
            return $stmt->fetch();
        }

        // ユーザーIDから参加しているグループ情報を取得
        public function getGroupId($user_id){
            $sql = "select group_id from groupjoin where user_id = ?";
            $stmt = $this->query($sql, [$user_id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        }

        // ユーザーIDとグループIDから所属しているか確認
        public function getGroupJoinInfo($user_id, $group_id){
            $sql = "select * from groupjoin where user_id = ? and group_id in (".implode(",",$group_id).")";
            $stmt = $this->query($sql, [$user_id]);
            $result = $stmt->fetchAll();

            if(empty($result)){
                return 'このユーザーを表示することは出来ません。';
            }else{
                return '';
            }

        }

        // ユーザー登録処理
        public function signUp($name, $password, $mailaddress, $image){
            // 既にメールアドレスが登録されているかの確認
            $sql = "select * from user where mailaddress = ?";
            $stmt = $this->query($sql, [$mailaddress]);
            $result = $stmt->fetch();

            // アカウント登録するメールアドレスのアカウントが既に登録されているとき
            if($result){
                return 'この' . $mailaddress . 'は既に登録されています。';
            }

            // 入力された情報をもとに、データベースにアカウント、ユーザーの追加
            $sql = 'insert into user(name, password, mailaddress, icon) values(?, ?, ?, ?)';
            $result= $this->exec($sql, [$name, $password, $mailaddress, $image]);

            if($result){
                // 登録に成功した場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return '新規アカウント登録できませんでした。管理者にお問い合わせください。';
            }
        }

        // メールアドレスとパスワードの確認
        public function checkPass($user_id, $password){
            $sql = 'select * from user where uid = ? and password = ?';
            $stmt = $this->query($sql, [$user_id, $password]);
            $result = $stmt->fetch();

            if($result){
                return '';
            }else{
                return '入力した現在のパスワードが間違っています。';
            }
        }

        //　プロフィールの変更（アイコン以外）
        public function editProfile($user_id, $name, $email, $comment){
            $sql = 'update user set name = ?, mailaddress = ?, comment = ? where uid = ?';
            $result = $this->exec($sql, [$name, $email, $comment, $user_id]);

            if($result){
                // プロフィールの変更が出来た場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return 'プロフィールの変更が出来ませんでした。';
            }
        }

        // プロフィールの変更（アイコン）
        public function editIcon($uid, $icon){
            $sql = 'update user set icon = ? where uid = ?';
            $result = $this->exec($sql, [$icon, $uid]);

            if($result){
                // プロフィールの変更が出来た場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return 'アイコンの変更が出来ませんでした。';
            }
        }

        // パスワードの変更
        public function editPassword($user_id, $password){
            $sql = "update user set password = ? where uid = ?";
            $result = $this->exec($sql, [$password, $user_id]);

            if($result){
                // パスワードの変更が出来た場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return 'パスワードの変更が出来ませんでした。';
            }
        }

        
        // ログアウト処理
        public function logout(){
            if(isset($_COOKIE['token'])){
                $sql = 'delete from user_token where token = ?';
                $this->exec($sql, [$_COOKIE['token']]);
            }
            $_SESSION = array();
            if (isset($_COOKIE[session_name()])) {
                //セッションクッキーを削除
                setcookie(session_name(), '', time() - 42000, '/');
            }
            //自動ログイントークンを削除
            setcookie('token', '', time() - 42000, '/');
            session_destroy();
        }
    }
?>