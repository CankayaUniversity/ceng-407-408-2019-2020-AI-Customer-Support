<?php include "header.php";?>

<body>
    <div class="search-area-wrapper">
        <div class="search-area container">
            <h3 class="search-header">Have a Question?</h3>
            <p class="search-tag-line">If you have any question you can ask below or enter what you are looking!</p>

            <form id="search-form" class="search-form clearfix" method="get" action="#" autocomplete="off">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search this blog">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                </div>

                <div id="search-error-container"></div>
            </form>
        </div>
    </div>
    <div class="page-container">
        <div class="container">
            <div class="row">
                <div class="span8 page-content">
                    <div class="row separator">
                        <section class="span8 articles-list">
                        <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane  fade  active show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
            <h4 class="font-weight-bold mt-0 mb-4">Recent updates</h4>
            <div class="bg-white card mb-4 order-list shadow-sm">
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
            ?>
            <?php while($res = $r->fetch(PDO::FETCH_ASSOC)) :
            $q_author = $res['q_author'];
            $q_title = $res['q_title'];
            $q_id = $res['q_id'];
            $user = $conn->query("SELECT user_id, firstname, surname, q_author FROM users,questions WHERE user_id='$q_author'",PDO::FETCH_ASSOC)->fetch();?>
                <div class="gold-members p-4">
                    <a href="#"> </a>
                    <div class="media">
                        <a href="#"> <img class="mr-4" src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="Generic placeholder image"> </a>
                        <div class="media-body">
                            <a href="#"> <span class="float-right text-info">Delivered on <?php echo $res['q_date'] ?> <i class="icofont-check-circled text-success"></i></span> </a>
                            <h6 class="mb-2"> <a href='<?php echo "single.php?post=$q_id"; ?>' class="text-black"><?php echo $q_title; ?></a></h6>
                            <p class="text-gray mb-1"><i class="icofont-location-arrow"></i> <?php echo $res['q_description'] ?></p>
                            <hr>
                            <div class="float-right"> <a class="btn btn-sm btn-outline-primary" href="#"><i class="icofont-headphone-alt"></i> HELP</a> <a class="btn btn-sm btn-primary" href="#"><i class="icofont-refresh"></i> REORDER</a></div>
                            <p class="mb-0 text-black text-primary pt-2"><span class="text-black font-weight-bold"> By </span> <?php echo $user['firstname'].' '.$user['surname'] ?></p>
                        </div>
                    </div>
                </div> 

            <?php endwhile; ?>
            </div>
        </div>
      <?php  for ($page=1; $page <= $total_pages ; $page++):?>

<a href='<?php echo "?page=$page"; ?>' class="links"><?php echo $page; ?></a>

<?php endfor; ?>
    </div>
</div>
                        </section>
                    </div>
                </div>
<?php include "sidebar.php";?>
            </div>
        </div>
    </div>
<?php include "footer.php";?>