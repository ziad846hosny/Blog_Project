<?php require_once 'inc/header.php' ;
require_once 'inc/connection.php';



if(isset($_GET['id'])){
  $id = $_GET['id'];
}else{
  header("location:index.php");
}

$query = "select * from posts where id = $id";
$result = mysqli_query($conn, $query);
if(mysqli_num_rows($result) == 1){
$post = mysqli_fetch_assoc($result);
}
?>

    <!-- Page Content -->
    <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>new Post</h4>
              <h2>add new personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="best-features about-features">
      <div class="container">
      <?php
 require_once 'inc/success.php';
 require_once 'inc/errors.php';
 ?>
        <div class="row">
          <div class="col-md-12">
            <div class="section-heading">
              <h2>Our Background</h2>
            </div>
          </div>

          <div class="col-md-6">
            <div class="right-image">
              <img src="assets/images/postImage/<?php echo $post['image'] ?>" alt="">
            </div>
          </div>
          <div class="col-md-6">
            <div class="left-content">
              <h4>Who we are &amp; What we do?</h4>
              <p><?php echo $post['body']?></p>
              <p><?php echo $post['created_at']?></p>
              <div class="d-flex justify-content-center">
                <?php if(isset($_SESSION['user_id'])){ ?>
                  <a href="editPost.php?id=<?php echo $id ?>" class="btn btn-success mr-3 "> edit post</a>
              
                  <a href="handle/deletePost.php?id=<?php echo $id ?>" onclick = "alert('are u sure ?')" class="btn btn-danger "> delete post</a>
              <?php } ?>
                </div>
            </div>
          </div>
        </div>
      </div>
</div>

    <?php require_once 'inc/footer.php';
   
    ?>