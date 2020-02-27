<aside class="span3 page-sidebar">
  <?php if ($sUsername == null) : ?>
  <a href="#loginModal" data-toggle="modal" class="button-wrap" role="button" aria-pressed="true">Ask a Question</a>
  <?php endif; ?>
  <?php if ($sUsername !== null) : ?>
  <a href="/addquestion.php" class="button-wrap" role="button" aria-pressed="true">Ask a Question</a>
  <?php endif; ?>
  </p>
  <section class="widget">
    <div class="support-widget">
      <h3>Support</h3>
      <p class="intro">Need more support? If you couldn't find what you are looking for, contact us for further assistance.</p>
    </div>
  </section>
  <section class="widget">
    <div class="quick-links-widget">
      <h3>Popular Articles</h3>
      <ul class="list-group list-group-flush">
        <?php 
          foreach (homeController::popularArticles() as $key) { 
          $popular_slug = $key['slug']; 
        ?>
        <li class="list-group-item"><a href='<?php echo "/post/$popular_slug";?>'><?php echo $key["q_title"]?></a></li>
        <?php } ?>
      </ul>
    </div>
  </section>
  </p>
  <?php if (isset($slug)) : ?>
  <section class="widget">
    <div class="tags-widget">
      <h3 >Tags</h3><br>
      <div class="tagcloud">
      <?php 
        $tagCount = substr_count($q_tag,",")+1;
        $i = 0;
        while(isset($q_tag[$i]) && $q_tag[$i] != null){
          if($q_tag[$i] == ','){
            echo "<a href='/tag/".substr($q_tag,0,$i+1)."' rel='tag' class='btn btn-dark'>".substr($q_tag,0,$i)."</a> ";
            $delete = substr($q_tag,0,$i+1);
            $q_tag = str_replace($delete,"",$q_tag);
            $i = -1;
          }
          else if($i == strlen($q_tag)-1){
            echo "<a href='/tag/".substr($q_tag,0,$i+1)."' rel='tag' class='btn btn-dark'>".substr($q_tag,0,$i+1)."</a>";
            $delete = substr($q_tag,0,$i+1);
            $q_tag = str_replace($delete,"",$q_tag);
            $i = -1;
          }
          $i++;
        }
      ?>                    
      </div>
    </div>
  </section>
  <?php endif; ?>
</aside>
