<!-- Site footer -->
<footer class="site-footer">
        <div class="container">
          <div class="row">
            <div class="col-sm-12 col-md-6">
              <h6>Our mission</h6>
              <p class="text-justify">Our objective is to provide a platform for learners and learning/training institutions to interact, bridging the gap between them. Also, to make education and skill development accessible to learners/students throughout Africa and beyond.</p>
            </div>
  
            <div class="col-xs-6 col-md-3">
              <h6>Categories</h6>
              <ul class="footer-links">
                <li><a href="searchSchool?cat=Science and Technology"> Science and Technology</a></li>
                <li><a href="searchSchool?cat=Fashion and Design">Fashion & Design</a></li>
                <li><a href="searchSchool?cat=Music">Music</a></li>
                <li><a href="searchSchool?cat=Software Development">Software Development</a></li>
                <li><a href="searchSchool?cat=Arts and Media">Arts and Media</a></li>
              </ul>
            </div>
  
            <div class="col-xs-6 col-md-3">
              <h6>Quick Links</h6>
              <ul class="footer-links">
                <li><a href="about">About Us</a></li>
                <li><a href="contact">Contact Us</a></li>
                <li><a href="explore">Explore</a></li>
                <li><a href="register">Sign up</a></li>
              </ul>
            </div>
          </div>
          <hr>
        </div>
        <div class="container">
          <div class="row">
            <div class="col-md-8 col-sm-6 col-xs-12">
              <p class="copyright-text">Copyright &copy; 2021 All Rights Reserved Crowndidactic.
              </p>
            </div>
            <?php
            include 'connection.php';
            $query = "SELECT facebook, twitter, instagram, linkedin FROM site_info";
            $result = $connection->query($query);
            if(!$result){
                $emailConfirm = "Error in connection";
            }
            else{
                $linkrow = $result->fetch_array(MYSQLI_ASSOC);
            }
            
            ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
              <ul class="social-icons">
                <!--<li><a class="facebook" href="" target="_blank"><i class="fa fa-facebook"></i></a></li>-->
                <li><a class="twitter" href="<?php echo $linkrow['twitter'] ?>" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <!--<li><a class="dribbble" href="" target="_blank"><i class="fa fa-instagram"></i></a></li>-->
                <li><a class="linkedin" href="<?php echo $linkrow['linkedin'] ?>" target="_blank"><i class="fa fa-linkedin"></i></a></li>   
              </ul>
            </div>
          </div>
        </div>
  </footer>
<script src="scripts/main.js"></script>   
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>