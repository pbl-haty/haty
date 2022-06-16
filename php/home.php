<?php
    require_once __DIR__ . './header.php';
    $userId = 2;
?>
    <link rel="stylesheet" href="../css/home.css">
</header>

<br>
<body>
    <div style="display: flex; justify-content:space-around; align-items: flex-start; margin-top: 120px;">
        <h1 style="display: block;">グループ一覧</h1>
        <div>
            <button style="font-size:20px;">作成</button>
            <button style="font-size:20px;">参加</button>
        </div>
    </div>
    <hr>







<?php // グループに所属しているか判定・・・A
    require_once __DIR__ . './classes/group.php';
    $group = new Group();

    // $group_joins = $Group->groupjoin($_SESSION['userId']);
    $group_join = $group->groupjoin($userId);

    if(empty($group_join)){
        echo '<h4>グループを作成して友達とギフトを贈りあおう！</h4>';
    } else {
        foreach($group_join as $join){
            
?>

    <div>
        <div class="home" style="padding:50px; margin: auto; width: 770px; height: 150px; border-radius:10px;">
            <p style="margin-top: -20px; font-size: 25px; text-align: left; color: #000000;"><?= $join['groupname'] ?> ></p>
            <div style="position: absolute;">

<?php // ギフトが送られているか判定・・・B
            $gift_group = $group->giftgroup( (int)$join['group_id'], $userId);
            if(empty($gift_group)){
                echo '<h4>グループに商品を投稿しましょう！</h4>';
            } else {
                $cnt = 0;
                foreach($gift_group as $gift){
                    $img = base64_encode($gift['image']);
                    if($cnt == 0) {
                    
?>
         
                <a href="home_sub.html" style="text-decoration: none; color: #000000;"> <!-- ギフト詳細画面遷移 -->
                    <table border="1" align="left" class="home"
                        style=" width: 250px; border-radius:10px; border: 2px solid #000000;background-color: #FFFFFF;">
                        <tr>
                            <td colspan="2" style="font-size: 20px; border: none;" align=center><img src="data:;base64,<?php echo $img; ?>"
                                    width="180px;" height="180px">
                                <h5><?= $gift['gift_name'] ?></h5>
                            </td>
                        </tr>
                    </table>
                </a>
<?php
                    }
                    if($cnt == 1) {
?>

                <a href="home_sub.html" style="text-decoration: none; color: #000000;"> <!-- ギフト詳細画面遷移 -->
                <table border="1" align="left" class="home"
                    style=" width: 250px; border-radius:10px; border: 2px solid #000000;background-color: #ffffff;">
                    <tr>
                        <td colspan="2" style="font-size: 20px; border: none;" align=center><img src="data:;base64,<?php echo $img; ?>"
                            width="180px;" height="180px">
                        <h5><?= $gift['gift_name'] ?></h5>
                    </td>
                    </tr>
                </table>
                </a>
<?php
                    }
                    if($cnt == 2) {
?>

                <a href="home_sub.html" style="text-decoration: none; color: #000000;"> <!-- ギフト詳細画面遷移 -->
                <table border="1" align="left" class="home"
                    style=" width: 250px; border-radius:10px; border: 2px solid #000000;background-color: #ffffff;">
                    <tr>
                        <td colspan="2" style="font-size: 20px; border: none;" align=center><img src="data:;base64,<?php echo $img; ?>"
                            width="180px;" height="180px">
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
        <div style="text-align: center;">
            <p
                style="display: inline-block; width: 200px; height:30px; border: 2px solid #000000; border-radius: 30px; padding: auto; margin-top: 160px; text-align: center;">
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