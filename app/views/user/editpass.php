<?php
$this->layout('layout',['title' => 'Change password']);
?>

<div class="container my-5 h-100"  style="background-color: #F5F5F5">
    <div class="row h-100 justify-content-center align-items-center" >
        <form class="col-5 text-center" action="/update-password/<?=  $user_id ?>" method="post">

            <h2 class="blue-text my-4">Change password</h2>
            <?=flash(); ?>

            <div class="form-group my-3">
                <input type="password" class="form-control" placeholder="Password" name="old_password">
            </div>
            <div class="form-group my-3">
                <input type="password" class="form-control" placeholder="New password" name="new_password">
            </div>

            <button class="btn btn-lg btn-outline-primary btn-block" type="submit">Change</button>
            <br>
            <a href="/profile">Back</a>

        </form>
    </div>
</div>
