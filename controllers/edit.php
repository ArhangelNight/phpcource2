<?php
include 'functions.php';
$db = include __DIR__ . '/../database/start.php';

$id = $_GET['id'];
$post = $db->getOne('posts', $id);
?>




<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Edit Post</title>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <form action="/update?id=<?php echo $post['id'];?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" name="title" class="form-control" value="<?php echo  $post['title']?>">
                    <label for="text">Description</label><br>
                    <textarea name="description" class="form-control"><?php echo $post["description"];?></textarea><br><br>
                    <img src="/images/<?php echo $post['image'];?>" width="200" height="200" alt=""><br><br>
                    <input type="hidden" name="oldImage" value="<?php echo $post['image'];?>">
                    <input type="file" name="image"><br><br>
                </div>
                <div class="form-group"><button class="btn btn-warning">Edit Post</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>