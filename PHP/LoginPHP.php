<?php
    session_start();
    //If the session 'isLogged' is set, user will be redirected to Dashboard page.
    if(isset($_SESSION['isLogged'])){
        header("Location:DashboardPHP.php");
    } 
    //Connection to Database.
    require 'ConnectiontoDB.php';
?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>Login | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssindex.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
        
        <?php
            //Including Navigation bar
            $page='Login';
            include 'Header.php';
        ?>
        
        <?php   
            //Declaring variables
            $emaill=$pwdl="";
            $err1=$err2="";
            $el=$pl=0;
        
            //Validations are made->
            //If any of the fields are empty, error messages are shown next to labels.
            if(isset($_POST['submit'])){
            
                if(empty($_POST["emaill"])){
                    $err1=" *Registered Email Required";
                }
                else{
                    $emaill= $_POST["emaill"];
                    if(!filter_var($emaill, FILTER_VALIDATE_EMAIL)) {
                        $err1 = "Invalid email format"; }
                    else{ $el=1;} 
                }
            
                if(empty($_POST["pwdl"])){
                    $err2=" *Password Required";
                }
                else{
                    $pl=1;
                    $pwdl=$_POST["pwdl"];
                }
            }
        
             //When all the required fields are entered this if-loop is executed.
            if($el==1 && $pl==1){
               
                $query2="SELECT name,email,pwd,mobile,gender FROM users WHERE email='$emaill'";
                $query2_result=mysqli_query($con,$query2) or die(mysqli_error($con));
            
                if($query2_result==FALSE){
                    echo "<script type='text/javascript'> alert('Some error occured. Try again later.');</script>";
                }
                else{
                $row_len= mysqli_num_rows($query2_result);
                    if($row_len==0){
                        //If the entered email is not registered, this alertdialog box is displayed.
                        echo "<script type='text/javascript'> alert('User does not exist!');</script>";
                    }
                    elseif($row_len==1){
                    
                        $row= mysqli_fetch_array($query2_result);
                        if($row['pwd']== md5($pwdl)){
                            
                            //When the password entered is correct, session variables are set and 
                            //user is taken to Dashboard page.
                            $_SESSION['email']=$row['email'];
                            $_SESSION['name']=$row['name'];
                            $_SESSION['gender']=$row['gender'];
                            $_SESSION['mobile']=$row['mobile'];
                            $_SESSION['isLogged']="TRUE";
                            echo "<script type='text/javascript'> location.href='DashboardPHP.php';</script>";                      
                        }
                        else{
                            //When password entered is wrong, alert box is displayed.
                            echo "<script type='text/javascript'> alert('Wrong Password!');</script>";
                        }
                    }
                }            
            } 
        ?>
         
       <!--login panel-->
           
        <div class="panel panel-default panelclass">     
            <div class="panel-heading"><strong>Login</strong></div> 
            <div class="panel-body">
                    
                <form class="form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        
                    <label for="email">Email Address:</label><span class="error"><?php echo $err1; ?></span>
                    <input type="email" name="emaill" class="form-control" required  placeholder="Enter Email Address" value="<?php echo isset($_POST["emaill"]) ? $_POST["emaill"] :""?>">
                        
                    <label for="pwd1">Password:</label><span class="error"><?php echo $err2; ?></span>
                    <input type="password" name="pwdl" class="form-control" required placeholder="Enter Password">
                        
                    <input type="submit" name="submit" class="button" value="Login">
                </form> 
                   
                <!--If this link is clicked, user is taken to Sign Up page.-->
                <div><h4> Don't have an account?<a href="SignupPHP.php" style="color:blue;">
                    Click here to Sign Up </a></h4>
                </div>
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

