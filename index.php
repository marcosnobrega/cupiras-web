<?php
session_start();
require "vendor/autoload.php";
$_ENV["CUPIRAS_BASE"] = "";

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

$config = array(
	"debug"=>true,
	"templates.path"=>"views",
	"db" => $capsule
);

$app = new \Slim\Slim($config);

$app->hook("slim.before.dispatch", function() use ($app) {
	if ($app->request->getPath() != "/" && $app->request->getPath() != "/login") {
		if (!isset($_SESSION["proprietario"]) || empty($_SESSION["proprietario"])) {
			$app->redirectTo("home");
		}
	}
});

$app->get("/", function() use ($app) {
	echo $app->render('login.phtml');
})->name("home");

$app->get("/principal", function() use ($app) {
	echo $app->render('index.phtml');
})->name("principal");

$app->post("/login", function() use ($app) {
	$email = $app->request->post("email");
	$senha = $app->request->post("senha");
	if (empty($email) || empty($senha)) {
		$app->flash('flashMessage', "E-mail/senha inválidos");
	}
	$proprietarios = Proprietarios::all();
	foreach ($proprietarios as $proprietario) {
		if ($proprietario->email == $email && $proprietario->senha == $senha) {
			$_SESSION["proprietario"] = $proprietario;
			$app->redirectTo("principal");
		} else {
			$app->flash('flashMessage', "E-mail/senha inválidos");
		}
	}
	$app->redirectTo("home");
});

$app->get("/logout", function() use ($app) {
	session_destroy();
	$app->redirectTo("home");
});

/* Routes for Proprietarios */

$app->get("/proprietarios", function() use ($app) {
	$proprietarios = Proprietarios::all();
	$data = array();
	foreach ($proprietarios as $proprietario) {
		$data[] = $proprietario;
	}
	echo $app->render('proprietarios.phtml', array("proprietarios"=> $data));
})->name("listaproprietarios");

$app->get("/proprietarios/novo", function() use ($app) {
	echo $app->render('cadastrarproprietario.phtml');
});

$app->get("/proprietarios/deletar/:codigoProprietario", function($codigoProprietario) use ($app) {
	$toDelete = Proprietarios::find($codigoProprietario);
	$toDelete->delete();
	$app->redirectTo("listaproprietarios");
});

$app->post("/proprietarios/novo", function() use ($app) {
	$newModel = new Proprietarios();
	$newModel->nome = $app->request->post("nome");
	$newModel->rg = $app->request->post("rg");
	$newModel->cpfcnpj = $app->request->post("cpfcnpj");
	$newModel->endereco = $app->request->post("endereco");
	$newModel->contato = $app->request->post("contato");
	$newModel->email = $app->request->post("email");
	$newModel->senha = $app->request->post("senha");
	$newModel->timestamps = false;
	$status = $newModel->save();
	$flashMessage = '';
	if ($status) {
		$flashMessage = '<div class="successMessage">Cadastrado com sucesso.</div>';
	} else {
		$flashMessage = '<div class="errorMessage">Erro ao cadastrar.</div>';
	}
	$app->flash('flashMessage', $flashMessage);
	$app->redirectTo("listaproprietarios");
});

/* Routes for Funcionarios */

$app->get("/funcionarios", function() use ($app) {
	$funcionarios = Funcionarios::all();
	$data = array();
	foreach ($funcionarios as $funcionario) {
		$data[] = $funcionario;
	}
	echo $app->render('funcionarios.phtml', array("funcionarios"=> $data));
})->name("listafuncionarios");

$app->get("/funcionarios/deletar/:codigoFuncionario", function($codigoFuncionario) use ($app) {
	$toDelete = Funcionarios::find($codigoFuncionario);
	$toDelete->delete();
	$app->redirectTo("listafuncionarios");
});

$app->get("/funcionarios/novo", function() use ($app) {
	echo $app->render('cadastrarfuncionario.phtml');
});

$app->post("/funcionarios/novo", function() use ($app) {
	$funcionario = new Funcionarios();
	$funcionario->nome = $app->request->post("nome");
	$funcionario->rg = $app->request->post("rg");
	$funcionario->cpf = $app->request->post("cpf");
	$funcionario->endereco = $app->request->post("endereco");
	$funcionario->contato = $app->request->post("contato");
	$funcionario->timestamps = false;
	$status = $funcionario->save();
	$flashMessage = '';
	if ($status) {
		$flashMessage = '<div class="successMessage">Cadastrado com sucesso.</div>';
	} else {
		$flashMessage = '<div class="errorMessage">Erro ao cadastrar.</div>';
	}
	$app->flash('flashMessage', $flashMessage);
	$app->redirectTo("listafuncionarios");
});

/* Routes for Bovinos */

$app->get("/bovinos", function() use ($app) {
	$bovinos = Bovinos::all();
	$data = array();
	foreach ($bovinos as $bovino) {
		$data[] = $bovino;
	}
	echo $app->render('bovinos.phtml', array("bovinos"=> $data));
})->name("listabovinos");
	
$app->get("/bovinos/deletar/:codigoBovino", function($codigoBovino) use ($app) {
	$toDelete = Bovinos::find($codigoBovino);
	$toDelete->delete();
	$app->redirectTo("listabovinos");
});
	
$app->get("/bovinos/novo", function() use ($app) {
	echo $app->render('cadastrarbovino.phtml');
});

$app->post("/bovinos/novo", function() use ($app) {
	$bovino = new Bovinos();
	$bovino->brinco = $app->request->post("brinco");
	$bovino->datanascimento = $app->request->post("datanascimento");
	$bovino->datavacina = $app->request->post("datavacina");
	$bovino->nome = $app->request->post("nome");
	$bovino->mae = $app->request->post("mae");
	$bovino->pai = $app->request->post("pai");
	$bovino->raca = $app->request->post("raca");
	$bovino->timestamps = false;
	$status = $bovino->save();
	$flashMessage = '';
	if ($status) {
		$flashMessage = '<div class="successMessage">Cadastrado com sucesso.</div>';
	} else {
		$flashMessage = '<div class="errorMessage">Erro ao cadastrar.</div>';
	}
	$app->flash('flashMessage', $flashMessage);
	$app->redirectTo("listabovinos");
});

$app->run();
