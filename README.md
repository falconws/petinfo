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

https://【設置したサーバのドメイン】/src/index.php

Linuxサーバ上で動作させる場合、  
src/  
以下に書き込み権限が必要なため、動作しない場合は

```bash
chmod -R 777 src/
```

するととりあえず動きます。  
src/ の下に cache/ を作って、その中にBlade templateが生成される仕組みになっています。
