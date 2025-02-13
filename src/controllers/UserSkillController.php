<?php
class UserSkillController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter une compétence à un utilisateur avec un niveau
    public function assignSkillToUser($userId, $skillId, $level) {
        $sql = 'INSERT INTO user_skills (user_id, skill_id, level)
                VALUES (:user_id, :skill_id, :level)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'skill_id' => $skillId, 'level' => $level]);
        return $stmt->rowCount(); // 1 si l'insertion réussit
    }

    // Modifier le niveau d'une compétence associée à un utilisateur
    public function updateUserSkill($userId, $skillId, $level) {
        $sql = 'UPDATE user_skills SET level = :level WHERE user_id = :user_id AND skill_id = :skill_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId, 'skill_id' => $skillId, 'level' => $level]);
        return $stmt->rowCount(); // 1 si la mise à jour réussit
    }

    // Lister toutes les compétences d'un utilisateur
    public function getUserSkills($userId) {
        $sql = 'SELECT us.skill_id AS id, s.name, us.level
               FROM user_skills us
               JOIN skills s ON us.skill_id = s.id
               WHERE us.user_id = :user_id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retourne un tableau associatif contenant 'id'
    }

    public function removeUserSkill($userId, $skillId) {
        $sql = 'DELETE FROM user_skills WHERE user_id = :user_id AND skill_id = :skill_id';
        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            'user_id' => $userId,
            'skill_id' => $skillId
        ]);

        return $stmt->rowCount(); // Retourne 1 si la suppression a fonctionné
    }


}