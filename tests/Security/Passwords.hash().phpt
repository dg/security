<?php

/**
 * Test: Nette\Security\Passwords::hash()
 */

use Nette\Security\Passwords;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


Assert::truthy(
	preg_match('#^\$2.\$\d\d\$.{53}\z#',
	Passwords::hash(''))
);

Assert::truthy(
	preg_match('#^\$2y\$05\$123456789012345678901.{32}\z#',
	$h = Passwords::hash('dg', ['cost' => 5, 'salt' => '1234567890123456789012']))
);
echo $h;

$hash = Passwords::hash('dg');
Assert::same($hash, crypt('dg', $hash));


Assert::exception(function () {
	Passwords::hash('dg', ['cost' => 3]);
}, 'Nette\InvalidArgumentException', 'Cost must be in range 4-31, 3 given.');

Assert::exception(function () {
	Passwords::hash('dg', ['cost' => 32]);
}, 'Nette\InvalidArgumentException', 'Cost must be in range 4-31, 32 given.');

Assert::exception(function () {
	Passwords::hash('dg', ['salt' => 'abc']);
}, 'Nette\InvalidArgumentException', 'Salt must be 22 characters long, 3 given.');
