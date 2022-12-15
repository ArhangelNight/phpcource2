<?php 
$this->layout('layout', ['title' => 'Add Post']);
?>
    <div class="container">
        <h1 class="text-left"><strong>Add new post</strong></h1>
      <div class="row" style="background-color: #F5F5F5">
        <div class="col-md-8 offet-md-2">
         <form action="/store-post" method="POST" enctype="multipart/form-data">
          <div class="form-group">
              <label for="">Title</label>
              <?=flash(); ?>
              <input type="text"  name="title" class="form-control" value="<?=@$_POST['title']?>"required>
          </div>

          <div class="form-group">
          <label >Add image</label>
          <input type="file" class="form-control-file" name="image" required>
         </div>

         <div class="form-group my-3">
          <label for="">Choose category</label>
            <select class="form-control" name="category" required>
                <option></option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?=$category['id'] ?>"><?=$category['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

          <label for="">Description</label>
          <div class="form-group">
            <textarea name="description" class="form-control"rows="2" cols="60" maxlength="250" required></textarea>
         </div> 

        <label for="">Text</label>
          <div class="form-group">
            <textarea name="text" class="form-control" rows="10" cols="60"  maxlength="5000" required></textarea>
        </div>
        
          <div class="form-group">
              <button class="btn btn-outline-success">Add Post</button>
              <a href="/admin/post-control" class="btn btn-outline-info">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>