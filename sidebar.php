<aside class="span3 page-sidebar">
  <?php if ($sUsername == null) : ?>
  <a href="#loginModal" data-toggle="modal" class="btn btn-dark btn-lg btn-block" role="button" aria-pressed="true">Ask a Question</a>
  <?php endif; ?>
  <?php if ($sUsername !== null) : ?>
  <a href="addquestion.php" class="btn btn-dark btn-lg btn-block" role="button" aria-pressed="true">Ask a Question</a>
  <?php endif; ?>
  </p>
  <section class="widget">
    <div class="support-widget">
      <h3>Support</h3>
      <p class="intro">Need more support? If you did not found an answer, contact us for further help.</p>
    </div>
  </section>
  <section class="widget">
    <div class="quick-links-widget">
      <h3>Quick Links</h3>
      <ul id="menu-quick-links" class="menu clearfix">
        <li><a href="index.html">Home</a></li>
        <li><a href="articles-list.html">Articles List</a></li>
        <li><a href="faq.html">FAQs</a></li>
        <li><a href="contact.html">Contact</a></li>
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
            echo "<a href='#' rel='tag' class='btn btn-dark'>".substr($q_tag,0,$i)."</a> ";
            $delete = substr($q_tag,0,$i+1);
            $q_tag = str_replace($delete,"",$q_tag);
            $i = -1;
          }
          else if($i == strlen($q_tag)-1){
            echo "<a href='#' rel='tag' class='btn btn-dark'>".substr($q_tag,0,$i+1)."</a>";
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

<script>
$(document).ready(function(){  
  $('#login_button').click(function(){  
    var email = $('#email_label').val();  
    var password = $('#password_label').val();
    var action = 1;
    if(email != '' && password != '')  
    {
      $.ajax({  
        url:"action.php",  
        method:"POST",  
        data: {email:email, password:password, action:action},  
        success:function(response){   
          if(response == '1')  
          {
            $('#loginModal').hide();
            window.location.replace("addquestion.php");    
          }  
          else if (response == '0') 
          {
            alert("Email and password does not match");  
            //location.reload();  
          }
          else if (response == '-1') 
          {
            alert("System-based error");  
            //location.reload();  
          }    
        }  
      });  
    }  
    else  
    {  
      alert("Both Fields are required");  
    }  
  });
});
</script>