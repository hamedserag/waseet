<link rel="stylesheet" href="css/sidebar.css">
<div class="col-md-3 mt-5 sideBar">

  <!--drop down-->
  <div class="dropdown dropdownSideBar mb-2" id="subcatcontainer">
    <!-- query to get elements -->
    <?php
    $query = mysqli_query($con, "SELECT Subcategory,SubCategoryId FROM tblsubcategory WHERE CategoryId='" . $_SESSION['catid'] . "'");
    ?>
    <!-- drop down button -->
    <button class="btn" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      <?php $firstRow = mysqli_fetch_array($query);
      echo htmlentities($firstRow['Subcategory']) ?>
    </button>
    <!-- drop down items -->
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="subcatmenu">
      <?php
      $rowcount = mysqli_num_rows($query);
      while ($row = mysqli_fetch_array($query)) { ?>
        <a class="dropdown-item subcategoryElement" href="sub-category.php?catid=<?php echo htmlentities($row['SubCategoryId']) ?>" ; ?><?php echo htmlentities($row['Subcategory']); ?> </a>
      <?php } ?>
    </div>
  </div>

  <script>
    var subcatmenu = document.querySelectorAll(".subcategoryElement");
    if (subcatmenu.length == 0) {
      document.getElementById("subcatcontainer").style.display = "none";
    }
  </script>
  <!--end drop down-->



  <!-- Search Widget -->
  <div class="container search">
    <div class="row justify-content-center">
      <form name="search" action="search.php" method="post">
        <div class="input-group">
          <input type="text" name="searchtitle" class="form-control" required>
          <span class="input-group-btn">
            <button class="btn btn-secondary" type="submit">ابحث</button>
          </span>
        </div>
      </form>
    </div>
  </div>
  <!--end of Search Widget -->

  <!-- new news Widget -->
  <div class="container mt-4 newNews">
    <div class="row pr-3 pt-2 justify-content-end">
      <p class="headerNN"> اخر الاخبار </p>
    </div>
    <div class="row newNewsContent justify-content-end pr-4 pl-4">
      <?php
      $query = mysqli_query($con, "select tblposts.id as pid,tblposts.PostTitle as posttitle from tblposts left join tblcategory on tblcategory.id=tblposts.CategoryId left join  tblsubcategory on  tblsubcategory.SubCategoryId=tblposts.SubCategoryId limit 8");
      while ($row = mysqli_fetch_array($query)) {
      ?>
        <a class="col-12" href="news-details.php?nid=<?php echo htmlentities($row['pid']) ?>"><?php echo htmlentities($row['posttitle']); ?></a>
      <?php } ?>
    </div>
  </div>
  <!--most commented-->
  <div class="container mt-4 newNews">
    <div class="row pr-3 pt-2 justify-content-end">
      <p class="headerNN"> الاكثر تعليقا </p>
    </div>
    <div class="row newNewsContent justify-content-end pr-4 pl-4">
      <?php
      $postCountMC = 7;
      $posts = 0;
      $query = mysqli_query($con, "SELECT postId , COUNT('postId') AS value_occurrence FROM tblcomments GROUP BY postId ORDER BY value_occurrence DESC LIMIT " . $postCountMC);
      while ($row = mysqli_fetch_array($query)) {
        $titleQuery = mysqli_query($con, "SELECT PostTitle FROM tblposts WHERE id=" . $row['postId']);
        $titleRes = mysqli_fetch_array($titleQuery);
        showLinks($row['postId'], $titleRes['PostTitle']);
        if($posts >= $postCountMC){
          break;
        }
        $posts++;
      }
      ?>
    </div>
  </div>

  <!--most read-->
  <div class="container mt-4 newNews">
    <div class="row pr-3 pt-2 justify-content-end">
      <p class="headerNN"> الاكثر قراءه </p>
    </div>
    <div class="row newNewsContent justify-content-end pr-4 pl-4">
      <?php
      $postCountMC = 7;
      $query = mysqli_query($con, "SELECT `id`,`PostTitle`,`count` FROM `tblposts` ORDER BY count DESC");
      for ($i = 0; $i < $postCountMC; $i++) {
        $row = mysqli_fetch_array($query);
        if($row['PostTitle'] != ""){
          showLinks($row['id'], $row['PostTitle']);
        }
        
      }
      ?>
    </div>
  </div>
  <?php

  //show links function
  function showLinks($id, $title)
  {
  ?>
    <a class="col-12" href="news-details.php?nid=<?php echo htmlentities($id) ?>"><?php echo htmlentities($title); ?></a>
  <?php
  }
  ?>
  <!-- services Widget -->
  <div class="container mt-4 services">
    <div class="row pr-3 pt-2 justify-content-end">
      <p class="headerService"> وسائط الوسيط </p>
    </div>
    <div class="row servicesContent justify-content-end pr-4 pl-4">
      <a class="col-12" href="#">صور</a>
      <a class="col-12" href="#">فيديوهات</a>
      <a class="col-12" href="#">راديو</a>
      <a class="col-12" href="#">تلفزيون</a>
      <a class="col-12" href="#">الأخبار العاجلة</a>
      <a class="col-12" href="#">النشرة البريدية</a>
      <a class="col-12" href="#">اشترك فى خدمة الأخبار العاجلة</a>
    </div>
    <div class="row pr-3 pt-2 justify-content-end">
      <p class="headerService"> خدمات الوسيط </p>
    </div>
    <div class="row servicesContent justify-content-end pr-4 pl-4">
      <a class="col-12" href="adhan.php">مواقيت الصلاه</a>
      <a class="col-12" href="weather.php?cityId=0">درجات الحراره</a>
      <a class="col-12" href="exchangeRates.php?curId=43">اسعار العملات</a>
      <a class="col-12" href="goldRate.php">اسعار الذهب</a>
    </div>
  </div>
  <!--end of Side Widget -->
  <!--ad-->
  <div class="container mt-4 ad">
    
  </div>
</div>