<?php
if (!array_key_exists("cv_id", $_COOKIE)) {
    header("Location:login.php");
    exit;
}
$id = $_COOKIE["cv_id"];
$err = [];
$con = mysqli_connect("localhost", "root", "", "cv");
$res = mysqli_query($con, "SELECT * FROM fields");
$fields = [];
while ($row = mysqli_fetch_row($res)) {
    $field = (object)['id' => $row[0], 'name' => $row[1], 'display' => 1];
    array_push($fields, $field);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'change_field') {
    foreach ($fields as $field) {
        $fieldId = $field->id;
        if (array_key_exists($fieldId, $_POST)) {
            $field->display = 1;
        } else {
            $field->display = 0;
        }
    }
    foreach ($fields as $field) {
        $result = mysqli_query($con, "UPDATE user_fields SET display=$field->display WHERE userid=$id AND fieldid=$field->id");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['submit'] == 'save') {
    echo "save";
    $fullname = $birthday = $gender = $address = $email = $phone = $avatar = $position = "";
    $education = $society_activities = $working_process = $skills = $experiences = $certifications = $hobbies = $desire = "";
    $fullname = $_POST["fullname"];
    $birthday = $_POST["birthday"];
    $gender = $_POST["gender"];
    $address = $_POST["address"];
    $email = $_POST["mail"];
    $phone = $_POST["phone"];
    $position = $_POST["pos_job"];
    $education = $_POST["education"];
    $society_activities = $_POST["society_activities"];
    $working_process = $_POST["working_process"];
    $skills = $_POST["skills"];
    $experiences = $_POST["experiences"];
    $certifications = $_POST["certifications"];
    $hobbies = $_POST["hobbies"];
    $desire = $_POST["desire"];


    //kiem tra
    if (empty($fullname)) {
        $err['fullname'] = "Fullname cann't be empty";
    }
    if (empty($birthday)) {
        $err['birthday'] = "Birthday cann't be empty";
    }
    if (empty($gender)) {
        $err['gender'] = "Gender cann't be empty";
    }
    if (empty($address)) {
        $err['address'] = "Address cann't be empty";
    }
    if (empty($email)) {
        $err['email'] = "Email cann't be empty";
    }
    if (empty($phone)) {
        $err['phone'] = "Phone number cann't be empty";
    }
    if (empty($position)) {
        $err['position'] = "Position cann't be empty";
    }


    //upload ảnh lên server
    $visible = false;
    $target_dir = "public/uploads/";
    //link lưu trên server
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $err['avatar'] = "File is not an image.";
            $uploadOk = 0;
        }
    }
    if ($_FILES["fileToUpload"]["size"] > 5000000) {
        $err['avatar'] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $err['avatar'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        //        $err = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        } else {
            $err['avatar'] = "Sorry, there was an error uploading your file.";
        }
    }


    if (count($err) == 0) {
        //insert into DB
        $query = mysqli_query($con, "REPLACE INTO user_info VALUES ($id, '$fullname', '$birthday', '$gender', '$address', '$phone', '$email', '$target_file', '$position', '$education', '$working_process', '$society_activities', '$skills', '$experiences', '$certifications', '$hobbies', '$desire' )");


        if ($query) {
            header("Location:topcv.php");
        } else {
            $err['insert'] = "Can not insert into database." . mysqli_error($con);
        }
    } else {
        //alert
        print_r($err);
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Form</title>
    <style type="text/css">
        body {
            font-family: 'Lato';
            font-size: 11px;
            width: 100%;
            display: flex;
            flex: 1; /*chiếm toàn bộ màn hình*/
            justify-content: center;
        }

        div {
            display: flex;
            flex-direction: column;
        }

        .container {
            background-color: white;
            width: 80%;
        }

        .personal_details {
            border: #f7e0c1 solid 1px;
            padding: 10px;
            border-radius: 5px;
        }

        .title {
            font-weight: bold;
            font-style: italic;
            text-decoration: underline;
        }

        .row {
            flex-direction: row;
            margin-bottom: 10px;
        }

        .rowItem {
            display: flex;
            flex: 1;
            flex-direction: column
        }

        .rowItem span {
            margin-top: 2px;
            margin-bottom: 2px;
        }

        .gender_group {
            display: flex;
            flex-direction: row;
        }

        .text_input {
            border-radius: 5px;
            border: #f7e0c1 solid 1px;
            height: 30px;
            padding-left: 10px;
            padding-right: 10px;
        }

        .row_item_left {
            margin-right: 2%;
        }

        .row_item_right {
            margin-left: 2%;
        }

        .information {
            border: #f7e0c1 solid 1px;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }

        textarea {
            resize: none;
            border-radius: 5px;
            border: #f7e0c1 solid 1px;
            height: 30px;
            padding: 10px 10px;
            font-family: 'Lato';
        }

        .btn_submit {
            width: 100%;
            background-color: #f7e0c1;
            border-radius: 5px;
            border: none;
            height: 50px;
            font-family: 'Lato';
            font-weight: bold;
            font-size: 14px;
        }
    </style>
    <meta charset="utf-8">
    <link href='https://fonts.googleapis.com/css?family=Lato' rel='stylesheet'>
    <link rel="stylesheet" href="index.css">
    <script
            src="https://code.jquery.com/jquery-3.4.1.slim.js"
            integrity="sha256-BTlTdQO9/fascB1drekrDVkaKd9PkwBymMlHOiG+qLI="
            crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            $("#change_field").click(function () {
                $(".dialog_container").removeClass("hidden").addClass("show");
            });
            $("#cancel_change_field").click(function () {
                $(".dialog_container").removeClass("show").addClass("hidden");
            })
        });
    </script>
</head>
<body>
<div class="container">
    <form action="index.php" method="post" enctype="multipart/form-data">
        <div class="personal_details">
            <h3 class="title">Personal details</h3>
            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Fullname</span>
                    <input class="text_input" type="text" name="fullname"><br>
                    <span><?php
                        if (array_key_exists("fullname", $err)) {
                            echo $err['fullname'];
                        }
                        ?></span>
                </div>

                <div class="rowItem row_item_left">
                    <span>Birthday</span>
                    <input class="text_input" type="date" id="start" name="birthday"
                           value="1998-08-26"
                           min="1900-01-01" max="2019-12-31"><br>
                    <span><?php
                        if (array_key_exists("birthday", $err)) {
                            echo $err['birthday'];
                        }
                        ?>
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Gender</span>
                    <div class="gender_group">
                        <input type="radio" name="gender" value="Nam" style="margin-right: 5px" checked>Nam<br>
                        <input type="radio" name="gender" value="Nữ" style="margin-right: 5px; margin-left: 25px">Nữ<br>
                        <input type="radio" name="gender" value="Khác" style="margin-left: 25px; margin-right: 5px">Khác<br>
                    </div>
                    <span><?php
                        if (array_key_exists("gender", $err)) {
                            echo $err['gender'];
                        }
                        ?>    
                    </span>
                </div>
                <div class="rowItem row_item_left">
                    <span>Address</span>
                    <input class="text_input" type="text" name="address">
                    <span><?php
                        if (array_key_exists("address", $err)) {
                            echo $err['address'];
                        }
                        ?>    
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Phone number</span>
                    <input class="text_input" type="text" name="phone">
                    <span><?php
                        if (array_key_exists("phone", $err)) {
                            echo $err['phone'];
                        }
                        ?>    
                    </span>
                </div>
                <div class="rowItem row_item_left">
                    <span>Email</span>
                    <input class="text_input" type="text" name="mail">
                    <span><?php
                        if (array_key_exists("email", $err)) {
                            echo $err['email'];
                        }
                        ?>    
                    </span>
                </div>
            </div>
            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Avatar</span>
                    <input type="file" name="fileToUpload" id="fileToUpload">
                    <span><?php
                        if (array_key_exists("avatar", $err)) {
                            echo $err['avatar'];
                        }
                        ?>
                    </span>
                </div>
                <div class="rowItem row_item_left">
                    <span>The position you want to apply</span>
                    <input class="text_input" type="text" name="pos_job">
                    <span><?php
                        if (array_key_exists("position", $err)) {
                            echo $err['position'];
                        }
                        ?>    
                    </span>
                </div>
            </div>
        </div>

        <div class="information">
            <h3 class="title">Information</h3>
            <span id="change_field">Thay đổi trường hiển thị</span>

            <?php
            foreach ($fields as $field) {
                if ($field->display == 1) {
                    echo "
                            <div class=\"row\">
                                <div class=\"rowItem row_item_left\">
                                    <span>$field->name</span>
                                    <textarea rows=\"3\" name=\"education\"></textarea>
                                </div>
                            </div>
                        ";
                }
            }
            ?>

            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Education process</span>
                    <textarea rows="3" name="education"></textarea>
                </div>
            </div>

            <div class="rowItem row_item_left">
                <span>Working process</span>
                <textarea rows="3" name="working"></textarea>
            </div>

            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Society activities</span>
                    <textarea rows="3" name="society_activities"></textarea>
                </div>
            </div>

            <div class="rowItem row_item_left">
                <span>Skills</span>
                <textarea rows="3" name="skills"></textarea>
            </div>

            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Experiences</span>
                    <textarea rows="3" name="experiences"></textarea>
                </div>
            </div>

            <div class="rowItem row_item_left">
                <span>Certifications</span>
                <textarea rows="3" name="certifications"></textarea>
            </div>

            <div class="row">
                <div class="rowItem row_item_left">
                    <span>Hobbies</span>
                    <textarea rows="3" name="hobbies"></textarea>
                </div>
            </div>
            <div class="rowItem row_item_left">
                <span>Desire</span>
                <textarea rows="3" name="desire"></textarea>
            </div>
        </div>
        <br>
        <br>
        <span>
            <?php
            if (array_key_exists("insert", $err)) {
                echo $err['insert'];
            }
            ?></span>
        <input class="btn_submit" type="submit" name="submit" value="save">
    </form>
    <div class="dialog_container hidden">
        <div class="dialog">
            <form action="index.php" method="post">
                <?php
                foreach ($fields as $field) {
                    echo "
                            <div class=\"row\">
                                <span>$field->name</span>
                                <input type='checkbox' name='$field->id' value='1' checked>
                            </div>
                    ";
                }
                ?>
                <div class="navbar">
                    <button id="cancel_change_field">Cancel</button>
                    <button type="submit" name="submit" value="change_field">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
