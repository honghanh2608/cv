<?php
    function saveFields($fields) {
        $con = mysqli_connect("localhost","root","","cv");
        foreach ($fields as $field) {
            $sql = "UPDATE user_fields SET display=$field->display";
            $res = mysqli_query($con, $sql);
        }
    }