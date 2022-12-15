<?php
$this->layout('layout');
?>

    <div class="container" >
      <div class="row" style="background-color: #F5F5F5">
        <div class="col-md-8 offet-md-2 my-5 py-5" >
         <form action="/admin/update-category/<?= $category['id'];?>" method="POST" enctype="multipart/form-data">
          <div class="form-group">
              <label for="">Category title</label>
              <?=flash(); ?>
              <input type="text" name="title" class="form-control" value="<?php echo $category['name'];?>">
          </div>
        <div class="form-group mt-5">
           <img src="/uploads/<?= $category['img_path'] ?>" alt="" width="200" >
            <input type="hidden" name="oldImage" value="<? echo $category['img_path'] ?>">
        </div>
         <div class="form-group">
            <label >Add image</label>
            <input type="file" class="form-control-file" name="image">
         </div>
          <div class="form-group">
              <button class="btn btn-outline-success">Edit Category</button>
              <a href="/admin/category-control" class="btn btn-outline-info">Back</a>
          </div>
        </form>
      </div>
    </div>
  </div>
  