<?php
    if(!isset($_SESSION)) {

      session_start();

    }
?>
<nav class="navbar navbar-inverse navbar-fixed-top">
  <div class="container">
      <div class="navbar-header navbar-right">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="../index.php">محادثات</a>
      </div>
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
          <?php 

            if(isset($_SESSION['user_membership'])) {

              echo '<li class="dropdown">';
                  echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'. $_SESSION['user_membership'] .'<span class="caret"></span></a>';
                      echo '<ul class="dropdown-menu">';
                            echo '<li><a href="Profile.php">الملف الشخصي</a></li>';
                                  if(isset($_SESSION['User_Admin']) && $_SESSION['User_Admin'] == 1) {

                                    echo '<li><a href="dashboard.php">لوحة التحكم</a></li>';

                                  }
                            echo '<li><a href="../LoginOut.php">تسجيل الخروج</a></li>';
                      echo '</ul>';
              echo '</li>';

            }

          ?>
          <!-- <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">الغرف <span class="caret"></span></a>
            <ul class="dropdown-menu">
             <li>
                <a href="#"> ... </a>
             </li>
            </ul>
          </li> -->
        </ul>
      </div>
  </div>
</nav>