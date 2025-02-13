<?php
class ProjectController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour afficher la page d'ajout de projet
    public static function addProjectPage() {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(403);
            echo '403 - Accès interdit. Veuillez vous connecter.';
            exit();
        }

        // Afficher le formulaire d'ajout
        $title = "Ajouter un projet";
        require_once '../src/views/projects/add.php';
    }

    // Ajouter un projet en base de données
    public function addProject($userId, $title, $description, $imagePath, $link) {
        $sql = 'INSERT INTO projects (user_id, title, description, image_path, link)
                VALUES (:user_id, :title, :description, :image_path, :link)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description,
            'image_path' => $imagePath,
            'link' => $link
        ]);
        return $stmt->rowCount();
    }

    // Récupérer les projets (optionnel pour plus tard)
    public function getProjects($userId = null) {
        try {
            if ($userId) {
                // Récupérer uniquement les projets de l'utilisateur connecté
                $sql = 'SELECT * FROM projects WHERE user_id = :user_id';
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['user_id' => $userId]);
            } else {
                // Récupérer tous les projets
                $sql = 'SELECT * FROM projects';
                $stmt = $this->pdo->query($sql); // Pas besoin de paramètres
            }

            return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau associatif contenant les projets
        } catch (PDOException $e) {
            error_log("Erreur lors de la récupération des projets : " . $e->getMessage());
            return [];
        }
    }
}