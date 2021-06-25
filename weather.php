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
    <title>الوسيط | تواصل معنا</title>
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="css/modern-business.css" rel="stylesheet">
    <?php include('includes/links.php'); ?>
    <link rel="stylesheet" href="css/exchangeRate.css">
</head>

<body>
    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    <!-- Page Content -->
    <!-- contianer -->
    <div class="container pt-5 mt-5">
        <ol class="breadcrumb mt-5 row justify-content-end">
            <li class="breadcrumb-item">درجات الحراره</li>
            <li class="breadcrumb-item">
                <a class="active p-1" href="index.php">خدمات</a>
            </li>
        </ol>
        <?php
        $fetchSuccessful = false;
        if ($_GET['cityId'] != '') {
            $_SESSION['cityId'] = intval($_GET['cityId']);
        }
        $cities = [
            ["Giza", "30.0131", "31.2089"],
            ["Cairo", "30.0444", "31.2357"],
            ["Alex", "31.2001", "29.9187"],
        ];
        $query = mysqli_query($con, "SELECT * FROM weather WHERE city='" . $cities[$_SESSION['cityId']][0] . "'");
        $today = explode("-", date("Y-m-d"));
        $row = mysqli_fetch_array($query);
        $fetchedWeatherData = explode("#", $row['weatherData']);
        if ($row['year'] == $today[0] && $row['month'] == $today[1] && $row['day'] == $today[2]) {
            $query = mysqli_query($con, "SELECT * FROM weather WHERE city='" . $cities[$_SESSION['cityId']][0] . "'");
            //temp fetch from db
            $weatherTime = $row['startTime'];
        ?>
            <div class="row justify-content-center weather">
                <h1 class="col-12 row justify-content-center"><?php echo ($cities[$_SESSION['cityId']][0] . "<br>"); ?></h1>
                <div class="weatherContainer col-5 row justify-content-center my-5" >
                    <?php
                    for ($i = 0; $i < 24; $i++) {
                        if ($fetchedWeatherData[$i] != "") {
                            showTemp($weatherTime, $fetchedWeatherData[$i]);
                            $weatherTime++;
                        }
                    }
                    ?>
                </div>
            </div>
            <script>

            </script>
        <?php
        } else {

            
            //curl command
            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => 'https://api.tomorrow.io/v4/timelines?location=' . $cities[$_SESSION['cityId']][1] . ',' . $cities[$_SESSION['cityId']][2] . '&fields=temperature&timesteps=1h&units=metric&apikey=WsnFDr6LfOVEVZP3WQYWGWyso2BnCXsJ',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: community-open-weather-map.p.rapidapi.com",
                    "x-rapidapi-key: 2e0df8969amsh6c61afb36ec4ab0p17d157jsn85034bb3eb25"
                ],
            ]);
            //response of curl
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $responseFiltered = explode("temperature\":", substr($response, 126)); //filtred response
            curl_close($curl); //end of curl fetch
            if ($err) { //curl error catching
                echo "cURL Error #:" . $err;
            } else { //curl response handling
                $curHour = date("h");
                $weatherData = [];
                $weatherTime = (int)$curHour;
                $customSerialize = "";
                foreach ($responseFiltered as $res) {
                    if (substr($res, 0, 4) != "tTim") {
                        array_push($weatherData, substr($res, 0, 4));
                        $customSerialize = $customSerialize . substr($res, 0, 4) . "#";
                    }
                }
                //save data to db
                mysqli_query($con, "UPDATE weather SET weatherData='" . $customSerialize . "',startTime='" . $weatherTime . "',year='" . $today[0] . "',month='" . $today[1] . "',day='" . $today[2] . "' WHERE city='" . $cities[$_SESSION['cityId']][0] . "'");
                //echo data
                foreach ($weatherData as $data) {
                    echo ("<br> Hr : " . $weatherTime . " Temp : " . $data);
                    (int)$weatherTime++;
                    if ($weatherTime > 23) {
                        $weatherTime = 0;
                    }
                }
                header("Refresh:0");
            }
        }

        function showTemp($hr, $temp)
        {
            $color = "bg-danger";
            if ($temp > 30) {
                $color = "bg-danger";
            } else if ($temp > 20) {
                $color = "bg-warning";
            } else {
                $color = "bg-info";
            }
        ?>
            <div class="mr-2 weatherCol <?php echo ($color) ?>" style="height:<?php echo ($temp * 4) ?>px; width:10px;"> </div>
        <?php
        }
        ?>
    </div>
    <!-- /.container -->
    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>