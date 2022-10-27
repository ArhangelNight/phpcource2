<?php
include 'functions.php';
$db = include __DIR__ . '/../database/start.php';

$id = $_GET['id'];
$post = $db->getOne('posts', $id);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>select</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
</head>
<body>
    <h2 align="center"><?php echo $post["title"];?></h2><br><br>
    <div class="col-md-8 offset-md-2">
        <table class="table">
            <tr>
                <th scope="col"><?php echo $post["description"];?></th>
                <th scope="col"><img src="/images/<?php echo $post['image'];?>" width="500" height="500" alt=""></th>
            </tr>
        </table>
    </div>

</body>
</html>