<?php require_once 'inc/header.php' ?>
 <!-- Page Content -->
 <div class="page-heading products-heading header-text">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="text-content">
              <h4>Edit Post</h4>
              <h2>edit your personal post</h2>
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="container w-50 ">
<div class="d-flex justify-content-center">
    <h3 class="my-5">edit Post</h3>
  </div>



  <?php
  require_once 'inc/connection.php';
  require_once 'inc/errors.php';
  require_once 'inc/success.php';

  if(isset($_GET['id']) && isset($_SESSION['user_id'])){
    
    $id = $_GET['id'];
    $query = "select * from posts where id = $id";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){    
    $post = mysqli_fetch_assoc($result);
    }else{
      $msg = "post not found";
    }

  }else{
    header("location:index.php");
  }

  ?>


<?php if(! empty($post)){ ?>

    <form method="POST" action="handle/editHandle.php?id=<?php echo $id?>" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo $post['title'] ?>">
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">Body</label>
            <textarea class="form-control" id="body" name="body" rows="5"><?php echo $post['body'] ?></textarea>
        </div>
        <div class="mb-3">
            <label for="body" class="form-label">image</label>
            <input type="file" class="form-control-file" id="image" name="image">
            <img src="assets/images/postImage/<?php echo $post['image'] ?>" alt="" width="100px" srcset="">
        </div>
        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
    </form>

    <?php }else{
      echo $msg;
    }?>
</div>


<?php require_once 'inc/footer.php' ?>