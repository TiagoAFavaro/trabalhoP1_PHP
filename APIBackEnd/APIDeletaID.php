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
			
			$query = 'DELETE FROM pessoas where id = '. $id;
			
			//Deleta o registro do banco
			$result = mysqli_query($conn, $query);

			//criando uma array
			$response = array();

			//Testa de não deu erro no comando SQL
			if ($result)
			{   //retorna a quantidade de linhas afetadas pelo comando SQL
				if (mysqli_affected_rows($conn) > 0 )
				   $response['apagado'] = true;					
				else
				   $response['apagado'] = false;					
				
			}
			else //caso de erro no SQL
				$response['erro'] = "Erro na execução do delete";
				
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