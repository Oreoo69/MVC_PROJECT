<?php
class Students {
    //we'll use this to work with student data
    private $studentModel;

    //when we start up, get ready to handle student stuff
    public function __construct() {
        $this->studentModel = new Student;
    }

    //this shows the main dashboard page
    public function index() {
        $students = $this->studentModel->getStudents();
        require_once __DIR__ . '/../views/dashboard.php';
    }

    //this handles adding new students
    public function add() {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //if form was submitted, get the data
            $data = [
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email'])
            ];

            //try to add the student and go back to dashboard
            if($this->studentModel->addStudent($data)) {
                header('location: index.php?page=dashboard');
            }
        } else {
            //if not submitted, show the add form
            require_once __DIR__ . '/../views/add_student.php';
        }
    }

    //this handles editing students
    public function edit($id = null) {
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            //if form was submitted, get the data
            $data = [
                'id' => $_POST['id'],
                'first_name' => trim($_POST['first_name']),
                'last_name' => trim($_POST['last_name']),
                'email' => trim($_POST['email'])
            ];

            //try to update the student and go back to dashboard
            if($this->studentModel->updateStudent($data)) {
                header('location: index.php?page=dashboard');
            }
        } else {
            //if not submitted, show the edit form
            $student = $this->studentModel->getStudentById($id);
            require_once __DIR__ . '/../views/edit_student.php';
        }
    }

    //this handles deleting students
    public function delete($id) {
        if($this->studentModel->deleteStudent($id)) {
            header('location: index.php?page=dashboard');
        }
    }
}
?>