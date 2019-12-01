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
                                            <h4 class="font-weight-bold mt-0 mb-4">Title gelsin</h4>
                                            <div class="bg-white card mb-4 order-list shadow-sm">
            <?php
            if (isset($_GET['post'])) {
                $q_id = $_GET['post'];
            }
            $query = $conn->query("SELECT * FROM questions WHERE q_id='$q_id'",PDO::FETCH_ASSOC);
            $query->setFetchMode(PDO::FETCH_ASSOC);
            while($r=$query->fetch()){
                echo $r["q_id"];
                echo $r["q_title"];
                echo $r["q_description"];
                echo $r['q_date'];
                echo $r['q_author'];
            }
            ?>
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