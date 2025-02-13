<?php
class ProjectController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Méthode pour afficher la page d'ajout de projet
    public static function addProjectPage($pdo) {
        // Vérifie si l'utilisateur est connecté
        if (!isset($_SESSION['user']['id'])) {
            http_response_code(403);
            echo '403 - Accès interdit. Veuillez vous connecter.';
            exit();
        }

        // Affiche la page d'ajout
        $title = "Ajouter un projet";
        require '../src/views/projects/add.php';
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
            'image_path' => "/images/test.png",
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

    public function deleteProject($userId, $projectId) {
        try {
            $sql = 'DELETE FROM projects WHERE id = :project_id AND user_id = :user_id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['project_id' => $projectId, 'user_id' => $userId]);

            return $stmt->rowCount(); // Retourne 1 si un projet a été supprimé
        } catch (PDOException $e) {
            error_log("Erreur lors de la suppression du projet : " . $e->getMessage());
            return 0;
        }
    }
}