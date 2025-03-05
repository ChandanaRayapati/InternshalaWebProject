<?php
    session_start();
    //If the session 'isLogged' is not set, user will be redirected to Login page.
        if(!isset($_SESSION['isLogged']))
        {
            header("Location:LoginPHP.php");
        }
        
    //Connection to database
    $con9= mysqli_connect("localhost","root","","project") or die(mysqli_error($con9));
    $email=$_SESSION['email'];
    $query9 = "SELECT pwd FROM users WHERE email='$email'";
    $query9_result=mysqli_query($con9,$query9) or die(mysqli_error($con9));
    $result= mysqli_fetch_array($query9_result);
?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>Change Password | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssindex.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    </head>
    
    <body>
       
        <?php
        //Including the navigation bar
        $page='ChangePassword';
        include 'Header_in.php';
        ?>
        <div class="foralert">  
        <?php   
        
        $oldpwd=$newpwd=$cnewpwd="";
        $pwderr1=$pwderr2=$pwderr3="";
        $pwd1=$pwd2=$pwd3=0;
        
        //When change button is clicked this if-loop is executed.
        if(isset($_POST['submit']))
        {
                    
            //Validating the form input fields->
            //If the field is left empty, then an error text is displayed next to the label.
            if(empty($_POST['oldpwd'])){
                $pwderr1=" *Old Password Required";
            }
            elseif (md5($_POST['oldpwd']) !== $result['pwd']) {//If old password is incorrect.
                echo '<div class="alert alert-danger alert-dismissible" role="alert">' ;
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                echo '<strong>Wrong Old Password!</strong>';
                echo '</div>';
            }
            else{
                $pwd1=1;
                $oldpwd= $_POST['oldpwd'];
            }
            
            
            if(empty($_POST['newpwd']))
            {
                $pwderr2=" *New Password Required";
            }
            else{
                $pwd2=1;
                $newpwd=$_POST['newpwd'];
            }
            
            
            if(empty($_POST['cnewpwd']))
            {
                $pwderr3=" *Confirm New Password";
            }
            else{
                $pwd3=1;
                $cnewpwd=$_POST['cnewpwd'];
            }    
        }
        
        //When all the fields are entered this if-loop is executed.
        if($pwd1==1 && $pwd2==1 && $pwd3==1)
        {
            //If the new passwords don't match then an alert dialogbox is displayed.
            if(strcmp($newpwd,$cnewpwd) !== 0){
                
                echo '<div class="alert alert-danger alert-dismissible" role="alert">' ;
                echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                echo '<strong>Passwords do not match!</strong>';
                echo '</div>';
            }
            else{
                $pwd= md5($newpwd);//Encrypting the new password using md5().
                $query10="UPDATE users SET pwd='$pwd' WHERE email='$email'";
                $query10_result=mysqli_query($con9,$query10) or die(mysqli_error($con9));
                
                
                //If the password is successfully changed then a success alert dialogbox is displayed.
                if($query10_result){
                    $_POST=array();
                    echo '<div class="alert alert-success alert-dismissible" role="alert">' ;
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '<strong>Password successfully changed!</strong>';
                    echo '</div>';
                    header("Refresh:2; url=DashboardPHP.php");
                }
                else{
                    //If an error occurs then an error alert dialogbox is displayed.
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">' ;
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '<strong>Some error occured! Try again later.</strong>';
                    echo '</div>';    
                }
            }                 
        }
        ?>
        </div> 
        <!--Panel for changing password-->
        <div class="panel panel-default panelclasscp">
                
            <div class="panel-heading" ><strong >Change Password</strong></div>
            <div class="panel-body">
                    
                <!--Form for changing password-->
                <form class="form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        
                    <label for="oldpwd">Old Password</label><span class="error"><?php echo $pwderr1; ?></span>
                    <input type="password" class="form-control" required name="oldpwd" placeholder="Enter Old Password" value="<?php echo isset($_POST['oldpwd']) ? $_POST['oldpwd'] :"" ; ?>" >
                        
                    <label for="newpwd">New Password</label><span class="error"><?php echo $pwderr2; ?></span>
                    <input type="password" class="form-control" required  minlength="6" name="newpwd" placeholder="New Password (Min. 6 characters)" value="<?php echo isset($_POST['newpwd']) ? $_POST['newpwd'] :"" ; ?>">
                        
                    <label for="cnewpwd">Confirm New Password</label><span class="error"><?php echo $pwderr3; ?></span>
                    <input type="password" class="form-control" required  minlength="6" name="cnewpwd" placeholder="Re-type New Password" value="<?php echo isset($_POST['cnewpwd']) ? $_POST['cnewpwd'] :"" ; ?>">
                        
                    <input type="submit"  name="submit" class="button" value="Change">
                    <span class="error"><?php echo ""; ?></span>
                </form> 
            </div>
        </div>

        
                    
        <!--footer-->
        <div class="footer">
            <!-- Copyright -->
            <div ><tt>Copyright © Control Budget
                    All Rights Reserved|Contact Us: +91-8448444853.</tt>
            </div>     
        </div>
    </body>
</html>




