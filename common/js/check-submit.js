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

function checkSubmit4() {
    if (confirm('この生徒アカウントを、管理者アカウントの管轄から外します。本当によろしいですか？この操作は取り消せません。')) {
        return true;
    } else {
        return false;
    }
}

function checkClick() {
    if (confirm('本当に削除しますか？')) {
        return true;
    } else {
        return false;
    }
}
