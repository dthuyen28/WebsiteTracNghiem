<?php

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
}

