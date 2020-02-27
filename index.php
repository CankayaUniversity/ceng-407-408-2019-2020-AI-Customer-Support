<?php include "header.php";?>
    <div class="search-area-wrapper">
        <div class="search-area container">
            <h3 class="search-header">Have a Question?</h3>
            <p class="search-tag-line">If you have any question you can search for a related article below or simply enter what you are looking for!</p>
            <form id="search-form" class="search-form clearfix" method="get" action="#" autocomplete="off">
                <div class="input-group">
                    <input type="text" class="form-control" autocomplete="off" placeholder="Search this blog" 
                    style="border-radius: 5px !important; height: 50px !important;">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>
                <ul class="list-group liveresult"></ul>
            </form>
        </div>
    </div>
    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="span8 page-content">
                    <div class="row separator">
                        <div class="span8 page-content">
                            <!-- Basic Home Page Template -->
                            <div class="row separator">
                                <section class="span8 articles-list">
                                    <h3>Featured Articles</h3>
                                    <?php
                                        $limit = 5;
                                        $query = "SELECT * FROM questions";
                                        $s = $conn->prepare($query);
                                        $s->execute();
                                        $total_results = $s->rowCount();
                                        $total_pages = ceil($total_results/$limit);
                                        if (!isset($_GET['page'])) {
                                            $page = 1;
                                        } else{
                                            $page = $_GET['page'];
                                        }
                                        $starting_limit = ($page-1)*$limit;
                                        $show = "SELECT * FROM questions ORDER BY q_id DESC LIMIT $starting_limit, $limit";
                                        $r = $conn->prepare($show);
                                        $r->execute();
                                        while($res = $r->fetch(PDO::FETCH_ASSOC)) :
                                            $q_author = $res['q_author'];
                                            $q_title = $res['q_title'];
                                            $q_id = $res['q_id'];
                                            $q_slug = $res['slug'];
                                            $origin_q_date = $res['q_date'];
                                            $q_score = $res['q_like'] - $res['q_dislike'];
                                            $newDate = date("d m Y", strtotime($origin_q_date));
                                            $user = $conn->query("SELECT user_id, username, q_author FROM users,questions WHERE user_id='$q_author'",PDO::FETCH_ASSOC)->fetch();
                                            $user_id = $user['user_id'];
                                            $username = $user['username'];
                                    ?>
                                    <div class="forum-item">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="forum-icon"> <i class="fa fa-bolt"></i></div> <a href="<?php echo "post/$q_slug"; ?>" class="forum-item-title"><?php echo $q_title; ?></a>
                                                <div class="forum-sub-title"><a href="<?php echo "/author/$username"; ?>"><?php echo $username; ?></a> posted a post.</div>
                                            </div>
                                            <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $res['q_like'] ?> </span>
                                                <div> <small>Likes</small></div>
                                            </div>
                                            <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $res['q_dislike'] ?> </span>
                                                <div> <small>Dislikes</small></div>
                                            </div>
                                            <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $res['q_like'] - $res['q_dislike'] ?> </span>
                                                <div> <small>Score</small></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                                </section>
                            </div>
                            <div class="index-paging">
                            <?php  for ($i=1; $i <= $total_pages ; $i++):?>
                            <?php if($page == $i ){ ?>
                            <a href='<?php echo "?page=$i"; ?>' class="active"><?php echo $i; ?></a>
                            <?php } else { ?>
                            <a href='<?php echo "?page=$i"; ?>'><?php echo $i; ?></a>
                            <?php } ?>
                            <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include "sidebar.php";?>
            </div>
        </div>
    </div>
    <?php include "footer.php";?>

    <script type="text/javascript">
    $(document).ready(function(){
        $('.input-group input[type="text"]').on("keyup input", function(){
            var input = $(this).val();
            var resultDropdown = $(".input-group").siblings(".liveresult");
            if(input.length){
                $.post('search.php', {term: input}).done(function(data){
                    resultDropdown.html(data);
                });
            }else{
                resultDropdown.empty();
            }
        });

        $(document).on("click", ".liveresult li", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".liveresult").empty();
        });

        $(".forum-item").hover(
            function(){ $(this).addClass("active");},
            function(){ $(this).removeClass("active");}       
        );
    });
    </script>