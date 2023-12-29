# Laravel10のバックエンドAPIと管理画面のサンプル  
Laravel10とlaravel-adminを利用したバックエンドAPIと管理画面のサンプルです。  

## 使用技術  
Laravel               "10.31.0"  
PHP                   "8.2.12"  
encore/laravel-admin  "1.8.19"  
Docker  
docker-compose  

## APIの開発環境構築  
①環境変数ファイル「.env」を配置  
  
<br/>
  
②ビルド  
```  
$ docker compose build --no-cache
```  

<br/>

③コンテナ起動  
```  
$ docker compose up -d
```  

<br/>

④依存関係をインストール  
```
$ docker compose exec app composer install
```  

<br/>

⑤testの実行  
```
$ docker compose exec app php artisan test
```  

## 管理画面の開発環境構築  
①別途composerを準備し、composer installを実行しておく  
  
<br/>
  
②環境変数ファイル「.env」を配置  
  
<br/>
  
③sailコマンドのエイリアスを設定  
```  
$ echo 'alias sail="./vendor/bin/sail"' >> ~/.zshrc  
```  
  
<br/>
  
④コンテナ起動  
```  
$ sail up -d
```  
  
## 参考記事  
