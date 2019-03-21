# A Simple Bloom Filter for PHP

### Install

```bash
composer require sysatom/php-bloom-filter
```

### Usage

```php
use \Sysatom\BloomFilter();

$bf = new BloomFilter(100000, 7);

for ($i = 0; $i < 5000; $i++) {
    $bf->add("$i");
}

var_dump($bf->lookup('42'));
var_dump($bf->lookup('100000'));
var_dump($bf->lookup('500001'));
```

### Requirements


This project requires PHP 7.0 or newer.

### License


You can find the license for this code in [the LICENSE file](LICENSE).