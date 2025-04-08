function checkSubmit() {
    if (confirm('本当に削除しますか？')) {
        return true;
    } else {
        return false;
    }
}

function checkSubmit2() {
    if (confirm('管理者アカウントを削除すると、これまでに作成したスタンプ、ユーザーが取得したスタンプの情報は保持されますが、変更が不可能になります。本当に削除しますか？')) {
        return true;
    } else {
        return false;
    }
}

function checkSubmit3() {
    if (confirm('本当にこのスタンプを削除しますか？')) {
        return true;
    } else {
        return false;
    }
}
