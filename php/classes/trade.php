<?php
    // スーパークラスであるDbDataを利用するため
    require_once __DIR__ . '/dbdata.php';

    class Trade extends DbData {
        // 交換会を作成
        public function createTrade($group_id, $trade_name, $theme1, $theme2, $theme3, $trade_explain, $end_date){
            $sql = 'insert into trade(group_id, trade_name, theme1, theme2, theme3, trade_explain, end_date) values(?, ?, ?, ?, ?, ?, ?)';
            $result = $this->exec($sql, [$group_id, $trade_name, $theme1, $theme2, $theme3, $trade_explain, $end_date]);
            return $this->pdo->lastInsertId();
        }

        // // 交換会のテーマを作成
        // public function createThemes($trade_id, $theme1, $theme2, $theme3){
        //     $sql = 'insert into trade_theme(trade_id, theme1, theme2, theme3) values(?, ?, ?, ?)';
        //     $this->exec($sql, [$trade_id, $theme1, $theme2, $theme3]);
        // }

        // 交換会のトレードIDと終了日を取得
        public function getTradeId($end_date){
            $sql = 'select trade_id from trade where end_date = ?';
            $stmt = $this->query($sql, [$end_date]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // 交換会にグッズを追加
        public function postGoods($trade_id, $pass_id, $goods_name, $goods_hint, $goods_image){
            $sql = 'insert into trade_goods(trade_id, pass_id, goods_name, goods_hint, goods_image) values(?, ?, ?, ?, ?)';
            $this->exec($sql, [$trade_id, $pass_id, $goods_name, $goods_hint, $goods_image]);
        }

        // トレードIDから交換会の情報を取得
        public function gettradeInfo_tID($trade_id){
            $sql = "select group_id, trade_name, trade_explain, begin_date, end_date, theme1, theme2, theme3
                    from trade
                    where trade_id = ?";
            $stmt = $this->query($sql, [$trade_id]);
            $items = $stmt->fetch();
            return $items;
        }

        // グループIDから交換会の情報を取得
        public function gettradeInfo($group_id){
            $sql = 'select trade_id, group_id, trade_name, trade_explain, begin_date, end_date, theme1, theme2, theme3
                    from trade
                    where group_id = ?';
            $stmt = $this->query($sql, [$group_id]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // トレードIDからグッズの渡す人・貰う人のID、グッズ名、グッズ画像を取得する
        public function otherTradeInfo($trade_id){
            $sql = "select pass_id, goods_name, goods_image, receive_id, goods_hint
                    from trade_goods
                    where trade_id = ?";
            $stmt = $this->query($sql, [$trade_id]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // トレードIDからグッズの情報（ヒントなど）を取得
        public function getGoodsInfo($trade_id){
            $sql = "select user.name, user.icon, trade_goods.goods_hint
                    from trade_goods join user on user.uid = trade_goods.pass_id
                    where trade_goods.trade_id = ?";
            $stmt = $this->query($sql, [$trade_id]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // ユーザーIDと交換会IDから交換会に出品後のグッズの情報を取得
        public function postGoodsInfo($user_id, $trade_id){
            $sql = "select goods_id, goods_name, goods_hint, goods_image
                    from trade_goods
                    where pass_id = ? and trade_id = ?";
            $stmt = $this->query($sql, [$user_id, $trade_id]);
            $items = $stmt->fetch();
            return $items;
        }
        // 交換物ID(goods_id)から交換会に出品後のグッズの情報を取得
        public function postGoodsInfo_goodsId($goods_id){
            $sql = "select goods_id, trade_id, pass_id, goods_name, goods_hint, goods_image, receive_id
                    from trade_goods
                    where goods_id = ?";
            $stmt = $this->query($sql, [$goods_id]);
            $items = $stmt->fetch();
            return $items;
        }
        // トレードIDから交換会に投稿されたグッズの数を取得
        public function getNumofGoods($trade_id){
            $sql = "select goods_id from trade_goods
                    where trade_id = ?";
            $stmt = $this->query($sql, [$trade_id]);
            $items = $stmt->fetchAll();
            return count($items);
        }

        // ログインしているユーザーIDとグループIDから渡す人と渡す物の情報を取得
        public function passGoodsInfo($user_id, $trade_id){
            $sql = "select user.uid, user.name, user.icon, trade_goods.goods_name, trade_goods.goods_hint, trade_goods.confirm, trade_goods.goods_image
                    from trade_goods join user on user.uid = trade_goods.receive_id
                    where trade_goods.pass_id = ? and trade_goods.trade_id = ?";
            $stmt = $this->query($sql, [$user_id, $trade_id]);
            $items = $stmt->fetch();
            return $items;
        }

        // ログインしているユーザーIDとグループIDから貰う人と貰う物の情報を取得
        public function receiveGoodsInfo($user_id, $trade_id){
            $sql = "select user.uid, user.name, user.icon, trade_goods.goods_name, trade_goods.goods_hint, trade_goods.confirm, trade_goods.goods_image
                    from trade_goods join user on user.uid = trade_goods.pass_id
                    where trade_goods.receive_id = ? and trade_goods.trade_id = ?";
            $stmt = $this->query($sql, [$user_id, $trade_id]);
            $items = $stmt->fetch();
            return $items;
        }

        // トレードIDから交換会に参加しているユーザーのIDを取得
        public function getuserid($trade_id){
            $sql = "select pass_id, receive_id from trade_goods
                    where trade_id = ?";
            $stmt = $this->query($sql, [$trade_id]);
            $items = $stmt->fetchAll();
            return $items;
        }

        // トレードIDとユーザーIDから渡す人のIDを挿入する
        public function updateReceiveid($trade_id, $pass_id, $receive_id){
            $sql = 'update trade_goods set receive_id = ? where trade_id = ? and pass_id = ?';
            $this->exec($sql, [$receive_id, $trade_id, $pass_id]);
        }
        
        // 受け取り完了に変更（confirmを0→1)
        public function receiptComplete($user_id, $trade_id){
            $sql = "update trade_goods set confirm = 1 where receive_id = ? and trade_id = ?";
            $this->exec($sql, [$user_id, $trade_id]);

        }

        public function editGoodsInfo($goods_name, $goods_hint, $goods_id){
            $sql = 'update trade_goods set goods_name = ?, goods_hint = ? where goods_id = ?';
            $result = $this->exec($sql, [$goods_name, $goods_hint, $goods_id]);

            if($result){
                return '';
            }else{
                return '交換物の変更が出来ませんでした。';
            }
        }

        public function editGoodsImage($goods_image, $goods_id){
            $sql = 'update trade_goods set goods_image = ? where goods_id = ?';
            $result = $this->exec($sql, [$goods_image, $goods_id]);

            if($result){
                return '';
            }else{
                return '交換物の変更が出来ませんでした。';
            }
        }

        // 交換会に投稿したグッズを編集
        public function editGoodsInfo01($goods_image, $goods_name, $goods_hint, $goods_id){
            $sql = "update trade_goods set goods_image = ?, goods_name = ?, goods_hint = ? where goods_id = ?";
            $result = $this->exec($sql, [$goods_image, $goods_name, $goods_hint, $goods_id]);

            if($result){
                return '';
            }else{
                return '交換物の変更が出来ませんでした。';
            }
        }

    }