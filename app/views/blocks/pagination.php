<nav class="d-flex justify-content-center wow fadeIn">
    <ul class="pagination pg-blue">

        <!--Arrow left-->
        <?php if ($paginator->getPrevUrl()): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo ($paginator->getPrevUrl()); ?>" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
        <?php endif; ?>

        <?php foreach ($paginator->getPages() as $page): ?>
            <?php if($page['url']): ?>

                <li <?php echo $page['isCurrent'] ? 'class="page-item active"' : 'class="page-item"'?> >
                    <a class="page-link" href="<?php echo $page['url']; ?>"><?php echo $page['num']; ?>
                        <?php echo $page['isCurrent'] ? '<span class="sr-only">(current)</span>' : ''?>
                    </a>
                </li>
            <?php else: ?>
                <li class="page-item disabled">
                    <a class="page-link" href="#"><?php echo $page['num']; ?></a>
                </li>
            <?php endif; ?>
        <?php endforeach; ?>
        <?php if ($paginator->getNextUrl()): ?>
            <li class="page-item">
                <a class="page-link" href="<?php echo ($paginator->getNextUrl()); ?>" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        <?php endif; ?>
    </ul>
</nav>