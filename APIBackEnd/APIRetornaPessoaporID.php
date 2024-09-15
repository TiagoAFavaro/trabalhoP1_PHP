<?php
	//Cabeçalho informando que é JSON 
	header('Content-Type: application/json');
	
	//Testa se foi chamado pelo metodo POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST' )
	{
		$api_token = $_POST['api_token'];
		if ($api_token == 'TokendeTeste' )
		{
			$id = $_POST['id_pessoa'];
		
			//Conexão ao banco
			require_once('dbConnect.php');
			
			//Define a coleção
			mysqli_set_charset($conn,$charset);
			
			$query = 'SELECT id, nome, idade FROM pessoas where id = '. $id;
			
			//Preparar a consulta ao banco
			$stmt = mysqli_prepare($conn, $query);
			
			//Executa e armazena a query na memoria
			mysqli_stmt_execute($stmt);
			mysqli_stmt_store_result($stmt);
			
			//associa os campos da query a variaveis no php
			mysqli_stmt_bind_result($stmt, $id, $nome, $idade);
			
			//criando uma array
			$response = array();
			
			//Carrega os dados em um array
			if (mysqli_stmt_num_rows($stmt) > 0 )
			{
				while (mysqli_stmt_fetch($stmt))
				{
					array_push($response, array( "id" => $id,
											"nome" => $nome,
											"idade" => $idade ));
				}
			}
			else
			{
				$response['erro'] = 'Registro não encontrado';
			}
				
			//Enviar o array com os dados para a tela
			//em formato json
			echo json_encode($response);
			
		}
		else
		{
			$response['auth_token'] = false;
			echo json_encode($response);
		}
	}

?>