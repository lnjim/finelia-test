<?php  
$connexion = mysqli_connect("localhost","root","","test") or die("Connexion impossible.");
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Formulaire</title>
	<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>
<body>
	<h1>Formulaire Note:</h1>
	<form action="moyenne.php" method="POST">
		<div class="lname">
			<label for="lname">Nom de l'étudiant :</label>
			<input type="text" id="lname" name="lname" required>
		</div>
		<div class="fname">
			<label for="fname">Prénom de l'étudiant :</label>
			<input type="text" id="fname" name="fname" required>
		</div>
		<div class="matiere">
			<label for="matiere">Matière :</label>
			<input type="text" id="matiere" name="matiere" required>
		</div>
		<div class="note">
			<label for="note">Note :</label>
			<input type="text" id="note" name="note" required>
		</div>
		<div class="coeff">
			<label for="coeff">Coefficient de la note :</label>
			<input type="text" id="coeff" name="coeff" required>
		</div>
		<button type="submit">Valider la Note !</button>
	</form>

	<script>
		//Autorise que les nombres dans l'input note, nombre decimaux autorisé
		$('#note').keypress(function(event) {
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}
		});

		//Autorise que les nombres dans l'input coeff
		$("#coeff").keypress(function (e) {
     		if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        		return false;
    		}
		});
</script>
</body>
</html>