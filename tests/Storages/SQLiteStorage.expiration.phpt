<?php

/**
 * Test: Nette\Caching\Storages\SQLiteStorage expiration test.
 */

declare(strict_types=1);

use Nette\Caching\Cache;
use Nette\Caching\Storages\SQLiteStorage;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


if (!extension_loaded('pdo_sqlite')) {
	Tester\Environment::skip('Requires PHP extension pdo_sqlite.');
}


$key = 'nette';
$value = 'rulez';

$cache = new Cache(new SQLiteStorage(':memory:'));


// Writing cache...
$cache->save($key, $value, [
	Cache::EXPIRATION => time() + 3,
]);


// Sleeping 1 second
sleep(1);
clearstatcache();
Assert::truthy($cache->load($key));


// Sleeping 3 seconds
sleep(3);
clearstatcache();
Assert::null($cache->load($key));
