<?php
$this->layout('layout',['title' => 'Myposts']);
?>

<main class="pt-5" style="background-color: #F5F5F5">
    <div class="container">
      <a href="/add" class="btn btn-outline-success float-right"><i class="fa fa-plus mr-2"></i>Add Post</a>
      <section class="pt-5">
        <?=flash(); ?>

        <div class="wow fadeIn">
          <h2 class="h1 text-center mb-5">Давайте разбираться: объемы выросли</h2>
          <p class="text-center">С другой стороны, современная методология разработки обеспечивает широкому кругу (специалистов) участие
              в формировании приоретизации разума над эмоциями! </p>
          <p class="text-center mb-5 pb-5">Значимость этих проблем настолько <strong>очевидна</strong>, что семантический разбор внешних противодействий позволяет
              оценить значение <strong>глубокомысленных</strong> рассуждений
            </p>
        </div>

          <?php foreach($posts as $post):?>
        <div class="row mt-3 wow fadeIn">

          <div class="col-lg-5 col-xl-4 mb-4 ">
            <div class="view overlay rounded z-depth-1">
              <img src="/../uploads/<?=$post['image'] ?>" class="img-fluid"
                alt="">
              <a href="/show-post/<?=$post['id']?>" target="_blank">
                <div class="mask rgba-white-slight"></div>
              </a>
            </div>
          </div>
         
          <div class="col-lg-7 col-xl-7 ml-xl-4 mb-4">
            <h3 class="mb-3 font-weight-bold dark-grey-text">
              <strong><?php echo $post['title'];?></strong>
            </h3>
            <p class="grey-text"><?php echo $post['description'] ?></p>
              <br>
            <a href="/show-post/<?=$post['id']?>" class="btn btn-outline-primary" target="_blank" >Read more<i class="fas fa-play ml-2"></i></a>

            <a href="/edit-post/<?= $post['id'];?>" class="btn btn-outline-warning">Edit<i class="fa fa-edit ml-2"></i></a>

            <a href="/delete-post/<?= $post['id'];?>"
                 class="btn btn-outline-danger" onclick="return confirm('are you shure?')">Delete<i class="fa fa-times-circle ml-2"></i></a>
          </div>
          
        </div>
        
        <hr class="mb-5">

          <?php endforeach;?>


          <?php $this->insert('/blocks/pagination', ['paginator' => $paginator]); ?>
       
      </section>

    </div>
  </main>
