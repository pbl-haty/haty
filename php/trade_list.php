<?php
    // ヘッダーを読み込む
    require_once __DIR__ . '/header.php';
    // セッションからログイン中のユーザーIDを取得する
    $userid = $_SESSION['uid'];
?>
    <link rel="stylesheet" href="../css/trade_list.css">
    <title>交換会一覧</title>
</head>

<body>
    <br>
    <div class="trade-list"></div>
        <div class="tab-panel">
            <!--タブ-->
                <div class="tab-group">
                    <div class="tab tab-A is-active">開催中の交換会</div>
                    <div class="tab tab-B">過去の交換会</div>
                </div>
        
            <!--タブを切り替えて表示するコンテンツ-->
            <div class="panel-group">
                <div class="panel tab-A is-show">
                    a
                </div>
                <div class="panel tab-B">
                    b
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../js/trade_list.js"></script>
</body>
</html>