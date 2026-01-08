# デプロイ・サーバー環境情報 (山勇ルーフ)

このプロジェクトはロリポップ！レンタルサーバー上で運用されています。
以下にサーバー構成とデプロイ手順を記載します。

## 🌐 公開URL
- **URL**: https://trendcompany.jp/demo/
- **ルートURL**: https://trendcompany.jp/ (WordPressが稼働中)

## 🖥 サーバー情報 (ロリポップ)

| 項目 | 設定値 | 備考 |
|---|---|---|
| **Host** | `ssh.lolipop.jp` | `~/.ssh/config` では `lolipop` として定義済み |
| **User** | `deci.jp-trendcompany` | |
| **Port** | `2222` | ロリポップ標準ポート |
| **IdentityFile** | `~/.ssh/lolipop_key` | 秘密鍵 |

## 📂 ディレクトリ構成

サーバー上のディレクトリ構成は以下のようになっています。

```text
/ (SSHルート)
├── web/
│   └── trendcompany/         # ドメインルート (https://trendcompany.jp/)
│       ├── (WordPress files) # 既存のWordPressサイト
│       └── demo/             # ★このプロジェクトの配置場所 (https://trendcompany.jp/demo/)
│           ├── index.php
│           ├── assets/
│           ├── config/
│           └── ...
```

## 🚀 デプロイ手順 (手動アップロード)

ビルドは不要です。PHPファイルをそのままサーバーに転送します。
SSH鍵 (`~/.ssh/lolipop_key`) が設定されている環境で、以下のコマンドを実行します。

```bash
# public_html の中身をサーバーの demo フォルダにアップロード
scp -i ~/.ssh/lolipop_key -P 2222 -r public_html/* deci.jp-trendcompany@ssh.lolipop.jp:web/trendcompany/demo/
```

※ `~/.ssh/config` に `Host lolipop` が設定されている場合は、以下のコマンドでも可能です。

```bash
scp -r public_html/* lolipop:web/trendcompany/demo/
```

## ⚠️ 注意事項
- **WordPressとの共存**: `web/trendcompany/` 直下にはWordPressがインストールされています。`demo` フォルダ以外のファイルを誤って削除・上書きしないように注意してください。
- **メール設定**: `config/config.php` の `MAIL_TO` 設定が正しいか確認してください。
