<?php
include("../config.php");
if (isset($_REQUEST["add_class"])) {
    $stmt = $con->prepare("INSERT INTO `classes` (`c_name`) VALUES (?)");
    $stmt->execute([$_REQUEST["class_name"]]);

    $class_id = $con->lastInsertId();


    $stmt = $con->prepare("INSERT INTO `timetable`(`tt_class`, `tt_day`, `tt_rank`) VALUES (?,?,?)");

    for ($i = 0; $i <= 5; $i++) {
        for ($j = 0; $j <= 3; $j++) {
            $stmt->execute([$class_id, $i, $j]);
        }
    }
    header("location:index.php");
    exit();
}
if (isset($_REQUEST["update_lec"])) {
    $class = $_REQUEST["class"];
    $day = $_REQUEST["day"];
    $rank = $_REQUEST["rank"];
    $subject = $_REQUEST["subject"];

    if ($subject == "null" || $subject == 0) {
        $subject = NULL;
    }
    $stmt = $con->prepare("UPDATE `timetable` SET `tt_subject` = ? WHERE `tt_class` = ? AND `tt_day` = ? AND `tt_rank` = ?");
    $stmt->execute([$subject, $class, $day, $rank]);
    echo "OK";
    exit();
}
if (isset($_REQUEST["update_color"])) {
    $rs = $_REQUEST["rs"];
    $color = $_REQUEST["color"];
    $stmt = $con->prepare("UPDATE `reschedules` SET `rs_color` = ? WHERE `rs_id` = ?");
    $stmt->execute([$color, $rs]);
    echo "OK";
    exit();
}
if (isset($_REQUEST["rs_add"])) {
    $class = get_not_empty($_REQUEST["class"]);
    $day = get_not_empty($_REQUEST["rs_day"]);
    $rank = get_not_empty($_REQUEST["rs_rank"]);
    $color = $_REQUEST["rs_color"];
    $note = $_REQUEST["rs_note"];
    $subject = $_REQUEST["rs_subject"];
    if ($subject == "null" || $subject == 0) {
        $subject = NULL;
    }
    $stmt = $con->prepare("INSERT INTO `reschedules`(`rs_class`, `rs_day`, `rs_rank`, `rs_subject`, `rs_color`, `rs_note`) VALUES (?,?,?,?,?,?)");
    if ($class >= 0 && $day >= 0  &&  $rank >= 0) {
        $stmt->execute([$class, $day, $rank, $subject, $color, $note]);
    }
    header("location:index.php?class=" . $class);
    exit();
}
if (isset($_REQUEST["rs_del"])) {
    $class = $_REQUEST["class"];
    $rs = $_REQUEST["rs_del"];

    $stmt = $con->prepare("DELETE FROM `reschedules` WHERE `rs_id` = ?");

    $stmt->execute([$rs]);

    header("location:index.php?class=" . $class);
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
    <style>
        .reschedule {
            background-color: #e6afff;
        }
    </style>
</head>

<body style="background-color: #ffffdb;">
    <?php
    if (isset($_GET["class"])) {
        $tt = array(
            array(null, null, null, null),
            array(null, null, null, null),
            array(null, null, null, null),
            array(null, null, null, null),
            array(null, null, null, null),
            array(null, null, null, null),
        );

        $rss = array();

        $stmt = $con->prepare("SELECT * FROM `subjects` WHERE `s_status` = 1");
        $stmt->execute();
        $temp_subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $subjects = array();
        foreach ($temp_subjects as $temp_subject) {
            $subjects[$temp_subject["s_id"]] = $temp_subject;
        }

        $stmt = $con->prepare("SELECT * FROM `reschedules` WHERE `rs_status` = 1");
        $stmt->execute();
        $reschedules = $stmt->fetchAll(PDO::FETCH_ASSOC);



        $stmt = $con->prepare("SELECT * FROM `timetable` WHERE `tt_class` = ?");
        $stmt->execute([$_GET["class"]]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            $tt[$row["tt_day"]][$row["tt_rank"]] = $row["tt_subject"];
        }

        foreach ($reschedules as $reschedule) {
            $tt[$reschedule["rs_day"]][$reschedule["rs_rank"]] = $reschedule["rs_subject"];
            $rss[$reschedule["rs_day"]][$reschedule["rs_rank"]] = array("color" => $reschedule["rs_color"], "id" => $reschedule["rs_id"], "note" => $reschedule["rs_note"]);
        }
    ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 pt-5">
                    <table class="table">
                        <tr>
                            <th>Index</th>
                            <th>Monday</th>
                            <th>Tuesday</th>
                            <th>Wednesday</th>
                            <th>Thursday</th>
                            <th>Friday</th>
                            <th>Saturday</th>
                        </tr>
                        <?php
                        for ($j = 0; $j <= 3; $j++) {
                        ?>
                            <tr>
                                <th>Lec <?php echo $j + 1; ?></th>
                                <?php
                                for ($i = 0; $i <= 5; $i++) {

                                ?>
                                    <td>

                                        <select class="form-select lec_select" <?php if (isset($rss[$i][$j])) {
                                                                                    echo "style='background-color:" . $rss[$i][$j]["color"] . ";' id='rs-" . $rss[$i][$j]["id"] . "' data-bs-toggle='tooltip' data-bs-placement='bottom' title='" . $rss[$i][$j]["note"] . "' ";
                                                                                } ?> data-day="<?php echo $i; ?>" data-rank="<?php echo $j; ?>">
                                            <option value="null">None</option>
                                            <?php
                                            foreach ($subjects as $subject) {
                                            ?>
                                                <option <?php if ($tt[$i][$j] == $subject["s_id"]) {
                                                            echo "selected";
                                                        } ?> value="<?php echo $subject["s_id"]; ?>"><?php echo $subject["s_short"]; ?></option>
                                            <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                <?php
                                }
                                ?>
                            </tr>
                        <?php
                        }
                        ?>
                    </table>
                </div>
                <hr>
                <div class="col-8 offset-2 pt-3">
                    <?php
                    if (count($reschedules) > 0) {
                    ?>
                        <div class="row pb-5">
                            <div class="col-12">
                                <div class="row pb-2 text-center" style="font-weight: bold;">
                                    <div class="col-2">Day</div>
                                    <div class="col-2">Lecture</div>
                                    <div class="col-2">Subject</div>
                                    <div class="col-3">Note</div>
                                    <div class="col-1">C</div>
                                    <div class="col-2">Remove</div>
                                </div>
                            </div>
                            <?php
                            foreach ($reschedules as $reschedule) {
                            ?>
                                <div class="col-12 pb-3">
                                    <div class="row">
                                        <div class="col-2">
                                            <input class="form-control" value="<?php echo $days[$reschedule["rs_day"]]; ?>">
                                        </div>
                                        <div class="col-2">
                                            <input class="form-control" value="<?php echo $lectures[$reschedule["rs_rank"]]; ?>">
                                        </div>
                                        <div class="col-2">
                                            <input class="form-control" value="<?php if ($reschedule["rs_subject"] != NULL) {
                                                                                    echo $subjects[$reschedule["rs_subject"]]["s_short"];
                                                                                } else {
                                                                                    echo "None";
                                                                                } ?>">
                                        </div>
                                        <div class="col-3">
                                            <input type="text" class="form-control rs_color" data-rs="<?php echo $reschedule["rs_id"]; ?>" value="<?php echo $reschedule["rs_note"]; ?>">
                                        </div>
                                        <div class="col-1">
                                            <input type="color" class="form-control form-control-color rs_color" data-rs="<?php echo $reschedule["rs_id"]; ?>" value="<?php echo $reschedule["rs_color"]; ?>">
                                        </div>
                                        <div class="col-2">
                                            <a href="index.php?class=<?php echo $_REQUEST["class"]; ?>&rs_del=<?php echo $reschedule["rs_id"]; ?>"><button class="btn btn-danger w-100">Remove</button></a>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                    <form action="index.php?class=<?php echo $_REQUEST["class"]; ?>" method="post">
                        <div class="row">
                            <div class="col-2">
                                <label>Select Day</label>
                                <select class="form-select" name="rs_day" required>
                                    <option value="">--Select--</option>
                                    <option value="0">Monday</option>
                                    <option value="1">Tuesday</option>
                                    <option value="2">Wednesday</option>
                                    <option value="3">Thursday</option>
                                    <option value="4">Friday</option>
                                    <option value="5">Saturday</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label>Select Lecture</label>
                                <select class="form-select" name="rs_rank" required>
                                    <option value="">--Select--</option>
                                    <option value="0">Lec 1</option>
                                    <option value="1">Lec 2</option>
                                    <option value="2">Lec 3</option>
                                    <option value="3">Lec 4</option>
                                </select>
                            </div>
                            <div class="col-2">
                                <label>Select Subject</label>
                                <select class="form-select" name="rs_subject">
                                    <option value="null">--Select--</option>
                                    <?php
                                    foreach ($subjects as $subject) {
                                    ?>
                                        <option value="<?php echo $subject["s_id"] ?>"><?php echo $subject["s_short"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3">
                                <label>Note</label>
                                <input type="test" name="rs_note" class="form-control">
                            </div>
                            <div class="col-1">
                                <label>Color</label>
                                <input type="color" name="rs_color" class="form-control form-control-color" value="#ced4da">
                            </div>
                            <div class="col-2">
                                <input type="submit" name="rs_add" value="Add RS" class="btn btn-success mt-4 w-100">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    <?php
    } else {
    ?>
        <div class="container">
            <div class="row">
                <div class="col-4 offset-4">
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
                <div class="col-4 offset-4 pt-4">
                    <form method="GET">
                        <input class="form-control" name="class_name">
                        <input type="submit" class="btn btn-success mt-2" name="add_class" value="Add Class">
                    </form>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <?php
    if (isset($_REQUEST["class"])) {
    ?>
        <script>
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            console.log(tooltipTriggerList);
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            $(document).ready(function() {
                var myClass = <?php echo $_REQUEST["class"]; ?>;
                $(".lec_select").change(function() {
                    $.post("index.php", {
                        update_lec: 1,
                        class: myClass,
                        day: $(this).data("day"),
                        rank: $(this).data("rank"),
                        subject: $(this).val()
                    });
                });
                $(".rs_color").change(function() {
                    var rs_id = $(this).data("rs");
                    var rs_color = $(this).val();
                    $.post("index.php", {
                        update_color: 1,
                        rs: rs_id,
                        color: rs_color
                    }, function(data) {
                        $("#rs-" + rs_id).css("background-color", rs_color);
                    });
                })
            })
        </script>
    <?php
    }
    ?>
</body>

</html>