<?php
require_once '../inc/connection.php';

if(isset($_POST['submit']) && isset($_GET['id']) && isset($_SESSION['user_id'])){

    $id = $_GET['id'];
    $query = "select * from posts where id = $id ";
    $result = mysqli_query($conn , $query);

    if(mysqli_num_rows($result) == 1){    
        $post = mysqli_fetch_assoc($result);
        $title = trim(htmlspecialchars($_POST['title']));
        $body = trim(htmlspecialchars($_POST['body']));
        $oldImage = $post['image'];
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
            $newName = $oldImage;
        }

        if(empty($errors)){
            $query = "update posts set `title` ='$title', `body` = '$body', `image` = '$newName' where id = $id";
            $result = mysqli_query($conn, $query);

            if($result){
                
                if(isset($_FILES['image']) && $_FILES['image']['name']){
                    unlink("../assets/images/postImage/$oldImage");
                    move_uploaded_file($image_tmpname,"../assets/images/postImage/$newName");
                }

                $_SESSION['successes'] = "post updated successfully";
                header("location:../viewPost.php?id=$id");
            }else{
                $_SESSION['errors'] = ["problem while updating"];
                header("location:../editPost.php?id=$id");
            }
        }else{
            $_SESSION['errors'] = $errors;
            header("location:../editPost.php?id=$id");
        }

    }else{
      $_SESSION['errors'] = ["post not found"];
    }

    
}else{
    header("location:../index.php");
}