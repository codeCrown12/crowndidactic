<nav class="navbar navbar-expand-lg navbar-light bg-white mynav">
    <div class="container-fluid">
      <a class="navbar-brand ms-lg-4" href="index?selector=<?php echo $schoolkey;?>"><img width="37" class="nav-logo" src="<?php echo "../MainDashboard/".$row_abt['profileimg'];?>" alt=""> <?php 
      if(strlen($row_abt['Name']) > 20){
          echo substr($row_abt['Name'],0,20)."...";
      }
      else echo $row_abt['Name']; 
      ?></a>
      <button class="navbar-toggler" id="nav-toggle" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span><i class="fas fa-bars"></i></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-lg-0">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="index?selector=<?php echo $schoolkey;?>">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about?selector=<?php echo $schoolkey;?>">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="gallery?selector=<?php echo $schoolkey;?>">Gallery</a>
          </li>
        </ul>
        <?php
        if ($row_abt['applications'] == "On") {
          echo "<a class='btn' style='background-color:$row_abt[backgroundColor]; border-color:$row_abt[backgroundColor]; color: $row_abt[TextColor]' href='applicationform?selector=$schoolkey'>Get Started</a>";
        }
        else {
          echo "<a class='btn' style='background-color:$row_abt[backgroundColor]; border-color:$row_abt[backgroundColor]; color: $row_abt[TextColor]' href='appdisabled?selector=$schoolkey'>Get Started</a>";
        }
        ?>
      </div>
    </div>
  </nav>