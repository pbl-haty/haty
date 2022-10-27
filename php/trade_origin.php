<?php
require_once __DIR__ . '/header.php';

$userId = $_SESSION['uid'];
?>
<link rel="stylesheet" href="../css/home.css">
<title>ホーム</title>
</head>

<br>

<body>


    <?php // グループに所属しているか判定・・・A
    require_once __DIR__ . '/classes/group.php';
    $group = new Group();

    // $group_joins = $Group->groupjoin($_SESSION['userId']);
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        echo '<hr>';
        echo '<div class ="prompt_1">';
        echo '<h4>グループを作成して友達とギフトを贈りあおう！</h4>';
        echo '</div>';
    } else {
        foreach ($group_join as $join) {
            $img = base64_encode($join['icon']);
    ?>
            <hr>

            <div>

                <div class="home_title">
                    <div class="display">
                        <img class="home_groupicon" src="data:;base64,<?php echo $img; ?>">
                        <p class="home_groupname"><?= $join['groupname'] ?></p>
                    </div>


                </div>
            </div>
            </div>
    <?php // A'
        }
    }
    ?>
</body>

</html>