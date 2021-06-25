<?php
session_start();
include('includes/config.php');
//Genrating CSRF Token
if (empty($_SESSION['token'])) {
  $_SESSION['token'] = bin2hex(random_bytes(32));
}

if (isset($_POST['submit'])) {
  //Verifying CSRF Token
  if (!empty($_POST['csrftoken'])) {
    if (hash_equals($_SESSION['token'], $_POST['csrftoken'])) {
      $name = preg_replace('~[\\\\/:*?"<>|]~', ' ', $_POST['name']);
      $email = preg_replace('~\\\\/:?"<>~', ' ', $_POST['email']);
      $comment = preg_replace('~[\\\\/:*?"<>|]~', ' ', $_POST['comment']);
      $postid = intval($_GET['nid']);

      $st1 = '0';
      $query = mysqli_query($con, "insert into tblcomments(postId,name,email,comment,status) values('$postid','$name','$email','$comment','$st1')");
      if ($query) :
        echo "<script>alert('comment successfully submit. Comment will be display after admin review ');</script>";
        unset($_SESSION['token']);
      else :
        echo "<script>alert('Something went wrong. Please try again.');</script>";

      endif;
    }
  }
}

$query = mysqli_query($con, "SELECT count FROM tblposts WHERE id=" . intval($_GET['nid']));
$result = mysqli_fetch_array($query);
mysqli_query($con, "UPDATE tblposts SET count = count+1 WHERE id=" . intval($_GET['nid']));
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>الوسيط | اقرا المزيد</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">
  <link href="css/news-detail.css" rel="stylesheet">
  <?php include('includes/links.php'); ?>
</head>

<body>

  <!-- Navigation -->
  <?php include('includes/header.php'); ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row justify-content-end">


      <!-- Blog Entries Column -->
      <div class="col-12 mb-3 pb-3" style="border-bottom: 1px solid #969696;">

        <!-- Blog Post -->
        <?php
        $pid = intval($_GET['nid']);
        $query = mysqli_query($con, "select tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.id='$pid'");
        while ($row = mysqli_fetch_array($query)) { ?>
          <div class="row justify-content-center">
            <div class="col-lg-12 col-sm-12">
              <img style="width: 100%;" class="img-fluid" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
            </div>
            <div class="col-lg-12 col-sm-12 mt-4">
              <h2 class="card-title"><?php echo htmlentities($row['posttitle']); ?></h2>
            </div>
            <div class="col-lg-12 col-sm-12 mb-4" style="border-bottom: 1px solid #969696;">
              <p>
                <!-- <b>القسم : </b>
                <a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>">
                  <?php echo htmlentities($row['category']); ?>
                </a> |
                <b>القسم الفرعي : </b>
                <?php echo htmlentities($row['subcategory']); ?> -->
                <b> رفع بتاريخ </b>
                <?php echo htmlentities($row['postingdate']); ?>
              </p>
            </div>
          </div>
          <div class="row">
            <div class="col-md-9 col-sm-12">
              <div>
                <?php
                $pt = $row['postdetails'];
                echo (substr($pt, 0));
                ?>
              </div>



              <!--Cmt Sect Short Post-->
              <?php if (strlen(substr($pt, 0)) < 5000) { ?>
                <div class="cmtSec">

                  <div class="row justify-content-center mt-4" style="margin-top: -8%">
                    <div class="col-12">
                      <h1> اترك تعليق</h1>
                    </div>
                    <div class="col-12">
                      <form name="Comment" method="post">
                        <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                        <div class="form-group">
                          <input type="text" name="name" class="form-control" placeholder="الاسم" required>
                        </div>
                        <div class="form-group">
                          <input type="email" name="email" class="form-control" placeholder="البريد الالكتروني" required>
                        </div>
                        <div class="form-group">
                          <textarea style="resize: none;" class="form-control" name="comment" rows="3" placeholder="التعليق" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary cmtBtn" name="submit">ادخال</button>
                      </form>
                    </div>


                    <div class="col-md-12 mt-5">
                      <!---Comment Display Section --->
                      <h1 class="mb-4">التعليقات</h1>
                      <?php
                      $sts = 1;
                      $query = mysqli_query($con, "select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
                      while ($row = mysqli_fetch_array($query)) {
                      ?>
                        <div class="media mb-4">

                          <div class="media-body">
                            <h5 class="mt-0">
                              <?php echo htmlentities($row['name']); ?> <br />
                              <!-- <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']); ?></span> -->
                            </h5>
                            <p><?php echo htmlentities($row['comment']); ?></p>
                          </div>
                          <svg height="50px" viewBox="0 0 24 24" width="50px" fill="#ef4343" class="mt-1">
                            <path d="M0 0h24v24H0V0z" fill="none" />
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z" />
                          </svg>
                        </div>

                      <?php } ?>
                    </div>
                  </div>
                  <!--end of cmt sec-->
                </div>
              <?php } ?>

            </div>
          <?php } ?>
          <style>
            .sideBar,
            .newNews {
              order: -1;
              margin-top: 0 !important;
            }

            .search,
            .dropdown {
              display: none;
            }
          </style>
          <?php include('includes/sidebar.php'); ?>
          </div>
      </div>

      <!--Cmt Sect long Post-->
      <?php if (strlen(substr($pt, 0)) > 5000) { ?>
        <div class="cmtSec">

          <div class="row justify-content-center mt-4" style="margin-top: -8%">
            <div class="col-12">
              <h1> اترك تعليق</h1>
            </div>
            <div class="col-md-11">
              <form name="Comment" method="post">
                <input type="hidden" name="csrftoken" value="<?php echo htmlentities($_SESSION['token']); ?>" />
                <div class="form-group">
                  <input type="text" name="name" class="form-control" placeholder="الاسم" required>
                </div>
                <div class="form-group">
                  <input type="email" name="email" class="form-control" placeholder="البريد الالكتروني" required>
                </div>
                <div class="form-group">
                  <textarea style="resize: none;" class="form-control" name="comment" rows="3" placeholder="التعليق" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary cmtBtn" name="submit">ادخال</button>
              </form>
            </div>


            <div class="col-md-12 mt-5">
              <!---Comment Display Section --->
              <h1 class="mb-4">التعليقات</h1>
              <?php
              $sts = 1;
              $query = mysqli_query($con, "select name,comment,postingDate from  tblcomments where postId='$pid' and status='$sts'");
              while ($row = mysqli_fetch_array($query)) {
              ?>
                <div class="media mb-4">

                  <div class="media-body">
                    <h5 class="mt-0">
                      <?php echo htmlentities($row['name']); ?> <br />
                      <!-- <span style="font-size:11px;"><b>at</b> <?php echo htmlentities($row['postingDate']); ?></span> -->
                    </h5>
                    <p><?php echo htmlentities($row['comment']); ?></p>
                  </div>
                  <svg height="50px" viewBox="0 0 24 24" width="50px" fill="#ef4343" class="mt-1">
                    <path d="M0 0h24v24H0V0z" fill="none" />
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zM7.07 18.28c.43-.9 3.05-1.78 4.93-1.78s4.51.88 4.93 1.78C15.57 19.36 13.86 20 12 20s-3.57-.64-4.93-1.72zm11.29-1.45c-1.43-1.74-4.9-2.33-6.36-2.33s-4.93.59-6.36 2.33C4.62 15.49 4 13.82 4 12c0-4.41 3.59-8 8-8s8 3.59 8 8c0 1.82-.62 3.49-1.64 4.83zM12 6c-1.94 0-3.5 1.56-3.5 3.5S10.06 13 12 13s3.5-1.56 3.5-3.5S13.94 6 12 6zm0 5c-.83 0-1.5-.67-1.5-1.5S11.17 8 12 8s1.5.67 1.5 1.5S12.83 11 12 11z" />
                  </svg>
                </div>

              <?php } ?>
            </div>
          </div>
          <!--end of cmt sec-->
        </div>
      <?php } ?>



    </div>
    <!-- /.row -->

  </div>


  <?php include('includes/footer.php'); ?>


  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>