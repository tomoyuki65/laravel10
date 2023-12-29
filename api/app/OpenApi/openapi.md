# API仕様書

> Version 1.0.0

Laravel10のバックエンドAPIのAPI仕様書

## Path Table

| Method | Path | Description |
| --- | --- | --- |
| GET | [/api/v1/user/{uid}](#getapiv1useruid) | ユーザー情報取得 |
| POST | [/api/v1/user](#postapiv1user) | ユーザー作成 |

## Reference Table

| Name | Path | Description |
| --- | --- | --- |
| User | [#/components/schemas/User](#componentsschemasuser) |  |
| BearerToken | [#/components/securitySchemes/BearerToken](#componentssecurityschemesbearertoken) |  |

## Path Details

***

### [GET]/api/v1/user/{uid}

- Summary  
ユーザー情報取得

- Security  
BearerToken  

#### Responses

- 200 ユーザー情報取得に成功

`application/json`

```ts
{
  // usersのid
  id?: integer
  // Firebaseのuid
  uid?: string
  // 名前
  name?: string
  // メールアドレス
  email?: string
  // 作成日時
  created_at?: string
  // 更新日時
  updated_at?: string
  // 削除日時
  deleted_at?: string
}
```

- 500 サーバーエラー

`application/json`

```ts
{
  // internal server error
  message?: string
}
```

***

### [POST]/api/v1/user

- Summary  
ユーザー作成

#### RequestBody

- application/json

```ts
{
  // Firebaseのuid
  uid: string
  // 名前
  name: string
  // メールアドレス
  email: string
}
```

#### Responses

- 201 正常終了

`application/json`

```ts
{
  // created
  message?: string
}
```

- 500 サーバーエラー

`application/json`

```ts
{
  // internal server error
  message?: string
}
```

## References

### #/components/schemas/User

```ts
{
  // usersのid
  id?: integer
  // Firebaseのuid
  uid?: string
  // 名前
  name?: string
  // メールアドレス
  email?: string
  // 作成日時
  created_at?: string
  // 更新日時
  updated_at?: string
  // 削除日時
  deleted_at?: string
}
```

### #/components/securitySchemes/BearerToken

```ts
{
  "type": "http",
  "scheme": "bearer",
  "bearerFormat": "JWT"
}
```