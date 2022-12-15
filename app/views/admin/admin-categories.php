<?php
$this->layout('layout');

?>


<div class="container">
    <div class="row">
      <div class="col-md-8 offest-md-2">
        <?=flash(); ?>
        <a href="/admin/add-category" class="btn btn-outline-success"><i class="fa fa-plus mr-2"></i>Add Categories</a>
        <table class="table">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Title</th>
              <th scope="col">Image</th>
              <th scope="col">Actions</th>

            </tr>
          </thead>
          <tbody>
            <?php foreach($categories as $category):?>
               <tr>
              

              <th scope="row"><?php echo $category['id'];?></th>
              <td><h5><a class="text-primary" href="/category-posts/<?= $category['id'];?>" class="post-cat"><?php echo $category['name'];?></a></h5>
              </td>

              <td>
                  <img src="/uploads/<?= $category['img_path'] ?>" alt="" width="100" >
              </td>

              <td>
                <a href="/admin/edit-category/<?= $category['id'];?>" class="btn btn-outline-warning"><i class="fa fa-edit mr-2"></i>Edit</a>
              </td>
              <td>
             <a href="/admin/delete-category/<?= $category['id'];?>"
                 class="btn btn-outline-danger" onclick="return confirm('are you shure?')"><i class="fa fa-times-circle mr-2"></i>Delete</a>
              </td>
            
            </tr>
            <?php endforeach;?>
           
          </tbody>
        </table>
    </div>
  </div>
</div>
