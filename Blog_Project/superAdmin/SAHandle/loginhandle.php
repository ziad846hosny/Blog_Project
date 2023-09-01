<?php

require_once '../../inc/connection.php';


if(isset($_POST['submit'])){

    // catch the data

    $email = trim(htmlspecialchars($_POST['email']));
    $password = trim(htmlspecialchars($_POST['password']));
    $errors = [];


    //validation()

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


    //checking...

    if(empty($errors)){

        $query = "select * from users where email = '$email'";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) == 1){

            $user = mysqli_fetch_assoc($result);
            $oldPass = $user['password'];
            $name = $user['name'];
            $id = $user['id'];

            $verify = password_verify($password, $oldPass);

            if($verify){

                $_SESSION['user_id'] = $id;
                $_SESSION['successes'] = "logged in successfully";

                header("location:../../index.php");

            }else{

                $_SESSION['errors'] = ["user does not exist"];
                header("location:../login.php");

            }

        }else{

            $_SESSION['errors'] = ["user does not exist"];
            header("location:../login.php");

        }

    }else{
        $_SESSION['errors'] = $errors;
        header("location:../login.php");
    }

}else{
    header("location:../login.php");
}