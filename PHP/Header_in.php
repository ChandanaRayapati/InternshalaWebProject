<!--responsive navigation bar( This is visible when user has logged in)-->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand"  href="DashboardPHP.php" >CT₹L Budget</a>    
        </div>
        <div class="collapse navbar-collapse" id="myNavbar"> 
                    
            <ul class="nav navbar-nav navbar-left">
                <li class="<?php if($page=='Dashboard'){echo 'active';} ?>">
                <a href="DashboardPHP.php"><span class="glyphicon glyphicon-home"></span> Dashboard</a></li>
                <li class="<?php if($page=='Profile'){echo 'active';} ?>">
                 <a href="Profile.php"><span class="glyphicon glyphicon-user"></span> My Profile</a></li>
            </ul>
                   
            <ul class="nav navbar-nav navbar-right">
                <li class="<?php if($page=='About'){echo 'active';}  ?>"><a href="About_in.php"><span class="glyphicon glyphicon-info-sign "></span> About Us</a></li>
                <li class="<?php if($page=='ChangePassword'){echo 'active';}  ?>"><a href="ChangepasswordPHP.php"><span class="glyphicon glyphicon-cog"></span> Change Password</a></li>
                <li class="logout"><a href="LogoutPHP.php" onclick="return confirm('Are you sure you want to Logout?')"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                <!--I will confirm once again from user using confirm() when logout is pressed.-->
            </ul>
        </div>
    </div>   
</nav>

