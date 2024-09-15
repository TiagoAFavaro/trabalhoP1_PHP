<?php
	$postdata = http_build_query(
		array(
			'api_token' => 'TokendeTeste'
		)
	);
	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)
	);
	$context = stream_context_create($opts);
	$result = file_get_contents('http://localhost/primeiroprojeto/APIListaPessoas.php', false, $context);			
				
	$jsonObj = json_decode($result);
?>

<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="utf-8">

    <title>Primeiro Front End</title>

  </head>
  <body>	
  <h1>Lista de Pessoas</h1>
  <BR>
  <table class="table" style="font-size: 16px;">
     <tr>
       <th style="text-align:center; width: 50%">Nome</th>
       <th style="text-align:center; width: 20%">Idade</th>
     </tr> 
	
<?php	
	foreach( $jsonObj as $pessoa )
	{
		echo "<tr>";
			echo "<td style='text-align:left; width: 50%'> $pessoa->nome </td>";
			echo "<td style='text-align:center; width: 20%'> $pessoa->idade anos </td>";
		echo "</tr>";
	}				
				
?>
     </table>
  </body>
</html>  

