<?php
include 'header.php';
$AllQuestions = $conne->selectAll("questions");
?>
<body>
    <div class="container">
        <input type="text" id="searchInput" class="inputStyle" onkeyup="search()" placeholder="Search for names.." title="Type in a name">
        <table class="table table-bordered" id="myTable">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Question Title</th>
                    <th>Question Description</th>
                    <th>Question Tags</th>
                    <th>Question Author</th>
                    <th>Question Category</th>
                    <th>Question Page</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($AllQuestions as $key) { ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $key['q_id'] ?>" name="record"></td>
                        <td><?php echo $key["q_title"] ?></td>
                        <td><?php echo $key["q_description"] ?></td>
                        <td><?php echo $key["q_tags"] ?></td>
                        <?php 
                            $statement = $key['q_author'];
                            $q_author = $conne->selectWhere("users","user_id","=",$statement,"int"); 
                        ?>
                        <td><?php echo $q_author[0]['firstname'].' '.$q_author[0]['surname'] ?></td>
                        <?php
                            $statement = $key['category'];
                            $category = $conne->selectWhere("categories","cat_id","=",$statement,"int"); 
                        ?>
                        <td><?php echo $category[0]['cat_name'] ?></td>
                        <td><a href='<?php $link = $key['slug']; echo "/post/$link" ?>'>Link</a></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <button type="button" class="btn btn-danger" id="delete-row">Delete</button>
    </div>
</body>
<script>
    $(document).ready(function(){
        $("#delete-row").click(function(){
            var action = "deleteQuestion";
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    var value = $(this).val();
                    $(this).parents("tr").remove();
                    $.ajax({
                        url:"/action.php",
                        method:"POST",
                        data: {q_id:value, action:action},
                        success:function(response){
                            alert(response);
                        }
                    });
                }
            });
        });
    });    
    function search() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("searchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            td = tr[i].getElementsByTagName("td")[1];
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>