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

        // 交換会にグッズを追加
        public function postGoods($group_id, $pass_id, $goods_name, $goods_hint, $goods_image){
            $sql = 'insert into trade_goods(group_id, pass_id, goods_name, goods_hint, goods_image) values(?, ?, ?, ?, ?)';
            $this->exec($sql, [$group_id, $pass_id, $goods_name, $goods_hint, $goods_image]);
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
            $sql = 'select trade_id, trade_name, trade_explain, begin_date, end_date, theme1, theme2, theme3
                    from trade
                    where group_id = ?';
            $stmt = $this->query($sql, [$group_id]);
            $items = $stmt->fetch();
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

        // 交換会に出品後のグッズの情報を取得
        public function postGoodsInfo($user_id, $trade_id){
            $sql = "select goods_name, goods_hint, goods_image
                    from trade_goods
                    where pass_id = ? and trade_id = ?";
            $stmt = $this->query($sql, [$user_id, $trade_id]);
            $items = $stmt->fetch();
            return $items;
        }

        // ログインしているユーザーIDとグループIDから渡す人と渡す物の情報を取得
        public function passGoodsInfo($user_id, $trade_id){
            $sql = "select user.uid, user.name, user.icon, trade_goods.goods_name, trade_goods.goods_hint, trade_goods.confirm
                    from trade_goods join user on user.uid = trade_goods.receive_id
                    where trade_goods.pass_id = ? and trade_goods.trade_id = ?";
            $stmt = $this->query($sql, [$user_id, $trade_id]);
            $items = $stmt->fetch();
            return $items;
        }

        // ログインしているユーザーIDとグループIDから貰う人と貰う物の情報を取得
        public function receiveGoodsInfo($user_id, $trade_id){
            $sql = "select user.uid, user.name, user.icon, trade_goods.goods_name, trade_goods.goods_hint, trade_goods.confirm
                    from trade_goods join user on user.uid = trade_goods.pass_id
                    where trade_goods.receive_id = ? and trade_goods.trade_id = ?";
            $stmt = $this->query($sql, [$user_id, $trade_id]);
            $items = $stmt->fetch();
            return $items;
        }

    }