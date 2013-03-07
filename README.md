Usage example

```php
require('InterspireEMApi.php');

$apiPath = 'http://www.yourdomain.com/IEM/xml.php';
$apiUsername = 'admin';
$apiUsertoken = 'd467e49b221137215ebdab1ea4e046746de7d0ea';

$api = new InterspireEMApi($apiPath, $apiUsername, $apiUsertoken);
$response = $api->authentication->xmlApiTest();
```

API Path, Username and Token are taken from [official Interspire Email Marketer documentation](http://www.interspire.com/emailmarketer/pdf/XMLApiDocumentation.pdf)