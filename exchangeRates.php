<?php
include('includes/config.php');
session_start();
error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>الوسيط | اسعار العملات</title>

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
            <li class="breadcrumb-item">اسعار العملات</li>
            <li class="breadcrumb-item">
                <a class="active p-1" href="index.php">خدمات</a>
            </li>
        </ol>

    </div>

    <?php
    //show result function
    function showresults($currencyArr, $baseId)
    {
        $catchNet = 0;
        foreach ($currencyArr as $cur) {
            if ($baseId == $catchNet) {
                $baseCurName = explode(":", $cur)[0];
                $baseCur = round((float)explode(":", $cur)[1], 2);
            }
            $catchNet++;
        }
    ?>
        <div class="container curContainer">
            <div class="row">
                <p class="col-12 currencyHeader">1<?php echo ($baseCurName) ?></p>
            </div>
            <div class="row">
                <?php
                $vic = ["USD", "EGP", "EUR", "JPY"];
                $curId = 0;
                foreach ($currencyArr as $cur) {
                    $currency = explode(":", $cur);
                    if ($curId != $baseId) {
                        if (round((float)$currency[1] / $baseCur, 2) != 0 && round((float)$currency[1] / $baseCur, 2) < 9999 || in_array(trim($currency[0]), $vic)) {
                ?>
                            <div class="col-2 d-flex currencyCell <?php if (in_array(trim($currency[0]), $vic)) { ?> vic <?php } ?> ">
                                <a href="exchangeRates.php?curId=<?php echo ($curId) ?>" class="curName py-2"><?php echo ($currency[0]) ?> </a>
                                <p class="curVal py-2">
                                    <?php
                                    if (in_array(trim($currency[0]), $vic) && ((float)$currency[1] / $baseCur) < 0.01) {
                                        echo (round((float)$currency[1] / $baseCur, 6));
                                    } else {
                                        echo (round((float)$currency[1] / $baseCur, 2));
                                    }
                                    ?> </p>
                            </div>
                <?php
                        }
                    }
                    $curId++;
                }
                ?>
            </div>
        </div>
        <div class="container mb-2">
            <div class="row justify-content-center">
                <p class="col-12 date">Updated At : <?php echo (date("Y-m-d")) ?></p>
            </div>
        </div>
    <?php
    }


    //base currency fetch
    if ($_GET['curId'] != '') {
        $_SESSION['curId'] = intval($_GET['curId']);

        //rates fetch
        $query = mysqli_query($con, "SELECT year,month,day FROM exchangerates");
        $result = mysqli_fetch_array($query);
        $today = explode("/", date("Y/m/d"));
        if ($today[0] == $result['year'] && $today[1] == $result['month'] && $today[2] == $result['day']) {
            //fetch from db data if same day
            $query = mysqli_query($con, "SELECT exchangeUnits FROM exchangerates WHERE currency='EUR'");
            $result = mysqli_fetch_array($query);
            $currencyArr = explode(",", $result['exchangeUnits']);
            //show results
            showresults($currencyArr, $_SESSION['curId']);
        } else {
            //fetch api for new day
            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => "http://api.exchangeratesapi.io/v1/latest?access_key=a406a88c6743b246d5e652212a765a55&format=1",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "x-rapidapi-host: aladhan.p.rapidapi.com",
                    "x-rapidapi-key: a406a88c6743b246d5e652212a765a55"
                ],
            ]);
            $response = curl_exec($curl);
            $err = curl_error($curl);
            $replacables = ["\"", "}", " ", "\n"];
            $responseFiltered = str_replace($replacables, "", substr($response, 97));
            mysqli_query($con, "UPDATE exchangerates SET exchangeUnits='" . $responseFiltered . "' ,year='" . $today[0] . "',month='" . $today[1] . "',day='" . $today[2] . "'");
            $currencyArr = explode(",", $responseFiltered);
            curl_close($curl);
            if ($err) {
                echo "cURL Error #:" . $err;
            } else {
                // show results API
                showresults($currencyArr, $_SESSION['curId']);
            }
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