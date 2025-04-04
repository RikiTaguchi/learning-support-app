<?php
$banner = $_GET['banner'];
if ($banner != '') {
    if ($banner == '3') {
        $banner_msg = '復習リストは空です。';
    } else if ($banner == '4') {
        $banner_msg = '更新が完了しました。';
    } else if ($banner == '5' || $banner == '31') {
        $banner_msg = '既に使用されているIDのため、更新できません。';
    } else if ($banner == '7') {
        $banner_msg = '既に登録されている単語帳名のため、変更できません。';
    } else if ($banner == '8') {
        $banner_msg = 'スタンプを取得しました。';
    } else if ($banner == '9') {
        $banner_msg = 'APIとの接続に失敗しました。入力内容にミスがないか確認してしてください。';
    } else if ($banner == '11') {
        $banner_msg = 'この単語帳名は既に登録されています。';
    } else if ($banner == '12') {
        $banner_msg = 'データベースとの接続に失敗しました。入力内容にミスがないか確認してしてください。';
    } else if ($banner == '16' || $banner == '18' || $banner == '20' || $banner == '36') {
        $banner_msg = '参考書を選択してください。';
    } else if ($banner == '17' || $banner == '19' || $banner == '37') {
        $banner_msg = '範囲内の数値を入力してください。';
    } else if ($banner == '21') {
        $banner_msg = '有効期限切れのスタンプのため取得できません。';
    } else if ($banner == '25') {
        $banner_msg = 'ようこそ、' . $director_name . 'さん。';
    } else if ($banner == '29') {
        $banner_msg = '登録が完了しました。';
    } else if ($banner == '33') {
        $banner_msg = '削除が完了しました。';
    } else if ($banner == '30' || $banner == '34') {
        $banner_msg = '更新が完了しました。';
    } else if ($banner == '35') {
        $banner_msg = '削除が完了しました。';
    } else if ($banner == '38') {
        $banner_msg = '単元を選択してください。';
    } else if ($banner == '39') {
        $banner_msg = '難易度を選択してください。';
    } else if ($banner == '40') {
        $banner_msg = '出題数は１〜１００の範囲で入力してください。';
    } else {
        $banner_msg = '';
    }
} else {
    $banner = $_POST['info_banner'];
    if ($banner == 'login') {
        $banner_msg = 'ようこそ、' . $user_name . 'さん。';
    } else if ($banner == 'update') {
        $banner_msg = '更新が完了しました。';
    } else if ($banner == 'new-book') {
        $banner_msg = '作成が完了しました。';
    } else if ($banner == 'delete') {
        $banner_msg = '削除が完了しました。';
    } else if ($banner == 'add-data') {
        $banner_msg = '追加が完了しました。';
    } else if ($banner == 'new-account') {
        $banner_msg = '登録が完了しました。';
    } else {
        $banner_msg = '';
    }
}
