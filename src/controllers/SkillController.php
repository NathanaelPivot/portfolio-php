<?php
class SkillController {
private $pdo;

public function __construct($pdo) {
$this->pdo = $pdo;
}

// Ajouter une compétence
public function addSkill($name, $description = null) {
$sql = 'INSERT INTO skills (name, description) VALUES (:name, :description)';
$stmt = $this->pdo->prepare($sql);
$stmt->execute(['name' => $name, 'description' => $description]);
return $stmt->rowCount(); // Retourne 1 si l'ajout réussit
}

// Modifier une compétence
public function updateSkill($id, $name, $description = null) {
$sql = 'UPDATE skills SET name = :name, description = :description WHERE id = :id';
$stmt = $this->pdo->prepare($sql);
$stmt->execute(['id' => $id, 'name' => $name, 'description' => $description]);
return $stmt->rowCount(); // 1 si la modification réussit
}

// Supprimer une compétence
public function deleteSkill($id) {
$sql = 'DELETE FROM skills WHERE id = :id';
$stmt = $this->pdo->prepare($sql);
$stmt->execute(['id' => $id]);
return $stmt->rowCount(); // 1 si la suppression réussit
}

// Récupérer toutes les compétences (liste)
    public function getSkills()
    {
        $stmt = $this->pdo->prepare("SELECT id, name, description FROM skills");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>

