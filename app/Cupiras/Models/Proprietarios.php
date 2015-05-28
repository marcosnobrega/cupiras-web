<?php namespace Cupiras\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Proprietarios extends Model {
	
	public static function createTable($schema) {
		$schema->drop("proprietarios");
		$schema->create("proprietarios", function($table) {
			$table->increments("id");
			$table->string("nome");
			$table->string("rg");
			$table->string("cpfcnpj");
			$table->string("endereco");
			$table->string("contato");
			$table->string("email");
			$table->string("senha");
		});
	}

}