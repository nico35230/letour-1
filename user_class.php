<?php

class user {

	// Identification de l'utilisateur
	function login($user, $pass) {
	
		// Authentification simple direct dans le code
		/*
		if ($user == "gaga") {
			
			$_SESSION["auth"] = true;
			
		}
		*/
		
		// Authentification par la base de données
		$sql = "SELECT id, prenom FROM membre WHERE login = '" . mysql_real_escape_string($user) . "' AND pass = '" . mysql_real_escape_string($pass) . "' LIMIT 1";
		
		$results = mysql_query($sql);
		
		$result = mysql_fetch_object($results);
		
		if ($result !== false && count($result) === 1) {
		
			$_SESSION["auth"] = true;
			$_SESSION["user_id"] = $result->id;
			$_SESSION["user_prenom"] = $result->prenom;
			
			header("Location: index.php");
		
		} else {
		
			print "Identification impossible";
			
		}
		
	}
	
function points($user_id, $etape)
	{
		//initialisation du décompte des points
		$points = 0;
		
		//chercher pronostic du user_id
		$sql = "SELECT classement, coureur_id FROM prono WHERE membre_id = '$user_id' AND type = '$etape'";
		$result = mysql_query($sql);
		
		while ($row = mysql_fetch_array($result))
		{		
			$sql2 = "SELECT classement FROM resultat WHERE type = '$etape' AND coureur_id = '" . $row["coureur_id"] . "' AND classement = '" . $row["classement"] . "'";
			$result2 = mysql_query($sql2);
			
			if (mysql_num_rows($result2) > 0)
			{
				$points = $points + 5;
				
			} else {
			
				$sql3 = "SELECT classement FROM resultat WHERE type = '$etape' AND coureur_id = '" . $row['coureur_id'] . "'";
				$results3 = mysql_query($sql3);
				
				if (mysql_num_rows($results3) > 0)
				{
					$points = $points + 1;
				}
		
			}
			
		} 
		
		return $points;
	
	}
		
	
	
	//liste de tous les utilisateurs
	function liste()
	{
		$sql = "SELECT id, prenom FROM membre";
		$results = mysql_query($sql) or die(mysql_error());
		
		$user = array();
		
		while ($result = mysql_fetch_array($results))
		{
		
			$user[] = array("user_id" => $result["id"], "prenom" => $result["prenom"]);
			
		}
		
		return $user;
	}
	
}

?>
			
		
			