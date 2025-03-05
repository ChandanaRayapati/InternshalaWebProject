<?php

    session_start();
    //If the session 'isLogged' is not set, user will be redirected to Login page.
    if(!isset($_SESSION['isLogged'])){
        header("Location:LoginPHP.php");
    } 
    //Connection to Database.
    require 'ConnectiontoDB.php';
    
    //Checking if the expense date is in range of plan dates since some browsers
    //aren't supporting min-max features.
    function check_in_range($startdate, $enddate, $date){
        $start_ts = strtotime($startdate);
        $end_ts = strtotime($enddate);
        $user_ts = strtotime($date);
        // Checking that user date is between start & end
        return (($user_ts >= $start_ts) && ($user_ts <= $end_ts));
    }
                 
?>
<!DOCTYPE html>
<html>
    
    <head>
        <title>Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssviewplan.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    </head>
    
    <body>
       
        <?php
    
            //Including the Navigation bar and sidebar.
            $page='Newexpense';
            include 'Header_in.php';
            require 'SidenavPHP.php';
        ?>
        
        <div class="main_content">
            <div class="foralert">
        
         <?php 
    
            //Declaring variables
            $exerr1=$exerr2=$exerr3=$exerr4=$exerr="";
            $exptitle=$expdate=$personname=$target_path="";
            $amount=0;
            $ex1=$ex2=$ex3=$ex4=$ex5=0;
        
            //When add button is clicked, this if-loop is executed.
            if(isset($_POST['add'])){
            
              //Validating the form input fields->
              //If the field is left empty, then an error text is displayed next to the label.
             
                if(empty($_POST["exptitle"])){  
                    $exerr1=" *Enter Expense Name";
                }
                else{
                    $ex1=1;
                    $exptitle= $_POST['exptitle'];
                }
            
            
                if(empty($_POST["expdate"])){  
                    $exerr2=" *Date is Required";
                }
                else{
                   $result= check_in_range($_SESSION['fromdate'],$_SESSION['todate'], $_POST['expdate']);
                   if($result){
                    $ex2=1;
                   $expdate = $_POST['expdate'];}
                   else{
                       $exerr2=' *Date must lie in between plan dates: '.$_SESSION['fromdate']." to ".$_SESSION['todate'];
                   }
                }
            
            
                if(empty($_POST["amount"])){
                    $exerr3=" *Amount is Required";
                }
                elseif($_POST["amount"]<1){//Checking if amount entered is zero or negative.
                    $exerr3=" *Enter a Positive Amount";
                }
                else{
                    $ex3=1;
                    $amount = $_POST['amount'];
                }
                
                
                if($_POST['personname']=="NULL"){
                    $exerr4 =" *Select a Person";
                }
                else {
                    $ex4=1;
                    $personname = $_POST['personname'];   
                }
             
                //File is not compulsory, but if it is uploaded this if loop is executed.
                if (!empty($_FILES["image"]["name"])){
                
                    $file_name = $_FILES["image"]["name"];  
                    $temp_name = $_FILES["image"]["tmp_name"];  
                    $imgtype = $_FILES["image"]["type"];     
                    $ext = GetImageExtension($imgtype);
                    $imagename = date("d-m-Y")."-".time().$ext;        
                    $target_path = "img/".$imagename;
                
                    if(move_uploaded_file($temp_name, $target_path)){    
                        $ex5=1;  
                    }
                }
            }
            
            // Function to get the image type.   
            function GetImageExtension($imagetype){
                if(empty($imagetype)){return FALSE;}
                switch ($imagetype){
                    case 'image/bmp':return '.bmp';
                    case 'image/gif':return '.gif';
                    case 'image/jpeg':return '.jpg';
                    case 'image/png':return '.png';
                    default :return FALSE;    
                }
            }
        
             //When all the required fields are entered this if-loop is executed.
            if($ex1==1 && $ex2==1 && $ex3==1 && $ex4==1){
            
                //We obtain the corresponding plan id from the session variable.
                $planid=$_SESSION['planid']; 
                $query6= "INSERT INTO expenses(planid, titleexpense, expdate, paidby, amount, expfile) VALUES('$planid','$exptitle','$expdate','$personname','$amount','$target_path')";
                $query6_result= mysqli_query($con,$query6);
            
                //If the expense is successfully added then a success alert dialogbox is displayed and all the
                //input form fields are cleared. User is directed to Viewplan page.
                if($query6_result == TRUE){
                    $_POST = array();
                    echo '<div class="alert alert-success alert-dismissible" role="alert">';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '<strong>Expense successfully added !</strong>';
                    echo '</div>';
                    header("Refresh:2; url=ViewplanPHP.php");//I'm redirecting user to viewplan page after 3 seconds.
                }
                else{
                    //If the expense is not added to the db table, error alert dialogbox is displayed.
                    echo '<div class="alert alert-danger alert-dismissible" role="alert">' ;
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                    echo '<strong>Failed to add Expense!</strong>';
                    echo '<p> Check if all fields are in correct format.</p>';
                    echo '</div>'; 
                }    
            }  
         ?>
         </div>
         
         <?php
          
         //If money spent has already reached/exceeded the initial budget,
         //then I'm not allowing to make further expenses.
          if($_SESSION['moneyleft']==0 || $_SESSION['moneyleft']<0){
              
            $str="The total amount spent has already reached / exceeded the Initial Budget.";
            $str1="You cannot make any new expenses.";
            echo '<br>';
            echo "<div class='divhead'>$str</div>";
            echo "<div class='divhead'>$str1</div>";
          }
          else{
          ?>
        
            <!-- Panel to add new expense--> 
            <div id="newexpense" class="panel panel-default panelclass2">
                
                <div class="panel-heading"><strong>Add New Expense</strong></div>
                <div class="panel-body">
                 
                    <!-- Form to add new expense--> 
                    <form class="form-group" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                        
                        <label for="exptitle" >Title</label><span class="error"><?php echo $exerr1; ?></span>
                        <input type="text" class="form-control" maxlength="25" required  pattern="[A-Za-z0-9\s]{1,25}" title="Special Chars(@,#,%,&,! etc.) are not allowed!" name="exptitle" placeholder="Expense Name" value="<?php echo isset($_POST["exptitle"]) ? $_POST["exptitle"] :""; ?>">
                    
                    
                        <!-- Min and max attributes are set-these are from and to dates of the plan obtained from session variables -->
                        <label for="expdate">Date</label><span class="error"><?php echo $exerr2; ?></span>
                        <input type="date" required  min="<?=$_SESSION['fromdate']; ?>" max="<?=$_SESSION['todate']; ?>" class="form-control" name="expdate" placeholder="yyyy-mm-dd" value="<?php echo isset($_POST["expdate"]) ? $_POST["expdate"] :""; ?>">
                        
                        <label for="amount">Amount Spent</label><span class="error"><?php echo $exerr3; ?></span>
                        <input type="number" required  class="form-control" name="amount" placeholder="Amount Spent" value="<?php echo isset($_POST["amount"]) ? $_POST["amount"] :""; ?>">
                        
                        <label for="personname">Paid By:</label><span class="error"><?php echo $exerr4; ?></span>
                        <select name="personname"  class="form-control" required id="person" value="<?php echo ($_POST["personname"]=="NULL") ? "Choose" :$_POST["personname"]; ?>">
                    
                          <!-- All the group members' names are obtained from the session array 'peoplename'-->
                          <!-- The option tag is kept inside a for-loop to display all the names in the array-->
                        
                            <option value="NULL">Choose</option> 
                            <?php 
                                $array=$_SESSION['peoplename'];
                                if(count($array)>0){
                                    for($i=0;$i<count($array);$i++){  
                            ?> 
                        
                            <option ><?php echo $array[$i]; ?></option>   
                        
                           <?php
                            }}
                           ?>     
                        </select>
    
                        <label for="image">Upload Bill</label>
                        <input type="file" class="form-control" name="image" placeholder="Upload" >
                        
                        <input type="submit" name="add" class="button" value="Add">      
                    </form> 
                </div>
            </div> 
          <?php }  ?>
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





