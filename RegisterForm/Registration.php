<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Register Page</title>
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

        <style>
                @import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap');
        </style>

    </head>

    <body>
        
        <?php

                /*Create connection*/
                /*MySQLi Procedural
                $conn = new mysqli($serverName,$userName,$userPasswd,$dbName);
                */

            
                //VALIDATION DATA
                //Declare varialbes
                $usrName = $email = $passwd = $firstName = $lastName = $gender = $ckAgreeBox1;
                $usrErr = $emailErr = $passErr = $cPassErr = $nameErr = $genderErr = $ck1Err ="" ;
                $isReadySubmit = true;

                if($_SERVER["REQUEST_METHOD"] == "POST") {
  
                    $usrName=$_POST['username'];
                    $email =$_POST['email'];
                    $passwd =$_POST['passwd'];
                    $confirmPasswd =$_POST['cpasswd'];
                    $firstName =$_POST['fname'];
                    $lastName =$_POST['lname'];
                    $gender =$_POST['gender'];
                    $ckAgreeBox1 =$_POST['ck1'];

                    $usrErr = checkUserName($usrName);
                    if($usrErr!== null){
                        $isReadySubmit = false;
                    }
                    

                    $emailErr = checkEmail($email);
                    if($emailErr!== null){
                        $isReadySubmit = false;
                    }

                    $passErr = checkPass($passwd);
                    if($passErr!== null){
                        $isReadySubmit = false;
                    }

                    $cPassErr = checkConfirmPass($confirmPasswd);
                    if($cPassErr!== null){
                        $isReadySubmit = false;
                    }
                    
                    $nameErr = checkName($firstName,$lastName);
                    if($nameErr!== null){
                        $isReadySubmit = false;
                    }
                    
                    $genderErr = checkGender($gender);
                    if($genderErr!== null){
                        $isReadySubmit = false;
                    }
                   
                    $ck1Err = checkClickAgree($ckAgreeBox1);
                    if($ck1Err!== null){
                        $isReadySubmit = false;
                    }
                } // end if "REQUEST_METHOD"

                       
                if($isReadySubmit){
                    //Using PDO to connect database

                    /*Declare variables to create a connection*/
                    $serverName = "localhost";
                    $userNameDB = "khangmai";
                    $userPasswdDB ="1Kogajudo@4591";
                    $dbName = "RegistrationTest";
                    $dsn ="mysql:host=$serverName; dbname=$dbName"; //dsn = data source name

                    try{

                        $conn = new PDO($dsn, $userNameDB, $userPasswdDB);
                        //set the PDO error mode to exception
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        echo                        
                        "<script>
                            alert('Connected successfully');
                        </script>";

                        if(isset($_POST['submit'])){
                            signUp($conn, $usrName, $email, $passwd, $firstName, $lastName, $gender);
                        }

                    } // end try
                    catch(PDOException $e){
                        $errmsg = "Connection failed ".$e->getMessage();
                        echo "
                        <script>
                            alert('$errmsg');
                        </script>";
                        
                    } // end catch

                } //end if isReadySubmit

                /**********************************************************************************************/
                /**********************************************************************************************/

                //create a module to add new user 

                function insertNewUser($tempConn, $usrer, $email, $pass, $fname, $lname, $gender){
                    //prepare sql and bind parameter

                    $sql = 'insert into RegistrationTest.Register(usrname,email,passwd,fname,lname,gender) 
                    values(:userName, :email, :password, :firstName, :lastName, :gender)';

                    $stmt = $tempConn->prepare($sql);


                    $stmt->bindParam(':userName', $usrer);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':password', $pass);
                    $stmt->bindParam(':firstName', $fname);
                    $stmt->bindParam(':lastName', $lname);
                    $stmt->bindParam(':gender', $gender);

                    if($stmt->execute()){
                        echo"
                        <script>
                            alert('New records created successfully');
                        </script>";
            
                        $conn = null;
                    
                    }

                } // end newUser module

                //create a module to process to add the new record and check the duplicate record based on
                //userName and email

                function signUp($tempConn,$user,$email,$pass,$fname,$lname,$gender){

                    $sql='select * from RegistrationTest.Register where usrname = :user or email = :email';
                    
                    $stmt = $tempConn->prepare($sql);

                    $stmt->bindParam(':user', $user);
                    $stmt->bindParam(':email', $email);

                    $stmt->execute();

                    
                    if(empty($stmt->fetchAll())){
                        insertNewUser($tempConn,$user,$email,$pass,$fname,$lname,$gender);
                    }else{
                        echo "<script>
                            alert ('You Are Already Registered User......!');
                        </script>";
                    }


                }//end signUp module

                //create a function to return string that verify the input data
                function verifyData($inputData){
                    $inputData = trim($inputdata);
                    $inputData = stripslashes($inputData);
                    $inputData = htmlspecialchars($inputData);
                    return $inputData;
                } // enda verifyData


                 //create a function to return a string value that shows error message for checking username
            function checkUserName($data){

                if(empty($data)){
                    $usrErr = "Username Required...!";
                }

                return $usrErr;
            } // end checkUserName

            //create a function to return a string value that shows error message for checking email

            function checkEmail($data){
                if(empty($data)){
                    $emailErr = "Email Required...!";
                }elseif(!filter_var($data, FILTER_VALIDATE_EMAIL)){
                    $emailErr = "Invalid Email...!";
                }
                return $emailErr;
            } // end checkEmail

            //create a function to return a string value that shows error message for checking password

            function checkPass($data){
                if(empty($data)){
                    $passErr = "Password Field Required...!";
                }
                return $passErr;
            } // end checkPassword

            //create a function to return a string value that shows error message for checking confirm password
            function checkConfirmPass($data){
                if(empty($data)){
                    $cPassErr = " Confirm Password Field Required...!";
                } 
                return $cPassErr;
            } //end checkConfirmPass

            //create a function to return a string value that shows error message for checking last name or first name
            function checkName($data1, $data2){
                if(empty($data1) || empty($data2)){
                    $nameErr = "First & Last Name Required...!";
                }
                return $nameErr;
            } //end checkName

            //create a function to return a string value that shows error message for checking gender radio option

            function checkGender($data){
                if(empty($data)){
                    $genderErr = "Gender Required...!";
                }
                return $genderErr;
            } // end checkGender

            //create a function to return a string value that shows error message for checking clicking to agreement to register
            function checkClickAgree($data){
                if(!isset($data)){
                    $ck1Err = "Need to click agreement!";
                }
                return $ck1Err;
            }

        ?> <!-- end php script --> 


        <form class="" enctype="multipart/form-data" action="<?php  echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">

            <div class="container">

                <div class="inner">

                    <div class="title">

                        <h3>Registration Form</h3>

                    </div> <!-- end class title-->

                    <div class="content">

                        <div class="txt">
                            <input type="text" name="username" value="<?php echo ($usrName ?? ''); ?>" id="txtuser" placeholder="Username">
                        </div>

                        <span id="span"><?php echo $usrErr; ?></span>

                        <div class="txt1">
                            <input type="text" name="email" value="<?php echo ($email ?? ''); ?>" id="txtemail" placeholder="Email">
                        </div>

                        <span id="span"><?php echo $emailErr; ?></span>

                        <div class="txt1">
                            <input type="text" name="passwd" value="" id="txtpass" placeholder="Password">
                        </div>

                        <span id="span"><?php echo $passErr; ?></span>

                        <div class="txt1">
                            <input type="text" name="cpasswd" value="" id="txtcpass" placeholder="Confirm Password">
                        </div>

                        <span id="span"><?php echo $cPassErr; ?></span>

                    </div> <!--end class content-->

                    <div class="content2">

                        <input type="text" name="fname" value="<?php echo ($firstName ?? ''); ?>" id="txtfname" placeholder="First Name">
                        <input type="text" name="lname" value="<?php echo ($lastName ?? ''); ?>" id="txtlname" placeholder="Last Name">

                    </div> <!--end class content2 -->

                    <span id="span"><?php echo $nameErr; ?></span>

                    <div class="radios">

                        <h4>Gender:</h4>
                        <input type="radio" id="male" name="gender" value="Male" <?php echo ($gender === 'Male' ? 'checked' : ''); ?>>
                        <label for="male">Male</label>
                        <input type="radio" id="female" name="gender" value="Female" <?php echo ($gender === 'Female' ? 'checked' : ''); ?>>
                        <label for="female">Female</label>

                    </div><!-- end class radio -->

                    <span id="span"><?php echo $genderErr; ?></span>


                    <div class="ckbox">

                        <input type="checkbox" id="ckbox" name="ck1" value="">
                        <span>I Agree to Tearm and Service</span>
                        <br/>
                        <input type="checkbox" id="ckbox2" name="ck2" value="">
                        <span>I want to receive news and special offers</span>

                    </div> <!-- end class ckbox -->

                    <span id="span"><?php echo $ck1Err; ?></span>

                    <div class="btnsub">

                        <input type="submit" name="submit" id="btnsub" value="submit">

                    </div> <!-- end class btnsub -->

                </div> <!-- end class inner-->

            </div> <!-- end class container-->

        </form>
       
    </body>
</html>


