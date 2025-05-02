<?php
class Student {
    //we'll use this to talk to our database
    private $db;

    //when we create a new Student, connect to the database
    public function __construct() {
        $this->db = new Database;
    }

    //get all students from the database
    public function getStudents() {
        $this->db->query('SELECT * FROM students');
        return $this->db->resultSet();
    }

    //add a new student to the database
    public function addStudent($data) {
        //prepare our insert command
        $this->db->query('INSERT INTO students (first_name, last_name, email) VALUES(:first_name, :last_name, :email)');
        //safely add the student's info
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);

        //try to save and tell us if it worked
        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    //get a single student by their ID
    public function getStudentById($id) {
        $this->db->query('SELECT * FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    //update a student's information
    public function updateStudent($data) {
        //prepare our update command
        $this->db->query('UPDATE students SET first_name = :first_name, last_name = :last_name, email = :email WHERE id = :id');
        //safely update all the student's info
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':first_name', $data['first_name']);
        $this->db->bind(':last_name', $data['last_name']);
        $this->db->bind(':email', $data['email']);

        return $this->db->execute();
    }

    //delete a student from the database
    public function deleteStudent($id) {
        $this->db->query('DELETE FROM students WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
?>