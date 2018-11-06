# GraphJS-PHP

GraphJS-PHP is a PHP client-side library to use the features of GraphJS.

## Usage

```php
$publicId = 'AAAAAAAA-BBBB-CCCC-DDDD-EEEEEEEEEEEE';
$graphJS =  new \Pho\GraphJS\GraphJS($publicId);
$data = $graphJS->login('username', 'password');
if ($data['success']) {
    // do something on successful login
}
```

## License

MIT, see [LICENSE](https://github.com/phonetworks/graphjs-lib-php/blob/master/LICENSE).
