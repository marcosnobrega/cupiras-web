<?php namespace Cupiras\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Bovinos extends Model {
	
	public static function createTable($schema) {
		$schema->drop("bovinos");
		$schema->create("bovinos", function($table) {
			$table->increments("id");
			$table->string("brinco");
			$table->string("datanascimento");
			$table->string("datavacina");
			$table->string("nome");
			$table->string("mae");
			$table->string("pai");
			$table->string("raca");
		});
	}
	
}