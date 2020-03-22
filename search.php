<?php
include 'helpers/Functions.php';
    if ($_REQUEST['term']) { 
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $term = $_REQUEST['term']; 
        $query = $conn->query("SELECT * FROM questions WHERE q_title LIKE '%".$term."%' LIMIT 4;",PDO::FETCH_ASSOC);
        $rowCount = $conne->selectRowCount("SELECT * FROM questions WHERE q_title LIKE '%".$term."%';");
        $result=$query->fetchAll();
        if ($result && $rowCount > 5) { 
            foreach ($result as $key => $value) {
                echo '<a href="/post/'.$value["slug"].'"><li class="list-group-item">'.$value["q_title"].'</li></a>';
            }
            echo '<a href="/tag/'.$term.'"><li class="list-group-item">Click here for more related questions!</li></a>';
        } else if ($result && $rowCount <= 5 && $rowCount > 0){
            foreach ($result as $key => $value) {
                echo '<a href="/post/'.$value["slug"].'"><li class="list-group-item">'.$value["q_title"].'</li></a>';
            }
        } else {
            echo '<li class="list-group-item">No matching records were found.</li>';
        }
    }
?>
