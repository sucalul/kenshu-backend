# kenshu-backend

## top(記事一覧ページ)
http://localhost:8080/articles

## ERD
https://app.diagrams.net/#G1TGqFK3qw8rmY8huXjy_gyperxViDhmJq

## 起動方法
- `make up` したら各テーブルが作られ、初期データがいくつか入る

### 初回
```
$ make build
$ make up
```

### 2回目以降
```
$ make up
```

### webコンテナ入る
```
$ make exec
```

### dbコンテナ入る
```
$ make exec-db
```
