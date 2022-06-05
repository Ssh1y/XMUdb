<?php
session_start();

if (isset($_SESSION['USER'])) {
    if($_SESSION['USER'] == "admin"){  //admin
        echo "<script>
            window.onload = check_session;
            function check_session(){
                $('#noSigned').hide();
                $('#admin').css('display','block');
            }
            </script>";
    }
    else{                               //普通用户
        echo "<script>
            window.onload = check_session;
            function check_session(){
                $('#noSigned').hide();
                $('#Signed').css('display','block');
                $('#personal_album').css('display','block');
                $('#submitbtn').removeAttr(\"disabled\");
                $('#avatar').css('display','block');
            }
            </script>";
    }
}