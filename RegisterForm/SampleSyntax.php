<?php   
        
        /*$dbname = "RegistrationTest";
        $con = mysqli_connect("localhost","khangmai","1Kogajudo@4591",$dbname);
        $sql = "SELECT * FROM Register WHERE usrname = 'Quang' AND email = 'quangsuper@dog.com'";                 
        $result = mysqli_query($con, $sql);
        print_r($result);
        echo "<br/><br/>";
        print_r(mysqli_fetch_array($result)); // 2
        echo "<br/><br/>";
        print_r(mysqli_fetch_array($result)); // 3
        exit(); */

            $usrerr = $eerr =$perr = $cperr = $fnerr = $gerr = " ";
            $usrname = $email = $passwd = $fname = $lname = $gender;
            $boolean = true;
            

            if($_SERVER["REQUEST_METHOD"] == "POST"){
                /*print_r($_SERVER);
                var_dump($_POST);
                exit(); */

                /*$post = true;*/

                if(empty($_POST["usrname"])){
                    $usrerr = "Username Required...!";
                    $boolean = false;
                }
                else{
                    $usrname = validate_input($_POST["usrname"]);
                }
    
                if(empty($_POST["email"])){
                    $eerr = "Email Required...!";
                    $boolean = false;
                }elseif(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
                    $eerr = "Invalid Email...!";
                    $boolean = false;
                }else{
                    $email = validate_input($_POST["email"]);
                }
            
                $lenght = strlenght($_POST["passwd"]);
                $passwd = validate_input($_POST["passwd"]);

                if(empty($_POST["passwd"])){
                    $perr = "Password Field Required...!";
                    $boolean  = false;
                }elseif($lenght){
                    $perr = $lenght;
                    $boolean  = false; 
                }
                
                if(empty($_POST["cpasswd"])){
                    $cperr = "Confirm Password Required...!";
                    $boolean  = false;
                }
                elseif($_POST["cpasswd"] !== $passwd){
                    $cperr = "Password Not Match...!";
                    $boolean  = false;
                }
                
                if(empty($_POST["fname"]) || empty($_POST["lname"])){
                    $fnerr = "First & Last Name Required...!";
                    $boolean  = false;
                }else{
                    $fname = validate_input($_POST["fname"]);
                    $lname = validate_input($_POST["lname"]);
                }
                
                if(empty($_POST["gender"])){
                    $gerr = "Gender Required...!";
                    $boolean  = false;
                }else{
                    $gender = validate_input($_POST["gender"]);
                }
                
                if(!isset($_POST["ck1"])){
                    $boolean  = false;
                }
            }

           
     
        function strlenght($str){
            $ln = strlen($str);
            if($ln > 15){
                return "Passwod should less than 15 charecter";
            }elseif($ln < 5 && $ln >= 2){
                return "Password should greater then 3 charecter";
            }
            return;
        }

            function validate_input($data){
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }


            if($booleans){
                $dbname = "RegistrationTest";
                $con = mysqli_connect("localhost","khangmai","1Kogajudo@4591",$dbname);
             
                if(!$con){
                    die("Connection Failed : " + mysqli_connect_error());
                }

                function newUser(){
                    $sql = "INSERT INTO Register(usrname,email,passwd,fname,lname,gender) Values
                    ('$_POST[username]','$_POST[email]','$_POST[passwd]','$_POST[fname]','$_POST[lname]','$_POST[gender]')";

                    $query = mysqli_query($GLOBALS['con'], $sql);

                    if($query){
                        echo "<script>
                            alert ('Record Inserted Successfully...!');
                        </script>";
                    }
                }

                function SignUP(){
                    $sql = "SELECT * FROM Register WHERE usrname = '$_POST[username]' AND email = '$_POST[email]'";
                    
                    $result = mysqli_query($GLOBALS['con'], $sql);
                    
                    if(!$row = mysqli_fetch_array($result)){
                        NewUser();
                    }else{
                        echo "<script>
                            alert ('You Are Already Registered User......!');
                        </script>";
                    }
                }
                
                if(isset($_POST["submit"])){
                    
                    SignUp();
                    mysqli_close($GLOBALS["con"]);
                    $post = false;
                }          
            }

        ?>

/*
                function isEmptyInput($data){

                    if(empty($_POST["$data"])){
                        return true;
                    }

                } // end isEmptyInput

                function checkUsername($data,$usrErr){
                    if(isEmptyInput($data)){
                        $usrErr = "Username Required...!";
                        return  false;
                    }
                    else{
                        return  true;
                    }
                } // end checkUsername

                function checkEmail($data,$emailErr){
                    if(isEmptyInput($data)){
                        $emailErr = "Email Required...!";
                        return  false;
                    }
                    elseif(!filter_var($data, FILTER_VALIDATE_EMAIL)){
                        $emailErr = "Invalid Email...!";
                        return false;
                    }
                    else{
                        return true;
                    }
                } // end checkEmail

                function checkPassword($data,$passErr){

                    if(isEmptyInput($data)){
                        $passErr = "Password Required...!";
                        return false;
                    }

                    $lengthOfPassword = strlen($data);
                    if($lengthOfPassword > 20){
                        $passErr = "Password should be less then 20 characters";
                        return false;
                    }
                    elseif($lengthOfPassword <= 4 || $lengthOfPassword = 0 ){
                        $passErr = "Password should be greater then 4 and cannot be 0 characters";
                        return false;
                    }
                    else{
                        return true;
                    }
                    
                } // end checkPassword
                */
