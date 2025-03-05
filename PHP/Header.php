<!--responsive navigation bar( This is visible when user has NOT logged in)-->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="IndexPHP.php">CT₹L Budget</a>    
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">  
                <ul class="nav navbar-nav navbar-right">
                    <li class="<?php if($page=='About'){echo 'active';}  ?>"><a href="About_out.php"><span class="glyphicon glyphicon-info-sign "></span> About Us</a></li>
                    <li class="<?php if($page=='Signup'){echo 'active';}  ?>"><a href="SignupPHP.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li class="<?php if($page=='Login'){echo 'active';}  ?>"><a href="LoginPHP.php"><span class="glyphicon glyphicon-log-in"></span> Log in</a></li>
                </ul>
            </div>
        </div>   
    </nav>
                       
