<!--nav style-->

<!--nav-->
<link rel="stylesheet" href="css/nav.css">
<nav class="navbar fixed-top navbar-expand-lg bg-light navbar-light">
  <div class="container">
    <div class="row navRow">
      <a class="navbar-brand col-12" href="index.php"> الوسيط </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse col-12" id="navbarResponsive">
        <ul class="navbar-nav mr-auto row justify-content-center">
        <li class="categoryItem" > <a class="bn" href="index.php"> الرئيسية </a> </li>
          <?php $query = mysqli_query($con, "select id,CategoryName from tblcategory");
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <li class="categoryItem">
              <?php if ($_GET['catid'] != $row['id']) { ?>
                <a href="category.php?catid=<?php echo htmlentities($row['id']) ?>"><?php echo htmlentities($row['CategoryName']); ?></a>
              <?php } else { ?>
                <a class="active" href="category.php?catid=<?php echo htmlentities($row['id']) ?>"><?php echo htmlentities($row['CategoryName']); ?></a>
              <?php } ?>
            </li>
          <?php } ?>
          
        </ul>
      </div>
    </div>

  </div>
</nav>