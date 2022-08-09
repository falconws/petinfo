# petinfo

MyPetの一部のMobの一部情報（主にビーコン）を表形式で出力します。
Linuxで動作させる事を想定しています。

# 事前に必要なソフトウェア

- PHP
- composer
- PHPが有効化されているWebサーバ

# インストール

1. git clone https://github.com/falconws/petinfo.git
1. cd petinfo
1. composer install

# 実行

https://【設置したサーバのドメイン】/【petinfo.phpのパス】

# 既知の不具合

下記は現状のMyPetのJSONのスキーマ情報の問題もあり、うまく処理できていません。

- ビーコン情報の要求レベル毎の効果レベル表示（現状はだいぶ見にくい・・）
- ビーコン効果が重複（Regenerationが複数行あったり・・）
    - ビーコン効果毎にグルーピングして、効果レベルと要求レベルをいい感じに表示できると理想・・