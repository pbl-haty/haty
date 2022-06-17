<?php
require_once __DIR__ . './header.php';
session_start();

$userId = $_SESSION['uid'];
?>
<link rel="stylesheet" href="../css/home.css">
</header>

<br>

<body>
    <div class="home_1">
        <h1 class="group_itiran">グループ一覧</h1>
        <div>
            <br>
            <button class="group_btn"><div class="group_btn_above">グループを</div><br><div class="group_btn_under">作成</div></button>
            <button class="group_btn"><div class="group_btn_above">グループに</div><br><div class="group_btn_under">参加</div></button>
        </div>
    </div>
    <hr>







    <?php // グループに所属しているか判定・・・A
    require_once __DIR__ . './classes/group.php';
    $group = new Group();

    // $group_joins = $Group->groupjoin($_SESSION['userId']);
    $group_join = $group->groupjoin($userId);

    if (empty($group_join)) {
        echo '<div class = prompt_1>';
        echo '<h4>グループを作成して友達とギフトを贈りあおう！</h4>';
        echo '</div>';
    } else {
        foreach ($group_join as $join) {

    ?>

            <div>
                <div class="home" style="padding:50px; margin: auto; width: 770px; height: 150px; border-radius:10px;">
                    <p class="home_groupname"><?= $join['groupname'] ?> ></p>
                    <div class="display">

                        <?php // ギフトが送られているか判定・・・B
                        $gift_group = $group->giftgroup((int)$join['group_id'], $userId);
                        if (empty($gift_group)) {
                            echo '<div class = prompt_2>';
                            echo '<h4>グループに商品を投稿しましょう！</h4>';
                            echo '</div>';
                        } else {
                            $cnt = 0;
                            foreach ($gift_group as $gift) {
                                $img = base64_encode($gift['image']);
                                if ($cnt == 0) {

                        ?>

                                    <a href="home_sub.html" style="text-decoration: none; color: #000000;">
                                        <!-- ギフト詳細画面遷移 -->
                                        <table border="1" align="left" class="home_3">
                                            <tr>
                                                <td colspan="2" class="gift_display" align=center><img src="data:;base64,<?php echo $img; ?>" width="180px;" height="180px">
                                                    <h5><?= $gift['gift_name'] ?></h5>
                                                </td>
                                            </tr>
                                        </table>
                                    </a>
                                <?php
                                }
                                if ($cnt == 1) {
                                ?>

                                    <a href="home_sub.html" class="detail_display">
                                        <!-- ギフト詳細画面遷移 -->
                                        <table border="1" align="left" class="home" class="home_3">
                                            <tr>
                                                <td colspan="2" class="gift_display" align=center><img src="data:;base64,<?php echo $img; ?>" width="180px;" height="180px">
                                                    <h5><?= $gift['gift_name'] ?></h5>
                                                </td>
                                            </tr>
                                        </table>
                                    </a>
                                <?php
                                }
                                if ($cnt == 2) {
                                ?>

                                    <a href="home_sub.html" class="detail_display">
                                        <!-- ギフト詳細画面遷移 -->
                                        <table border="1" align="left" class="home" class="home_3">
                                            <tr>
                                                <td colspan="2" class="gift_display" align=center><img src="data:;base64,<?php echo $img; ?>" width="180px;" height="180px">
                                                    <h5><?= $gift['gift_name'] ?></h5>
                                                </td>
                                            </tr>
                                        </table>
                                    </a>
                            <?php // B'
                                }
                            }
                            ?>

                    </div>
                </div>
                <div class="detail_look_1">
                    <p class="detail_look">
                        もっと見る +</p>
                </div>
            </div>

<?php // A'
                        }
                    }
                }
?>

</body>

</html>