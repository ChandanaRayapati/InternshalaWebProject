<?php

    session_start();
    //User will be directed to Loginpage if he/she has logged out.
    if(!isset($_SESSION['isLogged'])){
        header("Location:LoginPHP.php");
    }
    //Connection to Database
    require 'ConnectiontoDB.php';
    
    //Function to check if its a valid date or not.
    //since Date has to be entered manually in some browsers.
    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        // The Y ( 4 digits year ) returns TRUE for any integer with any number of digits so changing the comparison from == to === fixes the issue.
        return $d && $d->format($format) === $date;
    }
    
    //Checking that to-date is after from-date.
    function check_from_to($startdate, $enddate){
        $start_ts = strtotime($startdate);
        $end_ts = strtotime($enddate);
        // Checking that todate is after from date.
        return ($end_ts >= $start_ts);
    }

?>

<!DOCTYPE html>
<html>
    
    <head>
        <title>Create New Plan | Control Budget</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        
        <link rel="stylesheet" type="text/css" href="stylesheets/cssaddplan.css?<?php echo time(); ?>">
        
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>
       
        <?php
            //Including Navigation bar
            $page='Newplan';
            include 'Header_in.php';
        ?>
        <div class="details">
        <?php
            //Declaring variables
            $nperr1=$nperr2=$nperr3="";
            $title=$from=$to="";
            $person=array();
            $nperr4=array();
            $d=array();
            $a=$b=$c=0;
            $loop=$_SESSION['ppl'];
            $te=0;
            while ($te < $loop){
                array_push($nperr4,"");
                array_push($d,0);
                $te=$te+1;
            }
  
            //Validations are made->
            //If the field is left empty, then an error text is displayed next to the label.
            if(isset($_POST['submit'])){
                
                if(empty($_POST['title'])){
                    $nperr1=" *Enter the Title" ;
                }
                else {
                    $a=1;
                    $title= mysqli_real_escape_string($con,$_POST['title']);
                }
            
            
                if(empty($_POST['from'])){
                    $nperr2=" *Enter From date" ;
                }
                else {
                    $res1=validateDate($_POST['from']);
                    if($res1){
                        $b=1;
                        $from= $_POST['from'];
                    }
                    else{
                       $nperr2=" *Enter valid From date(yyyy-mm-dd)" ; 
                    }
                }
            
                
                if(empty($_POST['to'])){
                    $nperr3=" *Enter To date" ;
                }
                else {
                    
                    $res1=validateDate($_POST['to']);
                    if($res1){
                        $c=1;
                        $to= $_POST['to'];
                    }
                    else{
                       $nperr3=" *Enter valid To date(yyyy-mm-dd)" ; 
                    }
                }
            
                
                $t=0;
                foreach ($_POST["person"] as $value) {
     
                    if(empty($value)){
                        $q=$t+1;
                        $nperr4[$t]=" *Enter Person $q Name" ;
                    }
                    else {
                            $nperr4[$t]="" ; 
                            $d[$t]=1;
                            $data = $value;
                            $person[$t] =$data; 
                    }
                    $t=$t+1;    
                }     
            }
        
            
            if($a==1 && $b==1 && $c==1){
                $e=0;
                if(!check_from_to($_POST['from'], $_POST['to'])){
                    $nperr3=" *To date must be after From date!";     
                }
                else{
                    for($f=0;$f<count($d);$f=$f+1){//Ensuring all the persons' names are entered.
                        if($d[$f]== 0){
                            $e=0;
                            break;
                        }else {
                            $e=1;
                        }
                    }
                 if($e==1){ //When all the required fields are entered this if-loop is executed.
                    
                    //serializing the array with person names to store it in a single column in Database.
                    $serialarray= serialize($person);
                    $email= $_SESSION['email'];
                    $budget=$_SESSION['ib'];
                    $peopleno=$_SESSION['ppl'];
                
                    $query3="INSERT INTO plans(email,title,fromdate,todate,budget,peopleno,peoplename)"
                        ." VALUES('$email','$title','$from','$to','$budget','$peopleno','$serialarray')";
                
                    $query3_result= mysqli_query($con, $query3)or die(mysqli_error($con));
                
                    //If the plan is successfully created,a success alert is 
                    //displayed and user is directed to Dashboard.
                    if($query3_result){
                        $_POST = array();
                        echo '<div class="alert alert-success alert-dismissible" role="alert">';
                        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
                        echo '<strong>Plan successfully created !</strong>';
                        echo '</div>';
                        header("Refresh:2; url=DashboardPHP.php");
                         
                    }else {  //If creating plan is unsuccessful, js alert is displayed.
                        echo "<script type='text/javascript'> alert('Some Error Occured! Try again.');</script>";
                        
                    }   
                }
            }}
        ?>
        </div>
     

        <!-- Panel for adding details of the plan.-->
            <div class="panel panel-default newplanclass">
                <div class="panel-heading" ><strong >Plan Details</strong></div>
                <div class="panel-body">
                
                    <form class="form-group" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >

                        <label for="title">Title</label><span class="error"><?php echo $nperr1;?> </span>
                        <input type="text" class="form-control" maxlength="20" required  pattern="[A-Za-z0-9\s]{1,20}" name="title" placeholder="Enter title (Ex. Trip to Goa)"  value="<?php echo isset($_POST["title"]) ? $_POST["title"] :""?>" title='Special Chars(@,#,%,&,! etc.) are not allowed!'>      
               
                        <div class="row">    
                            <div class="col-xs-6 ">
                                <label for="from">From</label><span class="error"><?php echo $nperr2;?> </span>
                                <input type="date" min="2020-07-01"  required  class="form-control" name="from" placeholder="yyyy-mm-dd" value="<?php echo isset($_POST["from"]) ? $_POST["from"] :""?>">
                            </div>   
                            <div class="col-xs-6 ">
                                <label for="to">To</label><span class="error"><?php echo $nperr3;?> </span>
                                <input type="date" min="2020-07-02" required  class="form-control" name="to" placeholder="yyyy-mm-dd" value="<?php echo isset($_POST["to"]) ? $_POST["to"] :""?>">
                            </div>        
                        </div> 
                        
                        <!--The session variables are obtained from previous page AddplanPHP -->
                        <div class="row">    
                            <div class="col-xs-7 ">
                                <label for="ib">Initial Budget</label>
                                <input type="number" class="form-control" name="ib" disabled placeholder="<?php echo $_SESSION['ib'];?>">
                            </div>    
                            <div class="col-xs-5">
                                <label for="ppl">No. of people</label>
                                <input type="number" class="form-control" name="ppl" disabled placeholder="<?php echo $_SESSION['ppl'];?>">
                            </div>       
                        </div> 
                            
                        <?php
                          
                            $temp=0;//This loop displays input fields equal to no. of persons in the group.
                            while ($temp < $loop)
                            {?>
                            
                            <label for="person[]">Person <?php echo $temp+1; ?></label><span class="error"><?php echo $nperr4[$temp];?> </span>
                            <input type="text" class="form-control" required  maxlength="15" pattern="[A-Za-z0-9\s]{1,15}" title="Special Chars(@,#,%,&,! etc.) are not allowed!" name="person[]" placeholder="Person <?php echo $temp+1; ?> Name" value="<?php echo isset($_POST["person"][$temp])? $_POST["person"][$temp]:"" ;?>">  
                            <?php
                           
                            $temp=$temp+1;
                            }
                        ?>
                         
                        <!--When submit button is clicked, validations are made.-->
                        <input type="submit" name="submit" class="button" value="Submit">
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





