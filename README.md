# A Simple Bloom Filter for PHP

[![Build Status](https://travis-ci.org/sysatom/php-bloom-filter.svg?branch=master)](https://travis-ci.org/sysatom/php-bloom-filter)

### Install

```bash
composer require sysatom/php-bloom-filter
```

### Usage

```php
use \Sysatom\BloomFilter;

$bf = new BloomFilter(100000, 7);

for ($i = 0; $i < 5000; $i++) {
    $bf->add("$i");
}

var_dump($bf->lookup('42'));
var_dump($bf->lookup('100000'));
var_dump($bf->lookup('500001'));
```

### Benchmark

```php
$bf = new \Sysatom\BloomFilter(100000, 7);
for ($i = 1; $i <= 100000; $i++) {
    $bf->add("$i");
}
```
- Total time: 18.4532 s
- Memory Used (current): 636.12 KB
- Memory Used (max): 1.63 MB

### Requirements

This project requires PHP 7.1 or newer.

### License


You can find the license for this code in [the LICENSE file](LICENSE).
