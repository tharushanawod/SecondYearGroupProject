<?php

class Worker {
  
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getWorkers(){
        $this->db->query('SELECT * FROM workers');
        return $this->db->resultSet();
    }

    public function getWorker($id){
        $this->db->query('SELECT * FROM workers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addWorker($data){
        $this->db->query('INSERT INTO workers (name, email, password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();
    }

    public function updateWorker($data){
        $this->db->query('UPDATE workers SET name = :name, email = :email, password = :password WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();
    }

    public function deleteWorker($id){
        $this->db->query('DELETE FROM workers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}








