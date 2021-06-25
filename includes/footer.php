<link rel="stylesheet" href="css/footer.css">
<footer class="footerBg">
  <div class="container footerBg">
    <div class="row footerContent justify-content-start">
      <!-- about -->
      <div class="col-lg-3 col-sm-11">
        <h4 class="footerHeader" style="font-size: 1.3rem;">حمل تطبيق الوسيط الدولي</h4>
        <div class="row">
          <a class="col-6 footerCat" style="text-align: center;" href="#">Google Play</a>
          <a class="col-6 footerCat" style="text-align: center;" href="#">App Store</a>
        </div>
        <div class="mt-3">
          <h4 class="footerHeader d-inline" style="font-size: 1.3rem;">عدد الزوار</h4>
          <?php
          //show visitors
          $query = mysqli_query($con, "SELECT counter FROM visitorcounter WHERE id=1");
          $visitor = mysqli_fetch_array($query);
          echo ("<p class='px-3 d-inline counterNum' style='color:#fff'>" . $visitor['counter'] . "</p>");
          ?>
        </div>
      </div>
      <!-- contact -->
      <div class="col-lg-3 col-sm-11">
        <h4 class="footerHeader">اقسام الموقع</h4>
        <div class="row justify-content-end">
          <a class="col-6 footerCat" href="contact-us.php">اتصل بنا</a>
          <a class="col-6 footerCat" href="about-us.php">عن الجريده</a>
          <a class="col-6 footerCat" href="terms.php">شروط الاستخدام</a>
          <a class="col-6 footerCat" href="terms.php">سياسه الخصوصيه</a>
          <a class="col-6 footerCat" href="#">خدمه الرسائل</a>
        </div>
      </div>
      <!-- cats -->
      <div class="col-lg-3 col-sm-11 footerCatCont">
        <h4 class="footerHeader"> الاقسام الاخباريه</h4>
        <div class="row justify-content-end">
          <a class="col-6 footerCat " href="index.php"> الرئيسية </a>
          <?php $query = mysqli_query($con, "select id,CategoryName from tblcategory");
          while ($row = mysqli_fetch_array($query)) {
          ?>
            <a class="col-6 footerCat" href="category.php?catid=<?php echo htmlentities($row['id']) ?>"><?php echo htmlentities($row['CategoryName']); ?></a>
          <?php } ?>
        </div>
      </div>
      <!-- sm -->
      <div class="col-lg-3 col-sm-6 row justify-content-end">
        <div class="col-10 row justify-content-end">
          <a class="footer-brand" href="index.php"> الوسيط </a>
          <div class="row">
            <!-- fb -->
            <svg fill="#969696" class="footerIcon" id="Bold">
              <path d="m15.997 3.985h2.191v-3.816c-.378-.052-1.678-.169-3.192-.169-3.159 0-5.323 1.987-5.323 5.639v3.361h-3.486v4.266h3.486v10.734h4.274v-10.733h3.345l.531-4.266h-3.877v-2.939c.001-1.233.333-2.077 2.051-2.077z" />
            </svg>
            <!-- ig -->
            <svg fill="#969696" class="footerIcon" id="Bold">
              <path d="m12.004 5.838c-3.403 0-6.158 2.758-6.158 6.158 0 3.403 2.758 6.158 6.158 6.158 3.403 0 6.158-2.758 6.158-6.158 0-3.403-2.758-6.158-6.158-6.158zm0 10.155c-2.209 0-3.997-1.789-3.997-3.997s1.789-3.997 3.997-3.997 3.997 1.789 3.997 3.997c.001 2.208-1.788 3.997-3.997 3.997z" />
              <path d="m16.948.076c-2.208-.103-7.677-.098-9.887 0-1.942.091-3.655.56-5.036 1.941-2.308 2.308-2.013 5.418-2.013 9.979 0 4.668-.26 7.706 2.013 9.979 2.317 2.316 5.472 2.013 9.979 2.013 4.624 0 6.22.003 7.855-.63 2.223-.863 3.901-2.85 4.065-6.419.104-2.209.098-7.677 0-9.887-.198-4.213-2.459-6.768-6.976-6.976zm3.495 20.372c-1.513 1.513-3.612 1.378-8.468 1.378-5 0-7.005.074-8.468-1.393-1.685-1.677-1.38-4.37-1.38-8.453 0-5.525-.567-9.504 4.978-9.788 1.274-.045 1.649-.06 4.856-.06l.045.03c5.329 0 9.51-.558 9.761 4.986.057 1.265.07 1.645.07 4.847-.001 4.942.093 6.959-1.394 8.453z" />
              <circle cx="18.406" cy="5.595" r="1.439" />
            </svg>
            <!-- messenger -->
            <svg fill="#969696" class="footerIcon" id="Bold">
              <path d="m0 11.111c0 3.496 1.744 6.615 4.471 8.652v4.237l4.086-2.242c1.09.301 2.245.465 3.442.465 6.627 0 12-4.974 12-11.111.001-6.137-5.372-11.112-11.999-11.112s-12 4.974-12 11.111zm10.734-3.112 3.13 3.259 5.887-3.259-6.56 6.962-3.055-3.258-5.963 3.259z" />
            </svg>
            <!-- telegram -->
            <svg fill="#969696" class="footerIcon" id="Bold">
              <path d="m9.417 15.181-.397 5.584c.568 0 .814-.244 1.109-.537l2.663-2.545 5.518 4.041c1.012.564 1.725.267 1.998-.931l3.622-16.972.001-.001c.321-1.496-.541-2.081-1.527-1.714l-21.29 8.151c-1.453.564-1.431 1.374-.247 1.741l5.443 1.693 12.643-7.911c.595-.394 1.136-.176.691.218z" />
            </svg>
            <!-- twitter -->
            <svg fill="#969696" class="footerIcon" id="Bold">
              <path d="m21.534 7.113c.976-.693 1.797-1.558 2.466-2.554v-.001c-.893.391-1.843.651-2.835.777 1.02-.609 1.799-1.566 2.165-2.719-.951.567-2.001.967-3.12 1.191-.903-.962-2.19-1.557-3.594-1.557-2.724 0-4.917 2.211-4.917 4.921 0 .39.033.765.114 1.122-4.09-.2-7.71-2.16-10.142-5.147-.424.737-.674 1.58-.674 2.487 0 1.704.877 3.214 2.186 4.089-.791-.015-1.566-.245-2.223-.606v.054c0 2.391 1.705 4.377 3.942 4.835-.401.11-.837.162-1.29.162-.315 0-.633-.018-.931-.084.637 1.948 2.447 3.381 4.597 3.428-1.674 1.309-3.8 2.098-6.101 2.098-.403 0-.79-.018-1.177-.067 2.18 1.405 4.762 2.208 7.548 2.208 8.683 0 14.342-7.244 13.986-14.637z" />
            </svg>
            <!-- utube -->
            <svg fill="#969696" class="footerIcon" id="Bold">
              <path d="m23.469 5.929.03.196c-.29-1.029-1.073-1.823-2.068-2.112l-.021-.005c-1.871-.508-9.4-.508-9.4-.508s-7.51-.01-9.4.508c-1.014.294-1.798 1.088-2.083 2.096l-.005.021c-.699 3.651-.704 8.038.031 11.947l-.031-.198c.29 1.029 1.073 1.823 2.068 2.112l.021.005c1.869.509 9.4.509 9.4.509s7.509 0 9.4-.509c1.015-.294 1.799-1.088 2.084-2.096l.005-.021c.318-1.698.5-3.652.5-5.648 0-.073 0-.147-.001-.221.001-.068.001-.149.001-.23 0-1.997-.182-3.951-.531-5.846zm-13.861 9.722v-7.293l6.266 3.652z" />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.container -->
  <!-- test elements -->
  <div class="container-fluid test">

  </div>
  <div class="container-fluid">
    <!-- dev copyrights -->
    <div class="row devCopy justify-content-center">
      <p class="mx-3 pr-3" style="border-right: 2px solid #fff;">حقوق النشر محفوظه لموقع جريدة الوسيط الدولي</p>
      <p>Development Copyrights &copy; 2021 | eng.hamedserag@gmail.com </p>
    </div>
  </div>
</footer>