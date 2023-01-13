<?php
// ヘッダーを読み込む
require_once __DIR__ . '/header.php';
// バックエンドを読み込む
require_once __DIR__ . '/gift_detail_backend.php';

// ユーザーIDとギフトIDを取得する
$userId = $_SESSION['uid'];
$giftId = $_GET['id'];

// ギフトオブジェクトとユーザーオブジェクトを生成
$gift = new Gift();
$user = new User();

?>
<link rel="stylesheet" href="../css/home.css">
<link rel="stylesheet" href="../css/gift_detail.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

</head>

<?php
$giftgroup = $gift->getGiftGroup($userId, $giftId);
if (empty($giftgroup)) {
    echo '<br><div class="gift_detail">';
    echo '<div class = prompt_1>';
    echo '<h4>URLが間違っているか<br>投稿が削除されたギフトです。</h4>';
    echo '</div></div>';
    echo '<head><title>Error</title></head>';
} else {

    // 「getGift()メソッド」を呼び出す
    $gift_info = $gift->getGift($giftId);

    // 「getUser()メソッド」を呼び出す
    $post_user = $user->getUser($gift_info['user_id']);

    // 投稿したユーザーのアイコン画像情報を取得
    $post_user_icon = base64_encode($post_user['icon']);

    // 引き渡し条件分岐(変更予定)
    if ($gift_info['conditions'] == 1) {
        $derivery_conditions = '手渡し';
    } else if ($gift_info['conditions'] == 2) {
        $derivery_conditions = '配送';
    } else if ($gift_info['conditions'] == 3) {
        $derivery_conditions = '手渡し・配送';
    }

    // ギフト画像情報を取得（1枚目のみ・変更予定）
    $gift_image = base64_encode($gift_info['image']);

    // 「getGood()メソッド」を呼び出し、いいね数といいねを押した人の情報を取得する。
    list($good, $good_name) = $gift->getGood($giftId);

    // 全てのコメント情報を取得
    $comment_all = $gift->getComment($giftId);

    // タイトルの処理
    if (empty($gift_info['gift_name'])) { ?>

        <head>
            <title>Error</title>
        </head>
    <?php } else { ?>

        <head>
            <title><?php echo $gift_info['gift_name']; ?></title>
        </head>
    <?php }
    ?>


    <head>
        <title><?php echo $gift_info['gift_name']; ?></title>
    </head>

    <body>

        <br>
        <div class="gift_detail">
            <div class="tabs">
                <input id="all" type="radio" name="tab_item" <?php if(empty($_POST['tab-comment'])) { echo 'checked'; } ?>>
                <label id="button" class="tab_item" for="all">ギフト詳細</label>
                <input id="comment" type="radio" name="tab_item" <?php if(!empty($_POST['tab-comment'])) { echo 'checked'; } ?>>
                <label class="tab_item" for="comment" id="scroll-btn">コメント</label>
                <div class="tab_content" id="all_content" style="display: none;">
                    <div class="tab_content_description">
                        <div class="gift_detail_main">
                            <!-- <h2 class="syosai">ギフト詳細</h2> -->
                            <?php
                                $gift_addimage = $gift->getaddimage($giftId);
                                if (empty($gift_addimage)) {
                                    echo '<ul class="slider-none">';
                                } else {
                                    echo '<ul class="slider">';
                                }
                            ?>
                                <li><img class="gift_display_detail" src="data:;base64,<?php echo $gift_image; ?>" alt=""></li>
                            <?php
                                foreach ($gift_addimage as $addimage) {
                                    $addimg = base64_encode($addimage['image']);
                            ?>
                                    <li><img class="gift_display_detail" src="data:;base64,<?= $addimg ?>" alt=""></li>
                            <?php
                                }
                            ?>
                            </ul>

                            <div class="display_flex">
                                <div class="button-list2">
                                    <div class="good_count">
                                        <form method="post" class="good_sentence">
                                            <input type="hidden" name="giftid" value="<?php echo $giftId; ?>">
                                            <!-- 既にいいねを押しているかを確認 -->
                                            <?php if (empty($gift->checkGood($giftId, $userId))) { ?>
                                                <button type="submit" name="favorite_before" class="favorite_before"></button>
                                                <div class="good_number_before">
                                                    <!-- いいねを押した人の一覧に遷移する（予定） -->
                                                    <!-- <a href="#" class="good_count_position"><?php echo $good; ?></a> -->
                                                </div>
                                            <?php } else { ?>
                                                <button type="submit" name="favorite_after" class="favorite_after"></button>
                                                <div class="good_number_after">
                                                    <!-- いいねを押した人の一覧に遷移する（予定） -->
                                                    <!-- <a href="#" class="good_count_position"><?php echo $good; ?></a> -->
                                                </div>
                                            <?php } ?>
                                        </form>
                                        <?php
                                            if ($userId == $gift_info['user_id']) {
                                                echo "<p class='cnt-good'>$good</p>";
                                            } else {
                                                echo "<p class='cnt-margin'></p>";
                                            }
                                        ?>
                                    </div>
                                </div>

                                <p class="gift_name"><?php echo $gift_info['gift_name']; ?></p>

                                <!-- ギフトの修正ボタン -->
                                <div class="edit_button_frame">
                                    <?php if ($userId == $gift_info['user_id']) { ?>
                                        <a href="gift_detail_edit.php?id=<?php echo $giftId; ?>" class="btn-style">編集</a> 
                                    <?php } ?>
                                </div>
                            </div>

                            <div class="button-list1">
                                <div class="gift_post">
                                    <!-- <h4>投稿者</h4> -->
                                    <!-- ユーザーのプロフィール画面に遷移 -->
                                    <a class="gift_post_detail" href="user_profile.php?id=<?php echo $post_user['uid']; ?>">
                                        <img src="data:;base64,<?php echo $post_user_icon; ?>">
                                        <p class="gift_contributor"><?php echo $post_user['name']; ?></p>
                                    </a>
                                </div>
                            </div>

                            <!-- <p class="explain_sentence">ギフト詳細</p> -->

                            <table class="gift_table">
                                <tr>
                                    <th>取引方法</th>
                                    <td class="gift_table_span"></td>
                                    <td class="gift_table_width"><?php echo $derivery_conditions ?></td>
                                </tr>
                                <tr>
                                    <th>カテゴリ</th>
                                    <td class="gift_table_span"></td>
                                    <td class="gift_table_width"><?php echo $gift_info['category_name'] ?></td>
                                </tr>
                                <tr>
                                    <th>投稿日時</th>
                                    <td class="gift_table_span"></td>
                                    <td class="gift_table_width"><?php echo $gift_info['post'] ?></td>
                                </tr>
                                <tr>
                                    <th>申請状況</th>
                                    <td class="gift_table_span"></td>
                                    <td class="gift_table_width">
                                        <?php if (isset($gift_info['judge'])) {
                                            echo '取引完了済み';
                                        } else {
                                            if (empty($gift_info['applicant'])) {
                                                echo '受け取り申請可';
                                            } else {
                                                echo '受け取り申請不可';
                                            }
                                        }
                                        ?>
                                    </td>
                                </tr>
                            </table>

                            <p class="gift_explain_title">詳細情報</p>

                            <div class="gift_explain">
                                <p class="once_sentence">
                                    <?php
                                    if (empty($gift_info['giftcomment'])) {
                                        echo '詳細情報がありません。';
                                    } else {
                                        echo $gift_info['giftcomment'];
                                    }
                                    ?>
                                </p>
                            </div>     

                            <?php if ($userId == $gift_info['user_id']) {
                                if (isset($gift_info['applicant']) && empty($gift_info['judge'])) {
                                    // 申請者の情報を取得
                                    $applicant_info = $user->getUser($gift_info['applicant']);
                                    $applicant_icon = base64_encode($applicant_info['icon']);
                                    $applicant_name = $applicant_info['name'];
                            ?>
                                    <hr>
                                    <div class="done_button_space">
                                        <div class="applicant_info">
                                            <div class="applicant_icon">
                                                <a href="user_profile.php?id=<?php echo $gift_info['applicant']; ?>">
                                                    <img src="data:;base64,<?php echo $applicant_icon; ?>">
                                                    <p><?php echo $applicant_name; ?> さん</p>
                                                </a>
                                            </div>
                                            <p>が申請しています。</p>
                                            <p>コメントでやり取りをし、受け渡し後取引完了を押しましょう。</p>
                                        </div>

                                        <form method="post">
                                            <input type="hidden" name="giftid" value="<?php echo $giftId; ?>">
                                            <button type="submit" class="done_button" name="done_button">取引完了</button>
                                        </form>
                                    </div>
                                <?php }
                            } else {
                                if (empty($gift_info['judge'])) { ?>
                                    <form class="gift_sentence" method="post">
                                        <input type="hidden" name="giftid" value="<?php echo $giftId; ?>">
                                        <?php if (empty($gift_info['applicant'])) { ?>
                                            <button type="submit" class="request_sentence" name="applygift">ほしい！</button>
                                        <?php } elseif ($gift_info['applicant'] == $userId) { ?>
                                            <button type="submit" class="request_sentence" name="cancelgift">キャンセル</button>
                                        <?php } ?>
                                    </form>
                            <?php }
                            } ?>

                        </div>
                    </div>
                </div>
                <!-- <hr> -->

                <!--吹き出しはじまり-->
                <div class="tab_content" id="comment_content" style="display: none;">
                    <div class="tab_content_description">
                            <div class="chatting_place" id="scroll">
                                <!-- コメントのループ -->
                                <?php foreach ($comment_all as $comment) {
                                    // コメントを投稿したユーザの画像処理
                                    if($comment['uid'] != $userId) {
                                        $comment_icon = base64_encode($comment['icon']);
                                ?>
                                    <div class="onechat">
                                        <div class="faceicon">
                                            <!-- アイコン選択でプロフィール画面に遷移 -->
                                            <a href="user_profile.php?id=<?php echo $comment['uid']; ?>"><img src="data:;base64,<?php echo $comment_icon; ?>" alt=""></a>
                                        </div>
                                        <div class="says-top">
                                            <p class="comment_username"><?php echo $comment['name']; ?></p>
                                            <div class="says">
                                                <p><?php echo $comment['comment']; ?></p>
                                                <p class="comment_postdata"><?php echo $comment['post']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php 
                                        } else {
                                ?>
                                    <div class="onechat">
                                        <div class="my-says-top">
                                            <div class="my-says">
                                                <p><?php echo $comment['comment']; ?></p>
                                                <p class="comment_postdata"><?php echo $comment['post']; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                        }
                                    } 
                                ?>
                            </div>

                            <br>
                            <!--吹き出し終わり-->

                            <!-- コメント入力 -->
                            <!-- <p class="comment_nyuryoku">コメントを入力</p> -->
                            <form class="comment-flex" method="post" submit="check()">
                                <input type="hidden" name="giftid" value="<?php echo $giftId; ?>">
                                <input type="hidden" name="tab-comment" value="tab">
                                <textarea id="text_area" class="comment_box" name="comment" placeholder="（例）・ギフト状態を確認したい ・ギフトの画像を追加して欲しい など"></textarea>
                                <div class="btn_right"><button type="submit" class="comment-send_btn" name="send_comment">送信</button></div>
                            </form>                  
                    </div>
                </div>
            </div>

        <?php
    }
        ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
        <script src="../js/gift_detail.js"></script>


    </body>

    </html>