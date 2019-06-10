<?php
    session_start();
    //create variales names for setting up database server
    $serverName = "localhost";
    $userNameDB = "khangmai";
    $userPasswdDB ="1Kogajudo@4591";
    $dbName = "RegistrationTest";
    $dsn ="mysql:host=$serverName; dbname=$dbName";

    //create variables names associating with name in html
    $login =trim($_POST['login']);
    $userName =trim($_POST['username']);
    $userPasswd = trim($_POST['password']);

    try{
        $conn = new PDO($dsn,$userNameDB,$userPasswdDB);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       /* echo                        
                "<script>
                        alert('Connected successfully');
                </script>"; */
        if(isset($login)){
            if(empty($userName) || empty($userPasswd)){
                $message ='<label>All fields are required</label>';
            }
            else{
                $sql="select * from RegistrationTest.Register where usrname = :username and passwd = :password"; 
              
                $stmt = $conn -> prepare($sql);

                $stmt->execute([':username'=>$userName,':password'=>$userPasswd]);
            


                if($stmt->rowCount()>0){
                    $_SESSION["username"] = $userName;
                    header("Location:login_success.php");
                }
                else{
                    $message='<label>Username or Password is wrong</label>';
                }
            }
        }
    } //end try
    catch(PDOException $e){

        $message =$e->getMessage();

    } //end catch



?> <!-- end php-->

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Login Index</title>
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="src/css/Style.css">

        <!-- 
            jquery.slim.min.js first
            then, popper.min,js
            last, bootstrap.min.js
        -->
        
        <script src="node_modules/jquery/jquery.min.js"></script>
        <script src="node_modules/popper.js/dist/popper.min.js"></script>
        <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>

        <!--
        <style>
                @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap');
        </style>
        -->

    </head>

    <body>
        
        <br />
        <h3 align="center">PHP Login Script</h3>
        <br />
        <h3 align="center" style="color: green;" >Prototype Login With PDO</h3>

        <div class="container" style="width:500px; height: 240px; border: 2px solid red; margin-top: 3px;">

         <?php

            if(isset($message)) {
                echo '<label class="text-danger">'.$message.'</label>';
            }
         ?>

            <form method="post">


                     <label>Username</label>

                     <input type="text" name="username" class="form-control" />
 	
                     <br />
 	
                     <label>Password</label>
 	
                     <input type="password" name="password" class="form-control" />

                     <br />

                     <input type="submit" name="login" class="btn btn-primary btn-block" value="Login" />
 	
            </form>



 	
        </div>



 	
        <br />



<div class="container" style="width:500px; height: 240px; border: 2px solid red; margin-top: 3px;">




       
    </body>


</html>
