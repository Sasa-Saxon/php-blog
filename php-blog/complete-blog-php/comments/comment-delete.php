<?php

require_once('../config.php');

$comment_id = $_POST['comment_id'];

$sql_del = "DELETE FROM tbl_user_comments WHERE id = $comment_id";
$stmt = $conn->prepare($sql_del);
$stmt->execute();

if (!empty($stmt)) {
    echo true;
}
?>