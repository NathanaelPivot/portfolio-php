<?php
// Fichier : src/views/projects/add.php

require_once __DIR__ . '/../shared/header.php'; // Inclure le header

?>

    <h1>Ajouter un Projet</h1>
    <form method="POST" action="/projects/add">
        <label for="title">Titre du projet :</label><br>
        <input type="text" name="title" id="title" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" rows="4" required></textarea><br><br>

        <label for="image_path">Image (URL) :</label><br>
        <input type="text" name="image_path" id="image_path" required><br><br>

        <label for="link">Lien :</label><br>
        <input type="url" name="link" id="link" required><br><br>

        <button type="submit">Ajouter</button>
    </form>

<?php
require_once __DIR__ . '/../shared/footer.php'; // Inclure le footer
?>