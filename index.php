<?php

include("./config.php");

// $time = strtotime("-1 hours");

if (isset($_GET["class"])) {
    $time = time();
    $current_hours = date("H", $time);
    $current_minutes = date("i", $time);
    $current_day = date("w", $time) - 1;

    $current_lecture_number = null;
    $current_time = intval($current_hours . $current_minutes);
    if (isset($_GET["ct"])) {
        $current_time = $_GET["ct"];
    }
    if ($current_time >= 925 && $current_time <= 1025) {
        $current_lecture_number = 0;
    } else if ($current_time >= 1025 && $current_time <= 1125) {
        $current_lecture_number = 1;
    } else if ($current_time >= 1155 && $current_time <= 1255) {
        $current_lecture_number = 2;
    } else if ($current_time >= 1255 && $current_time <= 1355) {
        $current_lecture_number = 3;
    }

    $current_lecture_subject = null;

    $stmt = $con->prepare("SELECT * FROM `timetable` WHERE `tt_class` = ? AND `tt_day` = ? AND `tt_rank` = ?");
    $stmt->execute([$_GET["class"], $current_day, $current_lecture_number]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $stmt = $con->prepare("SELECT * FROM `timetable` WHERE `tt_class` = ? AND `tt_day` = ? AND `tt_rank` = ?");

    $stmt = $con->prepare("SELECT * FROM `reschedules` WHERE `rs_class` = ? AND `rs_day` = ? AND `rs_rank` = ?");
    $stmt->execute([$_GET["class"], $current_day, $current_lecture_number]);
    $rs_row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row) {
        $current_lecture_subject = $row["tt_subject"];
    }

    if ($rs_row) {
        $current_lecture_subject = $rs_row["rs_subject"];
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" />

</head>

<body>
    <?php
    if (isset($_REQUEST["class"])) {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <?php
                    if ($current_lecture_subject != NULL) {
                        $stmt = $con->prepare("SELECT * FROM `subjects` WHERE `s_id` = ?");
                        $stmt->execute([$current_lecture_subject]);
                        $row = $stmt->fetch(PDO::FETCH_ASSOC);
                        print_r($row);
                    ?>
                        <h2 class="mt-4 text-secondary">(<?php echo $row["s_short"]; ?>)</h2>
                        <h2 class="mt-3"><?php echo $row["s_subject"]; ?></h2>
                        <h4>(<?php echo $row["s_faculty"]; ?>)</h4>
                        <a href="<?php echo $row["s_link"]; ?>">Google Meet Link</a>
                        <br>
                        <span>You Will Redirect in <span id="count">5</span> Seconds</span>
                        <script>
                            setInterval(function(){
                                var cn = document.getElementById("count");
                                var cc = parseInt(cn.innerHTML);
                                cc-=1;
                                if(cc <= 0){
                                    location.href = '<?php echo $row["s_link"]; ?>';
                                }else{
                                    cn.innerHTML = cc;
                                }
                            }, 1000);
                        </script>
                    <?php
                    } else {
                    ?>
                        <h1 class="text-center pt-5">No Lectures Currently</h1>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-4 offset-4">
                    <h1 class="mt-5 text-center">Select Class</h1>
                    <?php
                    $stmt = $con->prepare("SELECT * FROM `classes` WHERE `c_status` = 1");
                    $stmt->execute();
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($rows as $row) {
                    ?>
                        <a href="index.php?class=<?php echo $row["c_id"]; ?>"><button class="btn btn-primary w-100 my-2"><?php echo $row["c_name"] ?></button></a>
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</body>

</html>