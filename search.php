<?php
include 'helpers/homeController.php';
    if ($_REQUEST['term']) { 
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $term = $_REQUEST['term']; 
        $query = $conn->query("SELECT * FROM questions WHERE q_title LIKE '%".$term."%'",PDO::FETCH_ASSOC);
        $result=$query->fetchAll();
        if ($result) { 
            foreach ($result as $key => $value) {
                echo '<li class="list-group-item">'.$value["q_title"].'</li>';
            }
        }else{
            echo '<li class="list-group-item">No matching records were found.</li>';
        }
    }
?>
