<?php
require_once 'config/config.php';        //gets our database settings
require_once 'config/Database.php';      //gets our database connection code
require_once 'models/Student.php';       //gets our student-related functions
require_once 'controllers/Students.php';  //gets our student controller

//create a new Students controller to handle our requests
$students = new Students();

//check what page the user wants to see (if not specified, show dashboard)
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';
//get the student ID if it's provided in the URL
$id = isset($_GET['id']) ? $_GET['id'] : null;

//this decides what to do based on the page requested
switch($page) {
    case 'dashboard':
        $students->index();    //show the main page with all students
        break;
    case 'add':
        $students->add();      //show or handle the add student form
        break;
    case 'edit':
        $students->edit($id);  //show or handle the edit student form
        break;
    case 'delete':
        $students->delete($id); //delete a student
        break;
    default:
        $students->index();    //if page not found, show dashboard
        break;
}
?>