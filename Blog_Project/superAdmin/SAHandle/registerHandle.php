<?php

require_once '../../inc/connection.php';

if(isset($_POST['submit'])){

    // catch the data

    $name = trim(htmlspecialchars($_POST['name']));
    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $phone = trim(htmlspecialchars($_POST['phone']));
    $errors = [];


    // validation()

    if(empty($name)){
        $errors[] = "name is required";
    }elseif(strlen($name) > 100){
        $errors[] = "name is too large";
    }elseif(is_numeric($name)){
        $errors = "name must be text not numbers";
    }

    if(empty($email)){
        $errors[] = "email is required";
    }elseif(!(filter_var($email, FILTER_VALIDATE_EMAIL))){
        $errors[] = "enter a valid email";
    }elseif(strlen($email) > 100){
        $errors[] = "email is too large";
    }

    if(empty($password)){
        $errors[] = "password is required";
    }elseif(! (is_string($password))){
        $errors[] = "enter a correct password";
    }elseif(strlen($password) < 6){
        $errors[] = "password is too short";
    }

    if(empty($phone)){
        $errors[] = "phone number is required";
    }elseif(! strlen($phone) == 11){
        $errors[] = "enter a valid phone number";
    }


    // hashing the password

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    // inserting the user

    if(empty($errors)){

        $query = "insert into users(`name`, `email`, `password`, `phone`) values('$name', '$email', '$hashedPassword', '$phone')";
        $result = mysqli_query($conn, $query);

        if($result){
            $_SESSION['successes'] = "registered successfully";
            header("location:../login.php"); 
        }else{
            $_SESSION['errors'] = ["error while registering"];
            header("location:../register.php");
        }

    }else{
        $_SESSION['errors'] = $errors;
        header("location:../register.php");
    }


}else{
    header("location:../register.php");
}