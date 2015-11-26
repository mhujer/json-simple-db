# JSON SimpleDB [![Build Status](https://travis-ci.org/mhujer/json-simple-db.svg?branch=master)](https://travis-ci.org/mhujer/json-simple-db)

[![Latest Stable Version](https://poser.pugx.org/mhujer/json-simple-db/version.png)](https://packagist.org/packages/mhujer/json-simple-db) [![Total Downloads](https://poser.pugx.org/mhujer/json-simple-db/downloads.png)](https://packagist.org/packages/mhujer/json-simple-db) [![License](https://poser.pugx.org/mhujer/json-simple-db/license.svg)](https://packagist.org/packages/mhujer/json-simple-db)  [![Coverage Status](https://coveralls.io/repos/mhujer/json-simple-db/badge.svg?branch=master&service=github)](https://coveralls.io/github/mhujer/json-simple-db?branch=master)

For a project that generates static HTML I needed a data source, so I created this simple library for storing data in JSON. **It is intended only for CLI usage by a single client, not for websites!**

Usage
----
1. Install the latest version with `composer require mhujer/json-simple-db`
2. Use it according to the example bellow and check the docblocks

```php
<?php
require_once 'vendor/autoload.php';

//initialize DB
$db = new JsonSimpleDb\Db('./foo');

//initialize table
if (!$db->tableExists('mytable')) {
    $db->createTable('mytable');
}
$table = $db->getTable('mytable');

//get items count
$table->count(); //0

//insert into table
$table->insert([
    'id' => '1',
    'name' => 'foo',
]);

//find by array - like in MongoDB
$items = $table->find(['id' => '1']);
/*
array(1) {
  [0] =>
  array(2) {
    'id' =>
    string(1) "1"
    'name' =>
    string(3) "foo"
  }
}
 */

//update record
$table->update(['id' => '1'], ['name' => 'boo']);

//delete record
$table->delete(['id' => '1']);

//persist the data to file - don't forget this :-)
$table->persist();


```

Requirements
------------
JSON SimpleDB works with PHP 5.6 or PHP 7.

Submitting bugs and feature requests
------------------------------------
Bugs and feature request are tracked on [GitHub](https://github.com/mhujer/json-simple-db/issues)

Author
------
Martin Hujer - <mhujer@gmail.com> - <http://www.martinhujer.cz>

Changelog
----------

## 1.1.1 (2015-11-26)
- Stored JSON is pretty printed

## 1.1.0 (2015-11-26)
- Added posibility to delete records

## 1.0.1 (2015-11-17)
- Comparator does strict matching

## 1.0.0 (2015-11-14)
- initial release
