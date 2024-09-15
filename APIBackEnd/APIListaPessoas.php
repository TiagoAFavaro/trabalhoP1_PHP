<?php
	//Cabeçalho informando que é JSON
	header('Content-Type: application/json');

	if ($_SERVER['REQUEST_METHOD'] == 'POST' )
	{
		$api_token = $_POST['api_token'];
		if ($api_token == 'TokendeTeste')
		{
			
			//Conexão ao banco
			require_once('dbConnect.php');
			
			//Define a coleção na nossa Conexão
			mysqli_set_charset($conn, $charset);
			
			$query = 'SELECT id, nome, idade FROM pessoas';
			
			//Prepara a consulta ao banco de dados
			$stmt = mysqli_prepare($conn, $query);
			
			//Executa e armazena a query na memoria
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			
			//associa os campos da query a variaveis aqui no php
			mysqli_stmt_bind_result($stmt, $id, $nome, $idade);
			
			$response = array();  //criando um array para carregar os dados da tabela
			
			//Carrega os dados em um array
			if ( mysqli_stmt_num_rows($stmt) > 0 ) {
				while ( mysqli_stmt_fetch($stmt)) {
					array_push($response, array( "id" => $id,
												 "nome" => $nome,
												 "idade" => $idade ));
				}	
			}	
			
			//Envia para a tela o array em formato json
			echo json_encode($response);
		}
		else
		{
			$response['auth_token'] = false;
			echo json_encode($response);
		}
	}
?>