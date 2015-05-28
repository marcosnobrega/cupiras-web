<?php namespace Cupiras\Models;

use Illuminate\Database\Eloquent\Model as Model;

class Funcionarios extends Model {
	
	public static function createTable($schema) {
		$schema->drop("funcionarios");
		$schema->create("funcionarios", function($table) {
			$table->increments("id");
			$table->string("nome");
			$table->string("rg");
			$table->string("cpf");
			$table->string("endereco");
			$table->string("contato");
		});
	}
	
}