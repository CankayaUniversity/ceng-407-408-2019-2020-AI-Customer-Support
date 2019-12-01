<?php include "header.php";?>

    <body>

        <div class="page-container">
            <div class="container">
                <div class="row">
                    <div class="span8 page-content">
                        <div class="row separator">
                            <section class="span8 articles-list">
                                <div class="osahan-account-page-right shadow-sm bg-white p-4 h-100">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane  fade  active show" id="orders" role="tabpanel" aria-labelledby="orders-tab">
                                            <div class="bg-white card mb-4 order-list shadow-sm">
                                                <?php
                                            if (isset($_GET['post'])) {
                                                $q_id = $_GET['post'];
                                            }
                                            $query = $conn->query("SELECT * FROM questions WHERE q_id='$q_id'",PDO::FETCH_ASSOC);
                                            $query->setFetchMode(PDO::FETCH_ASSOC);
                                            while($r=$query->fetch()){
                                                $q_id = $r["q_id"];
                                                $q_title = $r["q_title"];
                                                $q_description = $r["q_description"];
                                                $q_author_id = $r['q_author'];
                                                $q_date = $r['q_date'];
                                            }
                                            ?>
                                                    <div class="card shadow-none mt-3 border border-light">
                                                        <div class="card-body">
                                                            <div class="media mb-3"> <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle mr-3 mail-img shadow" alt="media image" width="100" height="100">
                                                                <div class="media-body"> <span class="media-meta float-right"><?php echo $q_date; ?></span>
                                                                    <h4 class="text-primary m-0"><?php echo $q_title; ?></h4> <small class="text-muted"><?php echo $q_author_id; ?></small></div>
                                                            </div>
                                                            <p>
                                                                <?php echo $q_description; ?>
                                                            </p>
                                                            <hr>
                                                            <h4> <i class="fa fa-paperclip mr-2"></i> Attachments <span>(3)</span></h4>
                                                            <div class="row">
                                                                <div class="col-sm-4 col-md-3">
                                                                    <a href="javascript:void();"> <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="attachment" class="img-thumbnail"> </a>
                                                                </div>
                                                                <div class="col-sm-4 col-md-3">
                                                                    <a href="javascript:void();"> <img src="https://bootdey.com/img/Content/avatar/avatar2.png" alt="attachment" class="img-thumbnail"> </a>
                                                                </div>
                                                                <div class="col-sm-4 col-md-3">
                                                                    <a href="javascript:void();"> <img src="https://bootdey.com/img/Content/avatar/avatar3.png" alt="attachment" class="img-thumbnail"> </a>
                                                                </div>
                                                            </div>
                                                            <div class="media mt-3">
                                                                <a href="javascript:void();" class="media-left"> <img alt="" src="https://bootdey.com/img/Content/avatar/avatar1.png" width="50" height="50"> </a>
                                                                <div class="media-body">
                                                                    <textarea class="wysihtml5 form-control" rows="9" placeholder="Reply here..."></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="button" class="btn btn-primary waves-effect waves-light mt-3"><i class="fa fa-send mr-1"></i> Send</button>
                                                            </div>
                                                        </div>
                                                    </div>
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