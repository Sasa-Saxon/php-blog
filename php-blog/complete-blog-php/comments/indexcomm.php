<html>
    <head>
        <title>Add-Delete-comment</title>
        <?php include ('../config.php'); ?>
        <script src="jquery-3.2.1.min.js"></script>
        <link href="../static/css/style.css" rel="stylesheet" type="text/css"/>
        <link href="../static/css/public_styling.php.css" rel="stylesheet" type="text/css"/>
        <?php include (ROOT_PATH . '/includes/registration_login.php'); ?>
        <?php include (ROOT_PATH . '../checkauthorization.php'); ?>
    </head>
    <body>



        <div class="navbar">

            <div class="logo_div">
                <a href="../index.php"><h1>LifeBlog</h1></a>
            </div>

            <ul>
                <li><a class="active" href="../index.php">Home</a></li>
                <li><a href="#news">News</a></li>
                <li><a href="#contact">Contact</a></li>
                <li><a href="#about">About</a></li>
            </ul>

        </div>
        <div class="demo-container">

            <form action=" " id="frmComment" method="post">

                <div class="row">
                    <label> Name: </label> <span id="name-info"></span><input class="form-field" id="name"
                                                                              type="text" name="user"> 
                </div>
                <div class="row">
                    <label for="mesg"> Message : <span id="message-info"></span></label>
                    <textarea class="form-field" id="message" name="message" rows="4"></textarea>

                </div>
                <div class="row">
                    <input type="hidden" name="add" value="post" />
                    <button type="submit" name="submit" id="submit" class="btn-add-comment">Add Comment</button>

                </div>
            </form>

            <?php
            $sql_sel = "SELECT * FROM tbl_user_comments ORDER BY id DESC";
            $result = $conn->query($sql_sel);
            $count = $result->num_rows;

            if ($count > 0) {
                ?>
                <div id="comment-count">
                    <span id="count-number"><?php echo $count; ?></span> Comment(s)
                </div>
<?php } ?>
            <div id="response">
            <?php
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) { // using prepared staement
                ?>
                    <div id="comment-<?php echo $row["id"]; ?>" class="comment-row">
                        <div class="comment-user"><?php echo $row["username"]; ?></div>
                        <div class="comment-msg" id="msgdiv-<?php echo $row["id"]; ?>"><?php echo $row["message"]; ?></div>
                        <div class="delete" name="delete"
                             id="delete-<?php echo $row["id"]; ?>"
                             onclick="deletecomment(<?php echo $row["id"]; ?>)">Delete</div>
                    </div>
    <?php
}
?>
            </div>
        </div>

        <script type="text/javascript"></script>

        <script>

            function deletecomment(id) {

                if (confirm("Are you sure you want to delete this comment?")) {

                    $.ajax({
                        url: "comment-delete.php",
                        type: "POST",
                        data: 'comment_id=' + id,
                        success: function (data) {
                            if (data)
                            {
                                $("#comment-" + id).remove();
                                if ($("#count-number").length > 0) {
                                    var currentCount = parseInt($("#count-number").text());
                                    var newCount = currentCount - 1;
                                    $("#count-number").text(newCount)
                                }
                            }
                        }
                    });
                }
            }

            $(document).ready(function () {

                $("#frmComment").on("submit", function (e) {
                    $(".error").text("");
                    $('#name-info').removeClass("error");
                    $('#message-info').removeClass("error");
                    e.preventDefault();
                    var name = $('#name').val();
                    var message = $('#message').val();

                    if (name == "") {
                        $('#name-info').addClass("error");
                    }
                    if (message == "") {
                        $('#message-info').addClass("error");
                    }
                    $(".error").text("required");
                    if (name && message) {
                        $("#loader").show();
                        $("#submit").hide();
                        $.ajax({

                            type: 'POST',
                            url: 'comment-add.php',
                            data: $(this).serialize(),
                            success: function (response)
                            {
                                $("#frmComment input").val("");
                                $("#frmComment textarea").val("");
                                $('#response').prepend(response);

                                if ($("#count-number").length > 0) {
                                    var currentCount = parseInt($("#count-number").text());
                                    var newCount = currentCount + 1;
                                    $("#count-number").text(newCount)
                                }
                                $("#loader").hide();
                                $("#submit").show();
                            }
                        });
                    }
                });
            });
        </script>

    </body>
</html>