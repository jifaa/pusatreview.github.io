<div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1" id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel" style="background-color: #45f3ff;">
  <div class="offcanvas-header" style="background-color: #28292d">
    <button type="button" class="btn-close ms-1" data-bs-dismiss="offcanvas" aria-label="Start"></button>
    <h3 class="offcanvas-title" id="offcanvasWithBothOptionsLabel" style="margin-left: 30%; color: #45f3ff"><strong>Profile</strong></h3>
    <svg xmlns="http://www.w3.org/2000/svg" 
     width="50" 
     height="50" 
     fill="#45f3ff" 
     class="bi bi-person-circle icon-hover"
     viewBox="0 0 16 16" 
     data-bs-toggle="offcanvas" 
     data-bs-target="#offcanvasWithBothOptions" 
     aria-controls="offcanvasWithBothOptions"
     style="margin-left: 23%;">
     <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
     <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
</svg>
  </div>
  <div class="offcanvas-body">
    <h5><?php if (isset($_SESSION['username'])): ?>
    <span><?php echo htmlspecialchars($_SESSION['username']); ?></span>
    <?php else: ?>
    <a href="login.php">Login</a>
    <?php endif; ?></h5>
    <a href="logout.php" class="btn btn-danger">Logout</a>
  </div>
</div>