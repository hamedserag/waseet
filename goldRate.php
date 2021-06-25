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
    <link rel="stylesheet" href="css/exchangeRate.css">
</head>

<body>

    <!-- Navigation -->
    <?php include('includes/header.php'); ?>
    <!-- Page Content -->
    <div class="container">

        <ol class="breadcrumb mt-5 row justify-content-end">
            <li class="breadcrumb-item">اسعار الذهب</li>
            <li class="breadcrumb-item">
                <a class="active p-1" href="index.php">خدمات</a>
            </li>
        </ol>

    </div>
    <style>
        .goldType,.goldVal{
            padding: 2vh 0;
            font-size: 1.5rem;
            margin-bottom: 5vh;
        }
        .goldType {
            background-color: #2c2c2c;
            text-align: left;
            padding-left: 1%;
            color: #fff;
        }

        .goldVal {
            border: 1px solid #2c2c2c;
            text-align: center;
        }
        .date{
            background-color: rgba(44, 44, 44, 0.5);
            color: #fff;
            padding: 2vh 0;
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 0;
        }
    </style>
    <?php
    //show results
    function showresults($goldValues)
    {
    ?>
        <div class="container">
            <div class="row justify-content-center">
                <p class="col-4 date">Updated At : <?php echo(date("Y-m-d")) ?></p>
            </div>
            <div class="row justify-content-center">
                <p class="col-2 goldType">24 KARAT</p>
                <p class="col-2 goldVal"><?php echo ($goldValues[0]) ?> EGP</p>
            </div>
            <div class="row justify-content-center">
                <p class="col-2 goldType">21 KARAT</p>
                <p class="col-2 goldVal"><?php echo ($goldValues[1]) ?> EGP</p>
            </div>
            <div class="row justify-content-center">
                <p class="col-2 goldType">18 KARAT</p>
                <p class="col-2 goldVal"><?php echo ($goldValues[2]) ?> EGP</p>
            </div>
        </div>
        <?php
    }
    $today = explode("/", date("Y/m/d"));

    $query = mysqli_query($con, "SELECT * FROM goldrate");
    while ($row = mysqli_fetch_array($query)) {
        $dbdate = [
            $row['year'], $row['month'], $row['day']
        ];
        if ($dbdate[0] == $today[0] && $dbdate[1] == $today[1] && $dbdate[2] == $today[2]) {
            //get data from db
            $g24k = $row['g24k'];
            $g21k = 0.875 * (int)$g24k;
            $g18k = 0.75 * (int)$g24k;
            $goldValues = [
                round($g24k, 1),
                round($g21k, 1),
                round($g18k, 1),
            ];
            showresults($goldValues);
        } else { // if date is diffrent
        ?>
            <script>
                console.log("daily fetch");
            </script>
    <?php
            $currency_code = "EGP";
            $unit_type = "gram";
            $currency_code = strtolower($currency_code);
            $unit_type = strtolower($unit_type);
            $URL = "http://goldpricez.com/api/rates/currency/EGP/measure/gram";
            $apiKey = "239beb9396792eb7df55933386426f7f239beb93";
            $URL = strtolower($URL);
            //Call CURL and pass URL and API KEY
            function httpGet($url, $apiKey)
            {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                //curl_setopt($ch,CURLOPT_HEADER, false); 
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'X-API-KEY: ' . $apiKey
                ));
                $output = curl_exec($ch);
                curl_close($ch);
                return $output;
            }

            // Call API via CURL
            $result = httpGet($URL, $apiKey);
            $replace = [
                "\\", "\"", ":", "}"
            ];
            //print values
            $resArr = explode("gram_in_egp", $result);
            $g24k = str_replace($replace, " ", $resArr[1]);
            $g21k = 0.875 * (int)$g24k;
            $g18k = 0.75 * (int)$g24k;
            $goldValues = [
                round($g24k, 1),
                round($g21k, 1),
                round($g18k, 1),
            ];
            showresults($goldValues);
            //save value to db
            mysqli_query($con, "UPDATE goldrate SET g24k = " . $g24k . ", year=" . $today[0] . ",month=" . $today[1] . ",day=" . $today[2]);
        }
    }
    ?>

    <!-- /.container -->

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>