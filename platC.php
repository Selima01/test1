<?php
	include '../config.php';
	include_once '../Model/plat.php';
	class PlatC {
		function afficherPlat(){
			$sql="SELECT * FROM plat";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}
			catch(Exception $e){
				die('Erreur:'. $e->getMessage());
			}
		}
		function supprimerPlat($id_plat){
			$sql="DELETE FROM plat WHERE id_plat=:id_plat";
			$db = config::getConnexion();
			$req=$db->prepare($sql);
			$req->bindValue(':id_plat', $id_plat);
			try{
				$req->execute();
			}
			catch(Exception $e){
				die('Erreur:'. $e->getMessage());
			}
		}
        function ajouterPlat($plat){

            $sql = "INSERT INTO plat (Nomplat, descP, prix, img)
                      VALUES (:Nomplat, :descP, :prix, :img)";
         $db = config::getConnexion();
         try{
             $query = $db->prepare($sql);
             $query->execute([
                 'Nomplat'=> $plat->getNomplat(),
                 'descP'=> $plat->getdescP(),
				 'prix'=> $plat->getprix(),
                 'img'=> $plat->getimg()
             ]);
             header("Location: ../Views/dashboard.php");
     } catch (PDOExeption $e){
         $e->getMessage();
     }
     
         }
		function recupererPlat($id_plat){
			$sql="SELECT * from plat where id_plat=$id_plat";
			$db = config::getConnexion();
			try{
				$query=$db->prepare($sql);
				$query->execute();

				$plat=$query->fetch();
				return $plat;
			}
			catch (Exception $e){
				die('Erreur: '.$e->getMessage());
			}
		}
		
		function modifierPlat($plat, $id_plat){
			try {
				$db = config::getConnexion();
				$query = $db->prepare(
					"UPDATE plat SET 
						Nomplat = :Nomplat, 
						descP = :descP, 
						prix = :prix,
						img = :img
					WHERE id_plat = :id_plat"
				);

				$query->execute([
                    'Nomplat' => $plat->getNomplat(),
					'descP' => $plat->getdescP(),
					'prix' => $plat->getprix(),
					'img' => $plat->getimg(),
					'id_plat' => $id_plat
				]);
				header("Location: ../Views/dashboard.php");
				echo $query->rowCount() . " records UPDATED successfully <br>";

			} catch (PDOException $e) {
				die($e->getMessage());
			}
		}

		function afficherPlaat(){
			$sql="SELECT * FROM plat order by id_plat desc ";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}
			catch(Exception $e){
				die('Erreur:' . $e->getMessage());
			}
		}

		function afficherPlaaat(){
			$sql="SELECT * FROM plat order by prix desc ";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}
			catch(Exception $e){
				die('Erreur:' . $e->getMessage());
			}
		}
		function rechercheplat(){
			$sql="SELECT * FROM plat  ";
			$db = config::getConnexion();
			try{
				$liste = $db->query($sql);
				return $liste;
			}
			catch(Exception $e){
				die('Erreur:' . $e->getMessage());
			}
			if (($Mot == "")||($Mot == "%")) {
				// Si aucun mot cl?? n'a ??t?? saisi,
				// le script demande ?? l'utilisateur
				// de bien vouloir pr??ciser un mot cl??
				
					echo "
					Veuillez entrer un mot cl?? s'il vous pla??t!
					<p>";
				
				}
				
				else {
				// On selectionne les enregistrements contenant le mot cl??
				// dans les keywords ou le titre
					$query = "SELECT distinct count(lien) FROM search
					WHERE keyword LIKE \"%$Mot%\"
					OR titre LIKE \"%$Mot%\"
					";
				
					$result = mysql_query($query);
				
					$row = mysql_fetch_row($result);
				
					$Nombre = $row[0];
				
				// Si aucun enregistrement n'est retourn??,
				// on affiche un message ad??quat
				if ($Nombre == "0") {
					echo "
					<h2>Aucun r??sultat ne correspond ?? votre recherche</h2>
				
					<p>
				
					";
					if ($Nombre == "1") {
						echo "
						<a name=\"#resultat\"><h2>R??sultat: Un article trouv??</h2></a>
					
						<p>";
					
						}
						// Dans le cas contraire le message est au pluriel...
						else {
						echo "
						<a name=\"#resultat\"><h2>R??sultat: $Nombre articles trouv??s</h2></a>
					
						<p>";
					
						}
						while($row = mysql_fetch_row($result))
						{
							echo "
							<p>\n
							<b>$row[2]</b>\n
							<br><a href=\"../$row[0]\">Visualiser l'article</a>\n
							<p>\n
							";
					
						}
					}
					
					}
					
					// on ferme la base
					
					
					
				
				}

				
		}
	
	
?>