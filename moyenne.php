<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Moyenne</title>
</head>
<body>
	<?php 
		$connexion = mysqli_connect("localhost","root","","finelia_test") or die("Connexion impossible.");
		$nom 		= htmlspecialchars($_POST["lname"]);
		$nom 		= mysqli_real_escape_string($connexion,$nom);
		$prenom 	= htmlspecialchars($_POST["fname"]);
		$prenom 	= mysqli_real_escape_string($connexion,$prenom);
		$matiere 	= htmlspecialchars($_POST["matiere"]);
		$matiere 	= mysqli_real_escape_string($connexion,$matiere);
		$note 		= htmlspecialchars($_POST["note"]);
		$note 		= mysqli_real_escape_string($connexion,$note);
		$coeff 		= htmlspecialchars($_POST["coeff"]);
		$coeff 		= mysqli_real_escape_string($connexion,$coeff);

		//Vérifie si un étudiant existe deja avec le meme nom et prenom
		$check_etu 		= "SELECT * FROM Etudiant WHERE nom = '$nom' AND prenom = '$prenom'";
		$check_res_etu 	= mysqli_query($connexion,$check_etu);
		$count_etu 		= mysqli_num_rows($check_res_etu);

		// si non on l'ajoute dans la bdd
		if ($count_etu == 0) {
			$req_etu = $connexion->prepare('INSERT INTO Etudiant (nom, prenom) VALUES(?, ?)');
			$req_etu->bind_param('ss', $nom, $prenom);
			$req_etu->execute();
			$req_etu->close();
		}

		//recupere l'id de l'etudiant concerné
		$req_id_etu = "SELECT * FROM Etudiant WHERE nom = '$nom' AND prenom = '$prenom'";
		$res_id_etu = mysqli_query($connexion,$req_id_etu);
		$val_id_etu = mysqli_fetch_assoc($res_id_etu);
		$fk_etu 	= $val_id_etu['id_etu'];

		//verifie si la matière entrer existe dans la bdd, si non on l'ajoute
		$check_mat 		= "SELECT * FROM Matiere WHERE nom = '$matiere'";
		$check_res_mat 	= mysqli_query($connexion, $check_mat);
		$count_mat 		= mysqli_num_rows($check_res_mat);

		//si non on l'ajoute dans la bdd
		if ($count_mat == 0) {
			$req_mat = $connexion->prepare('INSERT INTO Matiere (nom) VALUES (?)');
			$req_mat->bind_param('s', $matiere);
			$req_mat->execute();
			$req_mat->close();
		}

		//recupere l'id de la matière concerné
		$req_id_mat = "SELECT * FROM Matiere WHERE nom = '$matiere'";
		$res_id_mat = mysqli_query($connexion,$req_id_mat);
		$val_id_mat = mysqli_fetch_assoc($res_id_mat);
		$fk_mat 	= $val_id_mat['id_mat'];	

		//verifie si l'etudiant a deja une note pour la matière selectionné
		$check_note 	= "SELECT * FROM Note WHERE etu_id = '$fk_etu' AND mat_id = '$fk_mat'";
		$check_res_note = mysqli_query($connexion,$check_note);
		$count_note 	= mysqli_num_rows($check_res_note);

		//si non on ajoute la note dans la bdd
		if ($count_note == 0) {
			$req_note = $connexion->prepare('INSERT INTO Note (valeur, coefficient, etu_id, mat_id) VALUES (?,?,?,?)');
			$req_note->bind_param('diii', $note, $coeff, $fk_etu, $fk_mat);
			$req_note->execute();
			$req_note->close();
		//si oui on mets a jour la note stocké dans la bdd
		}else{
			$req_upd_note = $connexion->prepare("UPDATE Note SET valeur =?, coefficient =? WHERE etu_id = '$fk_etu' AND mat_id = '$fk_mat'");
			$req_upd_note->bind_param('ii', $note, $coeff);
			$req_upd_note->execute();
			$req_upd_note->close();
		}
	?>
	<h1>Moyenne des etudiant</h1>
	<table border="1">
		<thead>
			<tr>
				<th>nom</th>
				<th>prenom</th>
				<th>Moyenne General</th>
			</tr>
		</thead>
		<tbody>
			<?php
				//verifie le nombre d'etudiant present dans la bdd pour la boucle d'affichage
				$nbr_etu 		= "SELECT * FROM Etudiant";
				$check_nbr_etu 	= mysqli_query($connexion,$nbr_etu);
				$count_etu 		= mysqli_num_rows($check_nbr_etu);
			
				for ($i = 1; $i <= $count_etu; $i++) {
					//selection des element neccesaire a l'affichage
					$sql = "SELECT  nom,prenom,id_etu,ROUND(SUM(valeur * coefficient),1) AS res,SUM(coefficient) as d FROM Etudiant,Note WHERE etu_id = id_etu AND id_etu = $i ORDER BY res ASC";
					$res = mysqli_query($connexion,$sql);
					$sum = 0;
					while($rowitem = mysqli_fetch_array($res)) {
						echo "<tr>";
						//somme du numerateur pour le calcul de la moyenne
						$sum += $rowitem['res'];

						//division par le denominateur calculer dans la requete sql
						$sum /= $rowitem['d'];
						
						echo "<td>" . $rowitem['nom'] . "</td>";
						echo "<td>" . $rowitem['prenom'] . "</td>";
						echo "<td>" . $sum . "</td>";
						echo "</tr>";
					}
				}
			?>
		</tbody>
	</table>
</body>
</html>