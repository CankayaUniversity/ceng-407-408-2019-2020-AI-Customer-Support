<?php 

    include "header.php";

    if(!Functions::isAdmin()) {
        echo "No permission!";
        die();
    }

    if (isset($_GET['delete'])) {
        $getSlug = !empty($_GET['delete']) ? $_GET['delete'] : null;
        if($getSlug === null){
            echo "Operation can not completed!";
        } else {
            $query = $conn->prepare("DELETE FROM questions WHERE slug=:slug");   
            $query->execute([
                ':slug' =>  $getSlug
            ]);
            echo "Question deleted!";
        }
        exit(0);
    }

    else if (isset($_GET['edit'])) {
        $slug = $_GET['edit'];
        $getQuestion = $conne->selectWhere("questions","slug","=",$slug,"char");
        $q_title = $getQuestion[0]["q_title"];
        $q_description = $getQuestion[0]["q_description"];
        $q_id = $getQuestion[0]["q_id"];
    }

?>

    <div class="page-container">
        <textarea id="title" style="width:500px;height:40px;"><?php echo $q_title ?></textarea>
        <textarea name="editor"><?php echo $q_description ?></textarea>
        <div class="float-right">
             <button type="submit" class="btn btn-postAnswer" id="QuestionSubmit">Post Question</button>        
         </div>    
    </div>
    
<?php include "footer.php";?>


    <script type="text/javascript">
    
    $(document).ready(function(){
        CKEDITOR.replace('editor');
    });

    $("#QuestionSubmit").click(function(){
            var action = "editQuestion";
            var q_id = <?php echo $q_id; ?>;
            var newTitle = $("#title").val();
            var newDescription = CKEDITOR.instances['editor'].getData();
            $.ajax({
                url:"/action.php",
                method:"POST",
                data: {q_id:q_id, action:action, newTitle:newTitle, newDescription:newDescription},
                success:function(response){
                    alert(response);
                    location.reload();
                }
            });
    });  


    </script>