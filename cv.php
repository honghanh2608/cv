<!DOCTYPE html>
<html>
<head>
    <title>CV</title>
    <style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        table {
            width: 100%;
        }

        th, td {
            padding: 5px;
            text-align: left;
        }

        thead, tr {
            width: 100%;

        }

        #right {
            width: 25%;
        }

    </style>
</head>
<body>
<?php
    function validate() {
        $fullName = $_POST["fullname"];
        if (empty($fullName)) {
            return "Fullname can not be empty";
     }
      return null;
    }

    $err = "";
    $visible = false;
    $target_dir = "public/uploads/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $err = "File is not an image.";
            $uploadOk = 0;
        }
    }
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        $err = "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        $err = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $err = "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        } else {
            $err = "Sorry, there was an error uploading your file.";
        }
    }

    if (empty($err)) {
        $err = validate();
    }

    if (empty($err)) {
    } else {
        echo "<script type='text/javascript'>alert('$err');</script>";
        $previous = "javascript:history.go(-1)";
        echo "<a href=\"$previous\">Back</a>";
    }
?>
<table <?php
        if (empty($err)) {
            echo "style=\"display: table\"";
        } else {
            echo "style=\"display: none\"";
        }
    ?>
>
    <thead>
    <tr>
        <td colspan="3">
            Personal details
            <p>
                Họ Tên: <?php echo $_POST["fullname"]; ?> <br>
                Ngày sinh: <?php echo $_POST["birthday"]; ?><br>
                Giới tính: <?php echo $_POST["gender"]; ?><br>
                Địa chỉ: <?php echo $_POST["address"]; ?><br>
                Số điện thoại: <?php echo $_POST["phone"]; ?><br>
                Email: <?php echo $_POST["mail"]; ?><br>
            </p>
        </td>
        <td id="right" colspan="1">
            <?php
                echo '<img src="'.$target_file.'" width="150" height="150" />';
            ?>
        </td>
    </tr>
    </thead>
    <tr>
        <td class="field" colspan="1" width="25%">Education process</td>
        <td colspan="3"><?php echo $_POST["education"]; ?></td>
    </tr>
    <tr>
        <td colspan="1" class="field">Working process</td>
        <td colspan="3"><?php echo $_POST["working"]; ?></td>
    </tr>
    <tr>
        <td colspan="1" class="field">Society activities</td>
        <td colspan="3"><?php echo $_POST["society_activities"]; ?></td>
    </tr>
    <tr>
        <td colspan="1" class="field">Skills</td>
        <td colspan="3"><?php echo $_POST["skills"]; ?></td>
    </tr>
    <tr>
        <td colspan="1" class="field">Experiences</td>
        <td colspan="3"><?php echo $_POST["experiences"]; ?></td>
    </tr>
    <tr>
        <td colspan="1" class="field">Certifications</td>
        <td colspan="3"><?php echo $_POST["certifications"]; ?></td>
    </tr>
    <tr>
        <td colspan="1" class="field">Hobbies</td>
        <td colspan="3"><?php echo $_POST["hobbies"]; ?></td>
    </tr>
    <tr>
        <td colspan="1" class="field">Desire</td>
        <td colspan="3"><?php echo $_POST["desire"]; ?></td>
    </tr>
</table>
</body>
</html>

