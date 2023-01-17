<?php
    // スーパークラスであるDbdataを利用するため
    require_once __DIR__ . '/dbdata.php';


    class Gift extends DbData {
        // 選択されたギフトの情報を取り出す
        public function getGift($gift_id){
            $sql = "select * 
                    from gift join category on gift.category_id = category.id
                    where gift.id = ?";
            $stmt = $this->query($sql, [$gift_id]);
            return $stmt->fetch();
        }

        // いいね数といいねを押したユーザー名を取り出す
        public function getGood($gift_id){
            $sql = "select user.name 
                    from good join user on good.user_id = user.uid 
                    where gift_id = ?";
            $stmt = $this->query($sql, [$gift_id]);
            $count = $stmt->rowCount();
            $result = $stmt->fetchAll();
            return array($count, $result);
        }

        // 自分が現在表示されている投稿にいいねを押しているか
        public function checkGood($gift_id, $user_id){
            $sql = "select * from good where gift_id = ? and user_id = ?";
            $stmt = $this->query($sql, [$gift_id, $user_id]);
            $result = $stmt->fetch();
            return $result;
        }

        // いいねを追加する
        public function addGood($gift_id, $user_id){
            $sql = "insert into good(gift_id, user_id) values(?, ?)";
            $this->exec($sql, [$gift_id, $user_id]);
        }

        // いいねを削除する
        public function deleteGood($gift_id, $user_id){
            $sql = "delete from good where gift_id = ? and user_id = ?";
            $this->exec($sql, [$gift_id, $user_id]);
        }

        // ギフトの申請
        public function applyGift($gift_id, $applicant){
            $sql = "update gift set applicant = ? where id = ?";
            $result = $this->exec($sql, [$applicant, $gift_id]);

            if($result){
                // ギフトの申請が出来た場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return 'ギフトの申請が出来ませんでした。';
            }
        }

        // ギフト申請の取り消し
        public function cancelGift($gift_id, $applicant){
            $sql = "update gift set applicant = NULL where id = ? and applicant = ?";
            $result = $this->exec($sql, [$gift_id, $applicant]);

            if($result){
                // ギフト申請の取り消しが出来た場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return 'ギフトの申請取り消しが出来ませんでした。';
            }
        }

        //　コメントを取り出す
        public function getComment($gift_id){
            $sql = 'select user.uid, user.name, user.icon, talk.comment, talk.post
                    from talk join user on talk.user_id = user.uid
                    where talk.gift_id = ?
                    order by talk.post asc';
            $stmt = $this -> query($sql, [$gift_id]);
            $result = $stmt->fetchAll();
            return $result;
        }

        // コメントを追加する
        public function addTalk($user_id, $gift_id, $comment){
            $sql = "insert into talk(user_id, gift_id, comment) values(?, ?, ?)";
            $result = $this->exec($sql, [$user_id, $gift_id, $comment]);

            // コメントが追加できた場合
            if($result){
                return '';
            }else{
                return 'コメントが追加出来ませんでした。';
            }
        }

        // ２枚目以降の写真を取得
        public function getaddimage($gift_id){
            $sql = "select image 
                    from giftimage
                    where gift_id = ?";
            $stmt = $this->query($sql, [$gift_id]);
            $result = $stmt->fetchAll();
            return $result;
        }

        //　投稿されているギフトが自分が入っているグループか判定
        public function getGiftGroup($user_id, $gift_id) {
            $sql = "select * 
                    from giftgroup join groupjoin on giftgroup.group_id = groupjoin.group_id
                    where groupjoin.user_id = ? and giftgroup.gift_id = ?";
            $stmt = $this->query($sql, [$user_id, $gift_id]);
            return $stmt->fetchAll();
        }

        //　投稿されているギフトがどのグループに所属しているか取得
        public function getGiftGroupEdit($gift_id) {
            $sql = "select group_id from giftgroup where gift_id = ?";
            $stmt = $this->query($sql, [$gift_id]);
            return $stmt->fetchAll();
        }

        // 取引を許可する
        public function doneGift($gift_id){
            $sql = "update gift set judge = 1 where id = ?";
            $result = $this->exec($sql, [$gift_id]);
            if($result){
                // ギフトの取引が許可出来た場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return 'ギフトの取引を許可出来ませんでした。';
            }
        }

        // 取引を終了させる
        public function thxGift($gift_id){
            $sql = "update gift set judge = 2 where id = ?";
            $result = $this->exec($sql, [$gift_id]);
            if($result){
                // ギフトの取引が完了出来た場合
                return '';
            }else{
                // 何かしらの原因で失敗した場合
                return 'ギフトの取引を完了出来ませんでした。';
            }
        }

        // 取引を終了させる
        public function deleteGift($gift_id){
            $sql = "delete from  gift where id = ?";
            $this->exec($sql, [$gift_id]);
        }
    }
