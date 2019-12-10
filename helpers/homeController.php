<?php 
include '/inc/Conn.php';
class HomeController 
{
    public function getNCount($userid) {
        $conne = new Mysql();
        $conn = $conne->dbConnect();
        $n_sql = "SELECT * FROM notifications WHERE n_notified_id = '$userid'";
        $n_count = $conn->prepare($n_sql);
        $n_count->execute();
        $count = $n_count->rowCount();
        echo "<script>var n_count = ".json_encode($count).";</script>";
    }

} 

$obj = new HomeController; 
?>