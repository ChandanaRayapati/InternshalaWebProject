<?php

    session_start();
    //Connection to Database.
    require 'ConnectiontoDB.php';  
?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>Sign Up | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssindex.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    
    <body>
        
        <?php
            //Including Navigation bar
            $page='Signup';
            include 'Header.php';
        ?>
        
        <?php
            //Declaring variables.
            $nameerr=$emailerr=$pwderr=$numerr=$err=$generr="";
            $name=$email=$pwd=$mobile=$gender="";
            $n=$e=$p=$m=$g=0;
        
            //Validations are made->
            //If any of the fields are empty, error messages are shown next to labels.
            if(isset($_POST["submit"])){
                
                if(empty($_POST['name'])){
                    $nameerr=" *Name is required" ;
                }
                elseif(strlen($_POST['name'])>25){
                    $nameerr=" *Maximum of 20 characters" ;
                }
                else{
                    $name =$_POST['name'];
                    $n=1;
                }
            
            
                if(empty($_POST['email'])){
                    $emailerr="*Email is required" ;
                }
                else {
                    $email = $_POST['email'];
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){//Checking if it is valid or not.
                        $emailerr = "Invalid email format"; }
                    else{
                        $e=1;
                        $email = $_POST['email'];
                    }
                }
            
            
                if(empty($_POST['pwd'])){
                    $pwderr=" *Password is required" ;
                }
                elseif (strlen($_POST['pwd'])<6) {
                    $pwderr=" *Password must have atleast 6 characters" ;
                }
                else{
                    $p=1;
                    $pwd=md5($_POST['pwd']);//Encrypting the entered password.
                }

                
                if(empty($_POST['mobile'])){              
                    $numerr=" *Phone Number is required" ;
                }
                else {
                    if(strlen($_POST['mobile'])<10 || strlen($_POST['mobile'])>10){
                        $numerr=" *Invalid Phone Number";
                    }
                    elseif($_POST['mobile']<0){
                        $numerr=" *Invalid Phone Number";
                    }
                    else{
                        $mobile=$_POST['mobile'];
                        $mobileregex = "/^[6-9][0-9]{9}$/" ;
                        if(!preg_match($mobileregex, $mobile)){
                           $numerr=" *Invalid Indian Phone Number"; 
                        }
                        else{
                            $mobile=$_POST['mobile'];                       
                            $m=1;
                        }
                    }
                }
                
                if(empty($_POST['gender'])){
                    $generr=" *Please select a gender.";
                }
                else{
                    $g=1;
                    $gender=$_POST['gender'];
                }
            }
        
            //When all the required fields are entered this if-loop is executed.
            if($n==1 && $e==1 && $p==1 && $m==1 && $g==1){
                
                $query1="SELECT email,pwd FROM users WHERE email='$email'";
                $query1_result=mysqli_query($con,$query1) or die(mysqli_error($con));
            
                if(!$query1_result){
                    echo "<script type='text/javascript'>alert('Some error occured. Try again later.');</script>";
                }
                else{
                    $rowlen= mysqli_num_rows($query1_result);
                    if($rowlen>0){//If this email is already registered, this alert box is dispayed.
                        echo "<script type='text/javascript'> alert('An account already exists with this Email');</script>";
                    }
                    elseif($rowlen==0){

                        $con1= mysqli_connect("localhost","root","","project")  or die(mysqli_error($con1));
                        $query11="INSERT INTO users(name,email,pwd,mobile,gender) VALUES('$name','$email','$pwd','$mobile','$gender')";
                        $query11_result= mysqli_query($con1, $query11) or die(mysqli_error($con1));
            
                        //If user is successfully registered, an alert dialog box is displayed and
                        // user is directed to Dashboard page after setting session variables.
                        if($query11_result){ 
                            $_SESSION['email']=$email;
                            $_SESSION['name']=$name;
                            $_SESSION['mobile']=$mobile;
                            $_SESSION['gender']=$gender;
                            $_SESSION['isLogged']="TRUE";
                            echo "<script type='text/javascript'>alert('Account successfully created.Logging in..');</script>";
                            echo "<script type='text/javascript'> location.href='DashboardPHP.php';</script>";  
                        } 
                        else{
                            echo "<script type='text/javascript'>alert('Some error occured. Try again later.');</script>";    
                        } 
                    }
                }            
            }
        ?>
                 
        <!--Sign Up panel-->
        <div class="panel panel-default panelclass" style="top: 50%;transform: translate(-50%, -50%);"> 
            <div class="panel-heading"><strong>Sign Up</strong></div>
                
            <div class="panel-body">
                <!--Form for Signing Up-->
                <form method="post" class="form-group" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        
                    <label for="name">Name:</label><span class="error"> <?php echo $nameerr; ?></span>
                    <input type="text" class="form-control" name="name" required placeholder="Name" maxlength="25"  pattern="[A-Za-z0-9\s]{1,25}" title="Special Chars(@,#,%,&,! etc.) are not allowed!"  value="<?php echo isset($_POST["name"]) ? $_POST["name"] :""?>">
                        
                    <label for="email">E-mail:</label> <span class="error"> <?php echo $emailerr; ?></span>
                    <input type="email"  class="form-control" name="email" required  placeholder="Enter Valid Email" value="<?php echo isset($_POST["email"]) ? $_POST["email"] :""?>">
                        
                    <label for="pwd">Password:</label><span class="error"> <?php echo $pwderr; ?></span>
                    <input type="password" class="form-control" minlength="6" name="pwd" required  placeholder="Enter Password (Min. 6 characters)" value="<?php echo isset($_POST["pwd"]) ? $_POST["pwd"] :""?>">
                        
                    <label for="mobile">Phone Number:</label><span class="error"> <?php echo $numerr; ?></span>
                    <input type="tel" class="form-control" minlength="10" maxlength="10" name="mobile" required  placeholder="Enter Valid Phone Number (Ex:9848296872)" value="<?php echo isset($_POST["mobile"]) ? $_POST["mobile"] :""?>">

                    <!--Based on gender I will be displaying user image on profile page.-->
                       
                    <label for="mobile">Gender:</label>
                    <input type="radio" name="gender" required  value="M"> <label for="M"> Male </label> 
                    <input type="radio" name="gender" required  value="F"> <label for="F"> Female </label>
                    <input type="radio" name="gender" required  value="O"> <label for="O"> Other </label><br>
                    <span class="error"> <?php echo $generr; ?></span>
   
                    <input type="submit" class="button" name = "submit" value = "Sign Up">
                </form>  
            </div>
        </div>
       
       
        <!--footer-->
        <div class="footer col-xs-12">
            <!-- Copyright -->
            <div ><tt>Copyright © Control Budget
                    All Rights Reserved|Contact Us: +91-8448444853.</tt>
            </div>       
        </div>
    </body>
</html>


