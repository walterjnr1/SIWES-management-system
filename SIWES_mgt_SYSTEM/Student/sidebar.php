<div class="main-nav">
    <nav> 
      <!-- Menu Toggle btn-->
      <div class="menu-toggle">
        <h3>Menu</h3>
        <button type="button" id="menu-btn"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <!-- Responsive Menu Structure--> 
      <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
      <ul id="respMenu" class="ace-responsive-menu" data-menu-style="horizontal">
        <li><a href="index.php"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a>
            </li>
			<li><a href="upload-siwes.php"><i class="fa fa-home"></i> <span>Uploads</span></a>
            </li>
			
        <li><a href="#"><i class="fa fa-user"></i> <span>Profile</span></a>
          <ul>
            <li><a href="profile.php">View/Edit Profile</a></li>
			<li><a href="profile-photo.php">Edit Photo</a></li>
       
          </ul>
        </li>
	<li><a href="#"><i class="fa fa-cog"></i> <span>Setting</span></a>
          <ul>
            <li><a href="change-siwes.php">Change SIWES</a></li>
                   <li><a href="changepassword.php">Change Password</a></li>

          </ul>
        </li>
		<li><a href="../index.php"><i class="fa fa-exchange"></i> <span>Visit Website</span></a>
        
        	<li><a href="logout.php"><i class="fa fa-lock"></i> <span>logout</span></a>
            </li>
	
      </ul>
    </nav>
  </div>