<?php
$this->layout('layout');

?>


<div class="container">
    <div class="row">
      <div class="col-md-8 offest-md-2">
        <?=flash(); ?>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Name</th>
              <th scope="col">Is Admin</th>
              <th scope="col">Email</th>
              <th scope="col">Actions</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach($users as $user):?>
               <tr>
              

              <th scope="row"><?php echo $user['id'];?></th>
              <td><h5><a class="text-primary" href="/admin/user-posts/<?= $user['id'];?>" class="post-cat"><?php echo $user['username'];?></a></h5>
              </td>
              <td>
                  <?php if ($user['roles_mask'] == 1):?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-plus" viewBox="0 0 16 16">
                          <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"/>
                          <path d="M8 4a.5.5 0 0 1 .5.5V6H10a.5.5 0 0 1 0 1H8.5v1.5a.5.5 0 0 1-1 0V7H6a.5.5 0 0 1 0-1h1.5V4.5A.5.5 0 0 1 8 4z"/>
                      </svg>
                  <?php else: ?>
                      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark" viewBox="0 0 16 16">
                          <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v13.5a.5.5 0 0 1-.777.416L8 13.101l-5.223 2.815A.5.5 0 0 1 2 15.5V2zm2-1a1 1 0 0 0-1 1v12.566l4.723-2.482a.5.5 0 0 1 .554 0L13 14.566V2a1 1 0 0 0-1-1H4z"></path>
                      </svg>
                  <?php endif;?>
              </td>

              <td>
                  <?= $user['email'] ?>
              </td>

              <td>
                <a href="/admin/user-profile/<?= $user['id'];?>" class="btn btn-outline-warning"><i class="fa fa-edit mr-2"></i>Edit</a>
              </td>
              <td>
             <a href="/admin/delete-user/<?= $user['id'];?>"
                 class="btn btn-outline-danger" onclick="return confirm('are you shure?')"><i class="fa fa-times-circle mr-2"></i>Delete</a>
              </td>
            
            </tr>
            <?php endforeach;?>
           
          </tbody>
        </table>
    </div>
  </div>
</div>
