<div class = "main-banner">
    <p class = "main-banner-text"><?php echo $banner_msg; ?></p>
</div>
<button class = "menu-back"></button>
<div class = "header-site-menu">
    <ul>
        <li><?php echo $user_name; ?></li>
        <li><?php make_link('ホーム', 'index.php', [$user_name, $login_id, $user_pass]) ?></li>
        <li><?php make_link('スタンプカード', 'detail_stamp.php', [$user_name, $login_id, $user_pass]) ?></li>
        <li><?php make_link('使用レポート', 'report.php', [$user_name, $login_id, $user_pass]) ?></li>
        <li><?php make_link('アカウント情報', 'info_account.php', [$user_name, $login_id, $user_pass]) ?></li>
        <li><?php make_link('ログアウト', 'logout.php', [$user_name, $login_id, $user_pass]) ?></li>
    </ul>
</div>
<div class = "header-inner">
    <form method = "post" action = "index.php">
        <?php
        echo '<input class = "info_account" type = "text" name = "user_name" value = "' . $user_name . '">';
        echo '<input class = "info_account" type = "text" name = "login_id" value = "' . $login_id . '">';
        echo '<input class = "info_account" type = "text" name = "user_pass" value = "' . $user_pass . '">';
        ?>
        <button class = "header-logo" type = "submit">
            <img src = "../common/images/stamp-logo.png" alt = "ロゴ画像">
        </button>
    </form>
    <div class="header-right-area">
        <div>
            <?php echo $login_streak; ?> 📚
        </div>
        <button class = "header-menu-button">
            <hr class = "header-menu-top">
            <hr class = "header-menu-middle">
            <hr class = "header-menu-bottom">
        </button>
    </div>
    <p class = "header-menu-info" style = "display: none;">closed</p>
</div>
