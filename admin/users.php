<?php
include 'header.php';
?>
<body>
    <div class="container">
        <form>
            <input type="text" id="name" placeholder="Name">
            <input type="text" id="email" placeholder="Email Address">
            <input type="button" class="add-row" value="Add">
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><input type="checkbox" name="record"></td>
                    <td>Atakan Demircioğlu</td>
                    <td>a@a.com</td>
                </tr>
            </tbody>
        </table>
        <button type="button" class="delete-row">Delete</button>
    </div>
</body>
<script>
    $(document).ready(function(){
        $(".add-row").click(function(){
            var name = $("#name").val();
            var email = $("#email").val();
            var markup = "<tr><td><input type='checkbox' name='record'></td><td>" + name + "</td><td>" + email + "</td></tr>";
            $("table tbody").append(markup);
        });
        
        $(".delete-row").click(function(){
            $("table tbody").find('input[name="record"]').each(function(){
                if($(this).is(":checked")){
                    $(this).parents("tr").remove();
                }
            });
        });
    });    
</script>