<?php
include 'header.php';
$AllUsers = adminController::getAllCategories();
?>
<body>
    <div class="container">
        <form>
            <input type="text" id="cat_name" placeholder="Category Name">
            <input type="text" id="cat_description" placeholder="Category Description">
            <input type="button" class="add-row" value="Add">
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>Category Name</th>
                    <th>Category Description</th>
                    <th>Category Keywords</th>
                    <th>Category Slug</th>
                    <th>Category Total Questions</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                foreach ($AllUsers as $key) { ?>
                    <tr>
                        <td><input type="checkbox" value="<?php echo $key['cat_id'] ?>" name="record"></td>
                        <td><?php echo $key["cat_name"] ?></td>
                        <td><?php echo $key["cat_description"] ?></td>
                        <td><?php echo $key["cat_keywords"] ?></td>
                        <td><?php echo $key["cat_slug"] ?></td>
                        <td><?php echo $key["cat_totalquestion"] ?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
        <button type="button" class="delete-row">Delete</button>
    </div>
</body>
<script>
    $(document).ready(function(){

        $(".add-row").click(function(){
            var cat_name = $("#cat_name").val();
            var cat_description = $("#cat_description").val();
            var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + cat_name + "</td><td>" + cat_description + "</td></tr>";
            var action = "addCategory";
            $("table tbody").append(markup);
            $.ajax({
                url:"/action.php",
                method:"POST",
                data: {cat_name:cat_name, cat_description:cat_description, action:action},
                success:function(response){
                    alert(response);
                }       
            })
        });
        
        $(".delete-row").click(function(){
            var action = "deleteCategory";
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    var value = $(this).val();
                    $(this).parents("tr").remove();
                    $.ajax({
                        url:"/action.php",
                        method:"POST",
                        data: {cat_id:value, action:action},
                        success:function(response){
                            alert(response);
                        }
                    });
                }
            });
        });
    });    
</script>