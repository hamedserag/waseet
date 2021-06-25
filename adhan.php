<?php
include('includes/config.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>الوسيط | تواصل معنا</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <?php include('includes/links.php'); ?>
</head>

<body>

    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    <!-- Page Content -->
    <div class="container">

        <ol class="breadcrumb mt-5 row justify-content-end">
            <li class="breadcrumb-item">مواقيت الصلاه</li>
            <li class="breadcrumb-item">
                <a class="active p-1" href="index.php">خدمات</a>
            </li>
        </ol>
    </div>


    <style>
        .date {
            background-color: rgba(44, 44, 44, 0.5);
            color: #fff;
            padding: 2vh 0;
            text-align: center;
            font-size: 1.5rem;
        }

        .adhanHeader {
            background-color: #2c2c2c;
            text-align: center;
            padding: 1vh 0;
            font-size: 2rem;
            color: #fff;
            font-weight: bold;
        }

        .adhanRow {
            border: 1px solid #2c2c2c;
            font-size: 1.2rem;
            margin-bottom: 20px;
            padding: 10px 0;
        }
    </style>
    <?php
    //show results
    function showresults($fajr, $duhr, $asr, $maghreb, $aisha, $sunrise, $cityName)
    {
    ?>
        <div class="container">
            <div class="row adhanHeader justify-content-center">
                <p><?php echo ($cityName) ?></p>
            </div>
            <div class="row adhanRow">
                <div class="col-2">
                    <p class="adhanTime d-inline"><?php echo ($aisha) ?></p>
                    <p class="adhanName d-inline">عشاء</p>
                </div>
                <div class="col-2">
                    <p class="adhanTime d-inline"><?php echo ($maghreb) ?> </p>
                    <p class="adhanName d-inline">مغرب</p>
                </div>
                <div class="col-2">
                    <p class="adhanTime d-inline"><?php echo ($asr) ?> </p>
                    <p class="adhanName d-inline">عصر</p>
                </div>
                <div class="col-2">
                    <p class="adhanTime d-inline"><?php echo ($duhr) ?> </p>
                    <p class="adhanName d-inline">ظهر</p>
                </div>
                <div class="col-2">
                    <p class="adhanTime d-inline"><?php echo ($sunrise) ?> </p>
                    <p class="adhanName d-inline">عشاء</p>
                </div>
                <div class="col-2">
                    <p class="adhanTime d-inline"><?php echo ($fajr) ?> </p>
                    <p class="adhanName d-inline">فجر</p>
                </div>
            </div>
        </div>
    <?php


    }
    $cities = [
        ["Giza", "Egypt"],
        ["Cairo", "Egypt"],
        ["Alex", "Egypt"],
    ];
    foreach ($cities as $city) {
        $cityName = $city[0];
        $countryName = $city[1];
        //data handling
        $query = mysqli_query($con, "SELECT * FROM adhan WHERE cityName='" . $cityName . "'");
        $result = mysqli_fetch_array($query);
        $today = explode("/", date("Y/m/d"));
        if ($today[0] == $result['year'] && $today[1] == $result['month'] && $today[2] == $result['day']) {
            //show results from db if same day
            showresults($result['fajr'], $result['duhr'], $result['asr'], $result['maghreb'], $result['aisha'], $result['sunrise'], $cityName);
        } else {
            // CITIES -------------------------------------------
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "http://api.aladhan.com/v1/timingsByCity?city='$cityName'&country=$countryName&method=8",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: aladhan.p.rapidapi.com",
                    "x-rapidapi-key: SIGN-UP-FOR-KEY"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            //response filtring
            $responseFiltred = substr($response, 44, 149);
            $fajr = substr($responseFiltred, 9, 5);
            $sunrise = substr($responseFiltred, 27, 5);
            $duhr = substr($responseFiltred, 43, 5);
            $asr = substr($responseFiltred, 57, 5);
            $maghreb = substr($responseFiltred, 92, 5);
            $aisha = substr($responseFiltred, 107, 5);

            curl_close($curl);

            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                // show results
                showresults($fajr, $duhr, $asr, $maghreb, $aisha, $sunrise, $cityName);
                mysqli_query($con, "UPDATE adhan SET fajr='" . $fajr . "',sunrise='" . $sunrise . "',duhr='" . $duhr . "',asr='" . $asr . "',maghreb='" . $maghreb . "',aisha='" . $aisha . "',year='" . $today[0] . "'month='" . $today[1] . "'day='" . $today[2] . "' WHERE cityName='" . $cityName . "'");
            }
        }
    }
    ?>
    <div class="container">
        <div class="row justify-content-center">
            <p class="col-12 date">Updated At : <?php echo (date("Y-m-d")) ?></p>
        </div>
    </div>
    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>