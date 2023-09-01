<?php

require_once '../inc/connection.php';


if(isset($_GET['id']) && isset($_SESSION['user_id'])){
    
    $id = $_GET['id'];
    $query = "select * from posts where id = $id";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){    
        $post = mysqli_fetch_assoc($result);
        $oldImg = $post['image'];

        if(! empty($oldImg)){
            unlink("../assets/images/postImage/$oldImg");
        }

        $query = "delete from posts where id = $id";
        $result = mysqli_query($conn, $query);

        if($result){
            $_SESSION['successes'] = "Post deleted successfully";
            header("location:../index.php");
        }else{
            $_SESSION['errors'] = "Error while deleting post";
            header("location:../index.php");
        }



    }else{
      $msg = "post not found";
    }

  }else{
    header("location:../index.php");
  }