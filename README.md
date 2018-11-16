# GraphJS-PHP

GraphJS-PHP is a PHP client-side library to use the features of GraphJS.

## Usage

```php
use Pho\GraphJS\GraphJS;
use Pho\GraphJS\GraphJSConfig;

$publicId = 'AAAAAAAA-BBBB-CCCC-DDDD-EEEEEEEEEEEE';
$host = 'https://your-graphjs-host.com';

$config = new GraphJSConfig([
    'public_id' => $publicId,
    'host' => $host,
]);

$graphJS =  new GraphJS($config);

$data = $graphJS->login('username', 'password');
if ($data['success']) {
    // do something on successful login
}
```

## License

MIT, see [LICENSE](https://github.com/phonetworks/graphjs-lib-php/blob/master/LICENSE).
