# 学習サポートアプリ

## フォルダ構成
- common: 共通ファイルを格納
  - css: CSS
  - icons: アイコン画像
  - images: その他画像
  - js: JavaScript
  - parser: 構文解析器
  - phpqrcode: QRコード生成
  - qr: QRコード画像
  - stamp: スタンプ画像
  - banner.php: バナー通知管理
  - db_info.php: DB管理
  - domain_info.php: ドメイン管理（ローカル/本番の切替）
  - function.php: 共通メソッド
  - get_info.php: アカウント情報取得
- d: 管理者版のphpファイル
  - ~.php
  - ~.php
- h: 高校生版のphpファイル
  - ~.php
  - ~.php
- j: 中学生版のphpファイル
  - ~.php
  - ~.php
- e: スタンプカードのphpファイル
  - ~.php
  - ~.php

## バナー通知管理コード
  - 0: ログインが完了しました。
  - 1: ログアウトが完了しました。
  - 2: 未登録のアカウントです。
  - 3: パスワードが違います。
  - 4: 既に使用されているIDのため、登録できません。
  - 5: 既に使用されているIDのため、更新できません。
  - 6: 登録が完了しました。
  - 7: 削除が完了しました。
  - 8: 更新が完了しました。
  - 9: エラーが発生しました。
  - 10: 復習リストに追加しました。
  - 11: 復習リストから削除しました。
  - 12: 復習リストは空です。
  - 13: 既に使用されている単語帳名のため、登録できません。
  - 14: 既に使用されている単語帳名のため、更新できません。
  - 15: スタンプを取得しました。
  - 16: 有効期限切れのスタンプのため、取得できません。
  - 17: スタンプの取得には、ログインが必要です。
  - 18: 単元を選択してください。
  - 19: 難易度を選択してください。
  - 20: 出題数は１〜１００の範囲で入力してください。
  - 21: 参考書を選択してください。
  - 22: 範囲内の数値を入力してください。
  - 23: スタンプの取得上限は１日３個までです。
  - 24: 過去の日付が設定されています。

## ログ記録コード（パターン）
  - 0: ログイン（login, logout）
  - 1: テスト作成（book_idを記録）
  - 2: 暗記トレーニング（book_idを記録）
  - 3: 計算トレーニング（typeを記録）
  - 4: 復習モード（book_idを記録）
  - 5: My単語帳（set, edit, delete）
  - 6: カウントダウン（set, reset）
  - 7: スタンプ（get, set, edit, delete, reset）
  - 8: アカウント情報（set, edit, delete）
  - 9: 復習リスト（add, remove, delete）
  - 10: 生徒管理（set, edit, release）

## URL(ローカル)
  #### 管理者版
  - http://localhost/learning-support-app/d/login.php
  #### 高校生版
  - http://localhost/learning-support-app/h/login.php
  #### 中学生版
  - http://localhost/learning-support-app/j/login.php
  #### スタンプカード
  - http://localhost/learning-support-app/e/login.php

## URL(本番環境)
  #### 管理者版
  - https://wordsystemforstudents.com/d/login.php
  #### 高校生版
  - https://wordsystemforstudents.com/h/login.php
  #### 中学生版
  - https://wordsystemforstudents.com/j/login.php
  #### スタンプカード
  - https://wordsystemforstudents.com/e/login.php

## 環境構築(ローカル)
1. XAMPPをインストール
  - https://www.apachefriends.org/jp/index.html
  - PCの設定からXAMPPへのアクセスを許可しないと、ソフトを開けないので注意
2. PHPとJavaをインストール
  ```
  brew install php
  brew install openjdk
  ```
3.  エイリアスを削除し、本物のフォルダを任意の場所にコピー(今回はdesktopに配置する)
  - Finder(Macの場合)から、/Applicationsを開く
  - Applications内のXAMPPディレクトリ全体を、desktopにドラック&ドロップ
4. エイリアスを削除
  ```
  rm ~/Desktop/XAMPP
  ```
5. シンボリックリンクを作成
  ```
  ln -s /Applications/XAMPP ~/Desktop/XAMPP
  ```
6. シンボリックリンクを使ってXAMPPディレクトリに移動
  ```
  cd ~/Desktop/XAMPP
  ```
7. 作業ディレクトリに移動
  ```
  cd ~/Desktop/XAMPP/htdocs
  ```
8. リポジトリをclone
  ```
  git clone ~
  ```
9. cloneしたローカルリポジトリに移動
  ```
  cd learning-support-app
  ```
10. Git LFSをインストール(100MBを超えるファイルを扱うため)
  ```
  brew install git-lfs
  ```
11. Git LFSを有効化
  ```
  git lfs install
  ```
12. LFSで管理するファイルを指定
  ```
  git lfs track "*.jar"
  ```
13. 自動取得するファイルを指定
  ```
  git config lfs.fetchinclude "*"
  git config lfs.fetchexclude ""
  ```

## サーバーとDBの起動(ローカル)
  - XAMPPディレクトリ内のmanager-osx.app(Macの場合)を起動
  - Manage Serversタブをクリック
  - Start Allボタンをクリック
  - Status欄３つが、Runningになっていれば成功

## DBの初期設定(ローカル)
1. XAMPPからWebサーバーとDBを起動後、下記リンクにアクセス
  - http://localhost/phpmyadmin
2. wordsystemdbというDBを作成
  - 作成後、wordsystemdb内に、必要なテーブルを作成する(テーブル一覧を参照)
  - 文字列(varchar)の長さは255
  - int, dateの長さは未指定でOK
  - 単語帳データのCSVファイルをインポートする（共有ドライブからダウンロード）

## DBテーブル情報
#### info_account: アカウント情報
  - user_name(varchar): ユーザー名
  - login_id(varchar): ログインID
  - user_pass(varchar): パスワード
  - table_id(int): ユーザー識別番号
  - account_type(varchar): アカウントタイプ
  - class_id(int): 所属教室（管理者カウント）のテーブルID
#### info_countdown: カウントダウン情報
  - table_id(int): テーブルID
  - title(varchar): タイトル
  - date_limit(date): 日付
#### info_feedback: 復習リストの情報
  - table_id(int): ユーザー識別番号
  - book_id(varchar): 参考書ID
  - question_number(int): 問題番号
#### info_my_book_index: My単語帳の情報(基本データ)
  - table_id(int): ユーザー識別番号
  - book_id(varchar): 参考書ID
  - book_name(varchar): テキスト名
  - memo(varchar): 目次内容
#### info_my_book_data: My単語帳の情報(単語データ)
  - table_id(int): ユーザー識別番号
  - book_id(varchar): 参考書ID
  - word(varchar): 問題
  - answer(varchar): 解答
  - question_number(int): 問題番号
#### info_notice: お知らせの情報
  - id(int): 通し番号
  - title(varchar): タイトル
  - date(date): 通知日(yyyy-MM-dd)
  - detail(varchar): 詳細
#### info_image: 管理者が登録したスタンプの情報
  - table_id(int): ユーザー識別番号
  - img_id(int): スタンプID(QRコードの識別用)
  - stamp_id(varchar): スタンプID(スタンプ画像の識別用)
  - stamp_prob(varchar): 獲得率(%)
  - img_extention(varchar): スタンプ画像の拡張子
  - img_title(varchar): スタンプのタイトル
  - date_limit(date): 有効期限
  - stamp_state(varchar): スタンプ取得の可否
#### info_stamp: ユーザーが獲得したスタンプの情報
  - id(int): スタンプ番号
  - user_table_id(int): 獲得した生徒の識別番号
  - director_table_id(int): 作成した管理者の識別番号
  - img_id(int): スタンプの識別番号
  - stamp_id(varchar): スタンプ画像の識別番号
  - get_date(date): スタンプ獲得日時(yyyy-MM-dd)
#### info_analysis: ログの集積
  - table_id(int): ユーザー識別番号
  - log_code(int): ログコード
  - log_detail(varchar): アクションの詳細
  - log_date(datetime): 日時
#### 単語帳データ(パターン1)
  - id(int): 通し番号
  - word(varchar): 問題
  - answer(varchar): 解答
#### 単語帳データ(パターン2)
  - id(int): 通し番号
  - word(varchar): 問題
  - select1(varchar): 選択肢1
  - select2(varchar): 選択肢2
  - select3(varchar): 選択肢3
  - select4(varchar): 選択肢4
  - answer(varchar): 解答
  - type(int): 出題形式

## 単語帳データのテーブル名(パターン)
  - target_1400(1): ターゲット1400
  - target_1900(1): ターゲット1900
  - system_English(1): システム英単語
  - rapid_Reading(1): 速読英熟語
  - Vintage(2): Vintage
  - pass_3(1): 出る順パス単3級
  - pass_pre2(1): 出る順パス単準2級
  - pass_2(1): 出る順パス単2級
  - pass_pre1(1): 出る順パス単準1級
  - pass_1(1): 出る順パス単1級
  - get_Through_2600(1): ゲットスルー2600
  - meiko_original_1(1): 明光暗記テキスト(単語)
  - meiko_original_2(2): 明光暗記テキスト(文法)
  - gold_phrase(1): TOEIC金のフレーズ
  - kobun300(1): みるみる古文単語300
  - kobun315(1): 古文単語315
  - kobun330(1): 古文単語330
