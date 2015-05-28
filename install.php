<?php
require "vendor/autoload.php";
$_ENV["CUPIRAS_BASE"] = "/sites/TemplatesSubmit/cupiras";

use Cupiras\Models\Proprietarios;
use Cupiras\Models\Funcionarios;
use Cupiras\Models\Bovinos;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection(array(
		'driver' => 'sqlite',
		'database' => 'cupiras.db',
		'charset' => 'utf8',
		'collations' => 'utf8_unicode_ci'
));

$capsule->setAsGlobal();
$capsule->bootEloquent();
Proprietarios::createTable($capsule->schema());
Funcionarios::createTable($capsule->schema());
Bovinos::createTable($capsule->schema());