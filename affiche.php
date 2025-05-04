<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "musique";

$con = new mysqli($host, $user, $password, $dbname);

if ($con->connect_error) {
    die("Connexion échouée : " . $con->connect_error);
}

$sql = "SELECT * FROM mus ORDER BY id DESC";
$result = $con->query($sql);

$musics = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $musics[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galerie Audio Stylée</title>
    <link rel="stylesheet" href="stylee.css">
</head>
<body>

<div class="container">

    <div class="audio-list">
        <h2>🎶 Choisis ton Audio</h2>

        <?php foreach ($musics as $index => $music): ?>
            <div class="audio-item" data-index="<?php echo $index; ?>">
                <?php echo htmlspecialchars($music['nom']); ?>
            </div>
        <?php endforeach; ?>

        <audio id="audioPlayer" controls style="width:100%; margin-top:20px;">
            <source src="" id="audioSource" type="audio/mpeg">
            Votre navigateur ne supporte pas l'audio.
        </audio>
    </div>

    <div class="display-area">
        <div class="image-area">
            <img id="currentImage" src="imaged/<?php echo htmlspecialchars($musics[0]['images']); ?>" alt="Image">
        </div>
        <div class="dedicace-area">
            <p id="currentDedicace"><?php echo nl2br(htmlspecialchars($musics[0]['messages'])); ?></p>
        </div>
    </div>

</div>

<script>
    const musics = <?php echo json_encode($musics); ?>;
    const audioItems = document.querySelectorAll('.audio-item');
    const audioPlayer = document.getElementById('audioPlayer');
    const audioSource = document.getElementById('audioSource');
    const currentImage = document.getElementById('currentImage');
    const currentDedicace = document.getElementById('currentDedicace');

    function selectAudio(index) {
        const music = musics[index];

        // Changer l'audio
        audioSource.src = "audios/" + music.audio;
        audioPlayer.load();
        audioPlayer.play();

        // Changer l'image
        currentImage.src = "imaged/" + music.images;

        // Changer la dédicace
        currentDedicace.innerHTML = music.messages.replace(/\n/g, "<br>");
    }

    audioItems.forEach(item => {
        item.addEventListener('click', function() {
            const index = this.getAttribute('data-index');
            selectAudio(index);
        });
    });

    // Charger premier par défaut
    window.onload = () => {
        selectAudio(0);
    };
</script>

<!-- Animation étoiles/bulles -->
<script>
// Générer des bulles animées
for (let i = 0; i < 30; i++) {
    let bubble = document.createElement('div');
    bubble.classList.add('bubble');
    bubble.style.width = bubble.style.height = Math.random() * 20 + 10 + 'px';
    bubble.style.left = Math.random() * 100 + '%';
    bubble.style.animationDuration = (Math.random() * 10 + 10) + 's';
    document.body.appendChild(bubble);
}

// Générer des étoiles fixes qui scintillent
for (let i = 0; i < 100; i++) {
    let star = document.createElement('div');
    star.classList.add('star');
    star.style.top = Math.random() * 100 + '%';
    star.style.left = Math.random() * 100 + '%';
    star.style.animationDelay = Math.random() * 5 + 's';
    document.body.appendChild(star);
}
</script>

</body>
</html>
