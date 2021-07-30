<footer class="site-footer">
        <div class="container">
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <h6>About</h6>
              <p class="text-justify"><?php if(strlen($row_abt['about']) > 300){
                        echo "<p>".substr($row_abt['about'], 0, 200)."..."."</p>";
                        // echo "<p><a href='#' class='btn btn-md btn-outline-dark'>View more &rsaquo;&rsaquo;</a></p>";
                      }
                      else{
                        echo $row_abt['about'];
                      } 
                      ?></p>
            </div>
  
            <div class="col-xs-6 col-md-3">
              <h6>Help</h6>
              <ul class="footer-links">
                <li><a href="index?selector=<?php echo $schoolkey;?>#faqs">FAQs</a></li>
                <li><a href="index?selector=<?php echo $schoolkey;?>#contactus">Contact Us</a></li>
              </ul>
            </div>
  
            <div class="col-xs-6 col-md-3">
              <h6>Quick Links</h6>
              <ul class="footer-links">
                <li><a href="about?selector=<?php echo $schoolkey;?>">About Us</a></li>
                <li><a href="gallery?selector=<?php echo $schoolkey;?>">Gallery</a></li>
                <li><a href="applicationform?selector=<?php echo $schoolkey;?>">Apply</a></li>
              </ul>
            </div>
          </div>
          <hr>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-12">
              <p class="copyright-text">Copyright &copy; 2021 All Rights Reserved by 
           <a href="index?selector=<?php echo $schoolkey;?>" style="text-decoration: none;"><?php echo $row_abt['Name']; ?></a>.
              </p>
            </div>
  
            <div class="col-md-4 col-sm-6 col-xs-12">
              <ul class="social-icons">
                <?php
                if ($row_abt['facebook'] != "facebook link") {
                  echo "<li><a class='facebook' href='$row_abt[facebook]' target='_blank'><i class='fa fa-facebook'></i></a></li>";
                }
                
                if($row_abt['instagram'] != "instagram link"){
                  echo "<li><a class='dribbble' href='$row_abt[instagram]' target='_blank'><i class='fa fa-instagram'></i></a></li>";
                }
                
                if($row_abt['twitter'] != "twitter link"){
                  echo "<li><a class='twitter' href='$row_abt[twitter]' target='_blank'><i class='fa fa-twitter'></i></a></li>";
                }
                
                if ($row_abt['linkedin'] != "linkedIn link") {
                  echo "<li><a class='linkedin' href='$row_abt[linkedin]' target='_blank'><i class='fa fa-linkedin'></i></a></li>";
                }
                ?> 
              </ul>
            </div>
          </div>
        </div>
  </footer>