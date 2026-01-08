# デプロイ・サーバー環境情報 (山勇ルーフ)

このプロジェクトはロリポップ！レンタルサーバー上で運用されています。
以下にサーバー構成とデプロイ手順を記載します。

## 🌐 公開URL
- **URL**: https://trendcompany.jp/demo/sanyu-roof/
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
今後、他のデモサイトを追加する場合は `demo/` 以下に新しいフォルダを作成してください。

```text
/ (SSHルート)
├── web/
│   └── trendcompany/         # ドメインルート (https://trendcompany.jp/)
│       ├── (WordPress files) # 既存のWordPressサイト
│       └── demo/             # デモサイト用フォルダ
│           ├── sanyu-roof/   # ★このプロジェクト (https://trendcompany.jp/demo/sanyu-roof/)
│           │   ├── index.php
│           │   └── ...
│           └── (other_demo)/ # 今後追加するデモ
```

## 🚀 デプロイ手順 (手動アップロード)

ビルドは不要です。PHPファイルをそのままサーバーに転送します。
SSH鍵 (`~/.ssh/lolipop_key`) が設定されている環境で、以下のコマンドを実行します。

```bash
# public_html の中身をサーバーの demo/sanyu-roof フォルダにアップロード
scp -i ~/.ssh/lolipop_key -P 2222 -r public_html/* deci.jp-trendcompany@ssh.lolipop.jp:web/trendcompany/demo/sanyu-roof/
```

※ `~/.ssh/config` に `Host lolipop` が設定されている場合は、以下のコマンドでも可能です。

```bash
scp -r public_html/* lolipop:web/trendcompany/demo/sanyu-roof/
```

## ⚠️ 注意事項
- **ディレクトリ構造**: `demo` フォルダ直下にはファイルを置かず、必ずプロジェクトごとのフォルダ（例: `sanyu-roof`）を作成してその中に入れてください。
- **メール設定**: `config/config.php` の `MAIL_TO` 設定が正しいか確認してください。
