# Laravel

> Version 1.0.0

## Path Table

| Method | Path | Description |
| --- | --- | --- |
| GET | [/api/test/v1/users](#getapitestv1users) | Display a listing of the resource. |
| POST | [/api/v1/signup](#postapiv1signup) | 会員登録 |

## Reference Table

| Name | Path | Description |
| --- | --- | --- |

## Path Details

***

### [GET]/api/test/v1/users

- Summary  
Display a listing of the resource.

#### Responses

- 200 テストレスポンス

`application/json`

```ts
{
  "type": "string"
}
```

- Examples

  - 

```json
[]
```

- default 成功１

`application/json`

```ts
{
  message: string
}
```

***

### [POST]/api/v1/signup

- Summary  
会員登録

#### RequestBody

```ts
{
  "description": "会員登録"
}
```

## References