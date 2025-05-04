<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "musique";

// Connexion à la base de données
$con = new mysqli($host, $user, $password, $dbname);

if ($con->connect_error) {
    die("Connexion échouée : " . $con->connect_error);
} else {
    echo "Connexion réussie<br>";
}

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $dedicace = mysqli_real_escape_string($con, $_POST['messages']);


    // Gestion de l'image
    $imageName = $_FILES['images']['name'];
    $imageTmp = $_FILES['images']['tmp_name'];
    $uploadPath = "uploads/" . basename($imageName);
    move_uploaded_file($imageTmp, $uploadPath);

    // Gestion de l'audio
    $nom_audio = $_FILES['audio']['name'];
    $audioTmp = $_FILES['audio']['tmp_name'];
    $uploadAudioPath = "uploads/" . basename($nom_audio); // Crée un dossier "audios/" pour stocker
    move_uploaded_file($audioTmp, $uploadAudioPath);

    // Insertion dans la base de données
    $sql = "INSERT INTO mus (nom, images, audio, messages) VALUES ('$nom', '$imageName', '$nom_audio', '$dedicace')";

    if ($con->query($sql) === TRUE) {
        // 🔥 REDIRECTION VERS LA PAGE AFFICHAGE
        header("Location: affiche.php");
        exit(); // Toujours exit() après header
    } else {
        echo "Erreur : " . $sql . "<br>" . $con->error;
    }

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Musique</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Envoyer une musique avec dédicace</h1>

    <form method="post" enctype="multipart/form-data">
        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" placeholder="Ex : Aryus" required>
        </div>

        <div>
            <label for="images">Image :</label>
            <input type="file" name="images" id="images" accept="image/*" required>
        </div>

        <div>
            <label for="audio">Audio :</label>
            <input type="file" name="audio" id="audio" accept="audio/*" required>
        </div>

        <div>
            <label for="messages">Dédicace :</label>
            <textarea name="messages" id="messages" rows="5" cols="30" placeholder="Votre message..."></textarea>
        </div>

        <button type="submit" name="Envoyez">Envoyer</button>
    </form>


    <script>
// Générer des étoiles scintillantes
for (let i = 0; i < 80; i++) {
    const star = document.createElement('div');
    star.classList.add('star');
    star.style.top = Math.random() * 100 + '%';
    star.style.left = Math.random() * 100 + '%';
    star.style.animationDelay = Math.random() * 5 + 's';
    document.body.appendChild(star);
}

// Générer des cœurs flottants
for (let i = 0; i < 20; i++) {
    const heart = document.createElement('div');
    heart.classList.add('heart');
    heart.style.left = Math.random() * 100 + '%';
    heart.style.bottom = '-' + (Math.random() * 100) + 'px';
    heart.style.animationDuration = (8 + Math.random() * 8) + 's';
    document.body.appendChild(heart);
}
</script>


</body>
</html>
