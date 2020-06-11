        <footer id="footer" class="footer-1">
            <div class="main-footer widgets-dark typo-light">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="widget2 subscribe no-box">
                                <h5 class="widget-title2">AI Customer Support<span></span></h5>
                                <p>Customer support with AI Technology</p>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="widget2 no-box">
                                <h5 class="widget-title2">Quick Links<span></span></h5>
                                <ul class="thumbnail-widget">
                                    <li>
                                        <div class="thumb-content"><a href="/addquestion.php">Add Question</a></div>	
                                    </li>
                                    <li>
                                        <div class="thumb-content"><a href="/login.php">Login</a></div> 
                                    </li>
                                    <li>
                                        <div class="thumb-content"><a href="/register.php">Register</a></div> 
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="widget2 no-box">
                                <h5 class="widget-title2">Popular Articles<span></span></h5>
                                  <ul>
                                    <?php
                                      $popularArticles = Functions::popularArticles();
                                      foreach ($popularArticles as $key) { 
                                      $popular_slug = $key['slug']; 
                                    ?>
                                    <li><a href='<?php echo "/post/$popular_slug";?>'><?php echo $key["q_title"]?></a></li>
                                    <?php } ?>
                                  </ul>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="widget2 no-box">
                                <h5 class="widget-title2">Contact Us<span></span></h5>
                                <p>If you need more help, please feel free to contact us!</p>
                                <p><a href="mailto:info@domain.com" title="glorythemes">example@example.com</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <p>Copyright AI Customer Support © 2019. All rights reserved.</p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>