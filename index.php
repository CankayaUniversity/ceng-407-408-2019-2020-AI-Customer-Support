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
                $query = $conn->query("SELECT * FROM questions",PDO::FETCH_ASSOC);
                $getQuestions = $query->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <?php foreach($getQuestions as $getQuestion) { 
                $q_author = $getQuestion['q_author'];
                $user = $conn->query("SELECT user_id, firstname, surname, q_author FROM users,questions WHERE user_id='$q_author'",PDO::FETCH_ASSOC)->fetch();
            ?>
                <div class="gold-members p-4">
                    <a href="#"> </a>
                    <div class="media">
                        <a href="#"> <img class="mr-4" src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="Generic placeholder image"> </a>
                        <div class="media-body">
                            <a href="#"> <span class="float-right text-info">Delivered on <?php echo $getQuestion['q_date'] ?> <i class="icofont-check-circled text-success"></i></span> </a>
                            <h6 class="mb-2"> <a href="#"></a> <a href="#" class="text-black"><?php echo $getQuestion['q_title'] ?></a></h6>
                            <p class="text-gray mb-1"><i class="icofont-location-arrow"></i> <?php echo $getQuestion['q_description'] ?></p>
                            <hr>
                            <div class="float-right"> <a class="btn btn-sm btn-outline-primary" href="#"><i class="icofont-headphone-alt"></i> HELP</a> <a class="btn btn-sm btn-primary" href="#"><i class="icofont-refresh"></i> REORDER</a></div>
                            <p class="mb-0 text-black text-primary pt-2"><span class="text-black font-weight-bold"> By </span> <?php echo $user['firstname'].' '.$user['surname'] ?></p>
                        </div>
                    </div>
                </div>
            <?php } ?>
            </div>
        </div>
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