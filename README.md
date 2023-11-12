# Laravel10のバックエンドAPIと管理画面のサンプル  
Laravel10とlaravel-adminを利用したバックエンドAPIと管理画面のサンプルです。  

## 使用技術  
Laravel               "10.31.0"  
PHP                   "8.2.12"  
encore/laravel-admin  "1.8.19"  
Docker  
docker-compose  

## 使い方  
①ビルド  
```  
$ docker compose build --no-cache
```  

<br/>

②コンテナ起動  
```  
$ docker compose up -d
```  

<br/>

②依存関係をインストール  
```
$ docker compose exec app composer install
```  

<br/>

③testの実行  
```
$ docker compose exec app php artisan test
```  

## 参考記事  
