# DB
### info_account: 生徒アカウントの情報
- user_name(varchar): ユーザー名
- login_id(varchar): ログインID
- user_pass(varchar): パスワード
- table_id(int): ユーザー識別番号
- memo(varchar): メモ帳内容
- countdown_title(varchar): カウントダウン(タイトル)
- countdown_date(date): カウントダウン(yyyy-MM-dd)

### info_director: 管理者アカウントの情報
- director_id(varchar): 管理者ID
- director_name(varchar): 管理者名
- director_pass(varchar): パスワード
- table_id(int): 管理者識別番号

### info_feedback: 復習リストの情報
- table_id(int): ユーザー識別番号
- book_id(varchar): テキストID
- question_number(int): 問題番号

### info_my_book_index: My単語帳の情報(基本データ)
- table_id(int): ユーザー識別番号
- book_id(varchar): テキストID
- book_name(varchar): テキスト名
- memo(varchar): 目次内容

### info_my_book_data: My単語帳の情報(単語データ)
- table_id(int): ユーザー識別番号
- book_id(varchar): テキストID
- word(varchar): 問題
- answer(varchar): 解答
- question_number(int): 問題番号

### info_notice: お知らせの情報
- id(int): お知らせ番号
- title(varchar): タイトル
- date(date): 通知日(yyyy-MM-dd)
- detail(varchar): お知らせ詳細

### info_image: 管理者が登録したスタンプの情報
- table_id(int): 管理者識別番号
- img_id(int): スタンプID(QRコードの識別用)
- stamp_id(varchar): スタンプID(スタンプ画像の識別用)
- stamp_prob(varchar): 獲得率(%)
- img_extention(varchar): スタンプ画像の拡張子
- img_title(varchar): スタンプのタイトル
- date_limit(date): 有効期限
- stamp_state(varchar): スタンプ取得の可否

### info_stamp: ユーザーが獲得したスタンプの情報
- id(int): スタンプ番号
- user_table_id(int): 獲得した生徒の識別番号
- director_table_id(int): 作成した管理者の識別番号
- img_id(int): スタンプの識別番号
- stamp_id(varchar): スタンプ画像の識別番号
- get_date(date): スタンプ獲得日時(yyyy-MM-dd)

# 通知コード（遷移先）
- 0: 未登録アカウント（ログイン画面）
- 1: パスワード不一致（ログイン画面）
- 2: データベース接続エラー → 再ログイン要請（ログイン画面）
- 3: 復習リストが空（ホーム画面）
- 4: アカウント情報更新完了（アカウント情報更新画面）
- 5: アカウント情報更新失敗（アカウント情報更新画面）
- 6: ログアウト（ログイン画面）
- 7: My単語帳作成エラー → 既存の単語帳がある（My単語帳編集画面）
- 8: スタンプ取得（スタンプカード画面）
- 9: API接続エラー（ホーム画面）
- 10: アカウント作成エラー → 既存アカウントがある（アカウント作成画面）
- 11: My単語帳作成エラー → 既存の単語帳がある（My単語帳作成画面）
- 12: データベース接続エラー → 入力内容の確認要請（ホーム画面）
- 13: 原因不明のエラー（ログイン画面）
- 14: アカウント登録完了（ログイン画面）
- 15: アカウント削除完了（ログイン画面）
- 16: フォーム入力エラー（参考書）（form.php）
- 17: フォーム入力エラー（数値）（form.php）
- 18: フォーム入力エラー（参考書）（form2.php）
- 19: フォーム入力エラー（数値）（form2.php）
- 20: フォーム入力エラー（参考書）（form3.php）
- 21: スタンプ有効期限切れ（スタンプカード画面）
- 22: 未登録アカウント（管理者ログイン画面）
- 23: パスワード不一致（管理者ログイン画面）
- 24: データベース接続エラー → 再ログイン要請（管理者ログイン画面）
- 25: 管理者ログイン完了（管理者ホーム画面）
- 26: アカウント作成エラー → 既存アカウントがある（管理者アカウント作成画面）
- 27: アカウント作成完了（管理者ログイン画面）
- 28: ログアウト（管理者ログイン画面）
- 29: スタンプ登録完了（スタンプ一覧画面）
- 30: 管理者アカウント情報更新完了（管理者アカウント情報更新画面）
- 31: 管理者アカウント情報更新失敗（管理者アカウント情報更新画面）
- 32: 管理者アカウント情報削除完了（管理者ログイン画面）
- 33: ユーザースタンプ削除完了（スタンプカード画面）
- 34: 管理者スタンプ更新完了（スタンプ一覧画面）
- 35: 管理者スタンプ削除完了（スタンプ一覧画面）
- 36: フォーム入力エラー（参考書）（form9.php）
- 37: フォーム入力エラー（数値）（form9.php）
- 38: フォーム入力エラー（単元）（form10.php）
- 39: フォーム入力エラー（難易度）（form10.php）
- 40: フォーム入力エラー（数値）（form10.php）
- 41: QR読み取りエラー（未ログイン）(ログイン画面)
