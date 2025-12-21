<?php

<<<<<<< HEAD
class QuestionModel
{
    private $db;          // Instance Database
    private $conn;        // PDO connection
    protected $table = "questions";

    public function __construct()
    {
        // Lấy instance duy nhất của Database
        $this->db = Database::getInstance();
        
        // Lấy PDO connection
        $this->conn = $this->db->getConnection();
    }

    /**
     * Lấy danh sách tất cả câu hỏi
     * @return array
     */
    public function getAllQuestions()
    {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function insertQuestion($content, $level)
{
        $sql = "INSERT INTO {$this->table} (content, level) VALUES (:content, :level)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":level", $level);
        return $stmt->execute();
}
    public function getQuestionById($id)
{
        $sql = "SELECT * FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch();
}

    public function updateQuestion($id, $content, $level)
{
        $sql = "UPDATE {$this->table} SET content = :content, level = :level WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":content", $content);
        $stmt->bindParam(":level", $level);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
}
    public function deleteQuestion($id)
{
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
}

}
=======
class QuestionModel {

    public function getAll() {
        if (!isset($_SESSION['questions'])) {
            $_SESSION['questions'] = [];
        }
        return $_SESSION['questions'];
    }

    public function add($content) {
        if (!isset($_SESSION['questions'])) {
            $_SESSION['questions'] = [];
        }
        $_SESSION['questions'][] = [
            'content' => $content
        ];
    }
}
>>>>>>> develop
