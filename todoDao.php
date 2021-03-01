<?php

require_once('bootstrap.php');
class TodoDao {
 
 // as duas linhas que carregam as variáveis do .env para variáveis de ambiente 
   
    private $host = 'localhost';
    private $user = 'pimatheus';
    private $pass = 'onclass';
    private $name = 'todo_teste';


    // private $host = $_ENV['DB_HOST'];
    // private $user = $_ENV['DB_USER'];
    // private $pass = $_ENV['DB_PASS'];
    // private $name = $_ENV['DB_NAME'];
    private $dbConn;
    public function __construct() {
        // echo  $_ENV['DB_HOST']."  ". $_ENV['DB_USER']."  " .$_ENV['DB_PASS'];
        try {
            $this->dbConn = new PDO("pgsql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}", $_ENV['DB_USER'], $_ENV['DB_PASS']);
            $this->dbConn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $err) {
            echo "Error ". $err; 
        }
    }

    function findAll() {
        $stmt = $this->dbConn->prepare("SELECT * FROM todo");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    function find($id) {
        $stmt = $this->dbConn->prepare('SELECT * FROM todo WHERE id=:id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch();
    }
    function create($row) {
        $stmt = $this->dbConn->prepare('INSERT INTO todo (title, "description", priority) VALUES(:title, :desc, :priority)');
        $stmt->execute(array(
            ':title' => $row['title'],
            ':desc' => $row['description'],
            ':priority' => $row['priority']   
        ));
        return $this->dbConn->lastInsertId();

        echo $stmt->rowCount();
    }
    function delete($id) {
        $stmt = $this->dbConn->prepare('DELETE FROM todo WHERE id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        echo $stmt->rowCount();
    }
    function update($query) {
        $row = $this->find($row['id']);
        $stmt = $this->dbConn->prepare('UPDATE todo SET title=:title, description=:descr, priority=:priority WHERE id=:id');
        if(isset($row)) {
            $stmt->execute(array(
                ':id' => $query['id'],
                ':title' => $query['title'],
                ':descr' => $query['description'],
                ':priority' => $query['priority'],
            ));
            return 'nothing to update';
        }
    }
}
?>