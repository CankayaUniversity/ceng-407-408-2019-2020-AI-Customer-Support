<?php include "header.php";?>
    <div class="search-area-wrapper">
        <div class="search-area container">
            <h3 class="search-header">Have a Question?</h3>
            <p class="search-tag-line">If you have any question you can search for a related article below or simply enter what you are looking for!</p>
            <form id="search-form" class="search-form clearfix" method="get" action="#" autocomplete="off">
                <div class="input-group">
                    <input type="search" class="form-control" autocomplete="off" placeholder="Search this blog" 
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
                                    <?php $totalQuestions = Functions::getQuestionNumber(); ?>
                                    <h3>Featured Articles <small>Total Questions : <?php echo $totalQuestions ?></small></h3>
                                    <?php
                                        $result = Functions::homePagePagination(5);
                                        foreach ($result as $key => $value) {
                                            $q_id = $value["q_id"];
                                            $commentCount = $conne->selectRowCount("SELECT * FROM comments WHERE c_post_id = $q_id");
                                    ?>
                                    <div class="forum-item">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="forum-icon"> <i class="fa fa-bolt"></i></div> <a href="<?php echo "post/".$value['slug'].""; ?>" class="forum-item-title"><?php echo $value['q_title']; ?></a>
                                                <div class="forum-sub-title"><a href="<?php echo "/author/".$value['username'].""; ?>"><?php echo $value['username']; ?></a> posted a post.</div>
                                            </div>
                                            <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $commentCount ?> </span>
                                                <div> <small>Replies</small></div>
                                            </div>
                                            <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $value['q_view'] ?> </span>
                                                <div> <small>Views</small></div>
                                            </div>
                                            <div class="col-md-1 forum-info"> <span class="views-number"> <?php echo $value['q_like'] - $value['q_dislike'] ?> </span>
                                                <div> <small>Score</small></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                </section>
                            </div>
                            <div class="index-paging">
                            <?php  
                            $total_pages = Functions::totalPages(5);
                            $page = Functions::currentPage();
                            for ($i=1; $i <= $total_pages ; $i++):?>
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
        $(".forum-item").hover(
            function(){ $(this).addClass("active");},
            function(){ $(this).removeClass("active");}       
        );
    });
    </script>