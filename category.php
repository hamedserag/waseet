<?php
session_start();
error_reporting(0);
include('includes/config.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>الوسيط | القائمه</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">

  <?php include('includes/links.php'); ?>

</head>

<body>

  <!-- Navigation -->
  <?php include('includes/headerCategory.php'); ?>

  <!-- Page Content -->
  <div class="container">

    <div class="row justify-content-around" style="margin-top: 4%">

      <!-- Blog Entries Column -->
      <div class="col-md-9 col-sm-12 mt-4">

        <!-- Blog Post -->
        <div class="container-fluid">
          <!-- wide banner top -->
          <div class="row mb-5">
            <img class="wideBanner col-12" src="images/media/bannerWide.jpg" alt="">
          </div>
        
          <div class="row">
            <?php
            if ($_GET['catid'] != '') {
              $_SESSION['catid'] = intval($_GET['catid']);
            }

            if (isset($_GET['pageno'])) {
              $pageno = $_GET['pageno'];
            } else {
              $pageno = 1;
            }
            $no_of_records_per_page = 8;
            $offset = ($pageno - 1) * $no_of_records_per_page;

            $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
            $result = mysqli_query($con, $total_pages_sql);
            $total_rows = mysqli_fetch_array($result)[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);


            $query = mysqli_query($con, "select tblposts.id as pid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.CategoryId='" . $_SESSION['catid'] . "' and tblposts.Is_Active=1 order by tblposts.id desc LIMIT $offset, $no_of_records_per_page");

            $rowcount = mysqli_num_rows($query);
            if ($rowcount == 0) {
              echo "No record found";
            } else { ?>
              <div class="row">
                <?php
                while ($row = mysqli_fetch_array($query)) {
                  // posts
                ?>
                  <div class="col-lg-4 col-sm-12 mt-4 postContainer" style="text-align: right;">
                    <div class="post">
                      <img class="postImg" src="admin/postimages/<?php echo htmlentities($row['PostImage']); ?>" alt="<?php echo htmlentities($row['posttitle']); ?>">
                      <div class="contentContainer">
                        <div class="catContainer">
                          <p class="postCategory"><a href="category.php?catid=<?php echo htmlentities($row['cid']) ?>"><?php echo htmlentities($row['category']); ?></a> </p>
                          <p class="postSubCategory"><a href="sub-category.php?catid=<?php echo htmlentities($row['scid']) ?>"><?php echo htmlentities($row['subcategory']); ?></a> </p>
                        </div>
                        <p class="postDate"><?php echo htmlentities($row['postingdate']); ?></p>

                        <a href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>">
                          <p class="postTitle"> <?php echo htmlentities($row['posttitle']); ?></p>
                        </a>
                      </div>
                    </div>
                  </div>
                <?php } ?>
              </div>
            <?php } ?>
          </div>


          <!-- wide banner bottom -->
          <div class="row mt-5">
            <img class="wideBanner col-12" src="images/media/bannerWide.jpg" alt="">
          </div>
        </div>


        <!-- Pagination -->



      </div>

      <!-- Sidebar Widgets Column -->
      <?php include('includes/sidebar.php'); ?>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.container -->

  <!-- Footer -->
  <?php include('includes/footer.php'); ?>


  <!-- Bootstrap core JavaScript -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>


  </head>
</body>

</html>