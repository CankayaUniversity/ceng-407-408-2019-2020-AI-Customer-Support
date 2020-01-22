<?php
include 'helpers/homeController.php';
    if ($_REQUEST['term']) { // Bir terim gelip gelmediğini kontrol ediyoruz.
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $term = $_REQUEST['term']; // Gelen terimi değişkene atıyoruz.
        $query = $conn->query("SELECT * FROM questions WHERE q_title LIKE '%".$term."%'",PDO::FETCH_ASSOC);
        $query->setFetchMode(PDO::FETCH_ASSOC);
        $result=$query->fetchAll();
        if ($result) { 
            foreach ($result as $key => $value) {
                echo '<li class="list-group-item">'.$value["q_title"].'</li>';
            }
        }else{
            echo '<li class="list-group-item">Eşleşen kayıt bulunamadı.</li>';
        }
    }
?>
