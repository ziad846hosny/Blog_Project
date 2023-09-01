<?php

require_once '../inc/connection.php';


if(isset($_POST['submit']) && isset($_SESSION['user_id'])){
    

    $title = trim(htmlspecialchars($_POST['title']));
    $body = trim(htmlspecialchars($_POST['body']));
    $errors = [];


    if(empty($title)){
        $errors[] = "title is required";
    }elseif(is_numeric($title)){
        $errors[] = "title must be a string";
    }

    if(empty($body)){
        $errors[] = "body is required";
    }elseif(is_numeric($body)){
        $errors[] = "body must be a string";
    }

    if(isset($_FILES['image']) && $_FILES['image']['name']){
        $image = $_FILES['image'];
        $image_name = $image['name'];
        $image_tmpname = $image['tmp_name'];
        $ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));
        $image_error = $image['error'];
        $image_size = $image['size']/(1024*1024);
        $arr = ["jpg", "jpeg", "png"];

        if($image_error != 0){
            $errors[] = "image is not correct";
        }elseif($image_size > 1){
            $errors[] = "image is too large";
        }elseif(!in_array($ext, $arr)){
            $errors[] = "this extension is not supported";
        }

        $newName = uniqid().".".$ext;
        
    }else{
        $newName = null;
    }

    if(empty($errors)){
        $id = $_SESSION['user_id'];
        $query = "insert into posts(`title`, `body`, `image`, `user_id`) values('$title', '$body', '$newName','$id' )";
        $result = mysqli_query($conn, $query);

        if($result){
            
            if(isset($_FILES['image']) && $_FILES['image']['name']){
                move_uploaded_file($image_tmpname,"../assets/images/postImage/$newName");
            }

            $_SESSION['successes'] = "post added successfully";
            header("location:../addPost.php");     
        }else{
            $_SESSION['errors'] = ["error while adding your post"];
            header("location:../addPost.php");     

        }   
    }else{
        $_SESSION['errors'] = $errors;
        header("location:../addPost.php");     
    }


}else{
    header("../addPost.php");
}