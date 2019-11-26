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
                            <div class="my-3 p-3 rounded box-shadow">
                                <h3 class="border-bottom border-gray pb-2 mb-0">Recent updates</h3>
                                <?php
                                $query = $conn->query("SELECT * FROM questions",PDO::FETCH_ASSOC);
                                $getQuestions = $query->fetchAll(PDO::FETCH_ASSOC);
                                ?>
                                <?php foreach($getQuestions as $getQuestion) { ?>
                                <div class="media text-muted pt-3">
                                    <img data-src="holder.js/32x32?theme=thumb&bg=007bff&fg=007bff&size=1" alt="" class="mr-2 rounded">
                                    <p class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
                                        <strong class="d-block text-gray-dark"><? echo $getQuestion['q_author'] ?></strong> <? echo $getQuestion['q_title'] ?>
                                    </p>
                                </div>
                                <?php } ?>
                                <small class="d-block text-right mt-3">
                                    <a href="#">All updates</a>
                                </small>
                            </div>
                        </section>
                    </div>
                </div>
<?php include "sidebar.php";?>
            </div>
        </div>
    </div>
<?php include "footer.php";?>