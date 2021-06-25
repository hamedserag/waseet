<?php
session_start();
include('includes/config.php');
$_SESSION['catid'] = 0;
//increment visitors
//number of fake visits
$fakeVisitsCeil = 3;
//visitor counter
$query = mysqli_query($con, "SELECT secCounter FROM visitorcounter WHERE id=1");
$result = mysqli_fetch_array($query);
$secCounter = (int)$result['secCounter'];
if ($secCounter >= $fakeVisitsCeil) {
  mysqli_query($con, "UPDATE visitorcounter SET secCounter=0");
  mysqli_query($con, "UPDATE visitorcounter SET counter = counter+1");
} else {
  $secCounter++;
  mysqli_query($con, "UPDATE visitorcounter SET secCounter='" . $secCounter . "'");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>El Waseet | Home Page</title>

  <!-- Bootstrap core CSS -->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/modern-business.css" rel="stylesheet">
  <link href="css/home.css" rel="stylesheet">
  <link href="css/global.css" rel="stylesheet">
  <?php include('includes/links.php'); ?>

</head>

<body>
  <!-- Navigation -->
  <?php include('includes/header.php'); ?>

  <!-- Page Content -->
  <div class="container">

    <!--<img class="bgImg" src="images/bg4.jpg" style="width:100vw;position:fixed;height:100vh;top:0;left:0;filter: grayscale(100%);">-->

    <div class="row justify-content-around">

      <!-- Blog Entries Column -->
      <div class="col-md-9 col-sm-12 mt-5">

        <!-- Blog Post -->
        <div class="container-fluid">
          <!-- wide banner top -->
          <div class="row mb-5">
            <img class="wideBanner col-12" src="images/media/bannerWide.jpg" alt="">
          </div>

          <div class="row">
            <!-- element -->
            <?php
            if (isset($_GET['pageno'])) {
              $pageno = $_GET['pageno'];
            } else {
              $pageno = 1;
            }
            $no_of_records_per_page = 15;
            $offset = ($pageno - 1) * $no_of_records_per_page;


            $total_pages_sql = "SELECT COUNT(*) FROM tblposts";
            $result = mysqli_query($con, $total_pages_sql);
            $total_rows = mysqli_fetch_array($result)[0];
            $total_pages = ceil($total_rows / $no_of_records_per_page);



            $query = mysqli_query($con, "select tblposts.id as pid,tblposts.SubCategoryId as scid,tblposts.PostTitle as posttitle,tblposts.PostImage,tblcategory.CategoryName as category,tblcategory.id as cid,tblsubcategory.Subcategory as subcategory,tblposts.PostDetails as postdetails,tblposts.PostingDate as postingdate,tblposts.PostUrl as url from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId where tblposts.Is_Active=1 order by tblposts.id desc  LIMIT $offset, $no_of_records_per_page ");
            while ($row = mysqli_fetch_array($query)) {
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
          <!-- wide banner bottom -->
          <div class="row mt-5">
            <img class="wideBanner col-12" src="images/media/bannerWide.jpg" alt="">
          </div>
        </div>

      </div>

      <!-- Sidebar Widgets Column -->
      <?php include('includes/sidebar.php'); ?>
    </div>
    <!-- /.row -->

    <!-- Pagination -->
    <div class="row justify-content-center">
      <ul class="pagination justify-content-center mb-4">


        <!-- prev -->

        <li class=" paginationBtn
        <?php if ($pageno <= 1) {
          echo 'disabled';
        } ?> page-item">
          <a href="
          <?php if ($pageno <= 1) {
            echo '#';
          } else {
            echo "?pageno=" . ($pageno - 1);
          } ?>" class="page-link">
            <svg class="prevBtn" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#2c2c2c">
              <g>
                <path d="M0,0h24v24H0V0z" fill="none" />
              </g>
              <g>
                <polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12" />
              </g>
            </svg>
          </a>
        </li>

        <!-- pageno -->
        <li class="pages">
          <p>
            <span class="pageno">
              <?php echo htmlentities($pageno) ?>
            </span>
            <span class="pagetotal">
              <span class="barrier"> of </span> <?php echo htmlentities($total_pages) ?>
            </span>
          </p>

        </li>

        <!-- next -->

        <li class=" paginationBtn
        <?php if ($pageno >= $total_pages) {
          echo 'disabled';
        } ?> page-item">
          <a href="
          <?php if ($pageno >= $total_pages) {
            echo '#';
          } else {
            echo "?pageno=" . ($pageno + 1);
          } ?> " class="page-link">
            <svg class="nextBtn" xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" height="24px" viewBox="0 0 24 24" width="24px" fill="#2c2c2c">
              <g>
                <path d="M0,0h24v24H0V0z" fill="none" />
              </g>
              <g>
                <polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12" />
              </g>
            </svg> </a>
        </li>

      </ul>
    </div>

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