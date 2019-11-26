<?php 
include 'header.php';
include 'inc/config.php';
?>
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
                                ...
                            </div>
                        </section>
                    </div>
                </div>
<?php include "sidebar.php";?>
            </div>
        </div>
    </div>
<?php include "footer.php";?>