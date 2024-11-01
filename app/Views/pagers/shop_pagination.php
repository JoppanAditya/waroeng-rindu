<?php $pager->setSurroundCount(2) ?>

<div class="col-12">
    <div class="pagination d-flex justify-content-center mt-5">
        <?php if ($pager->hasPrevious()) : ?>
            <a class="rounded" href="<?= $pager->getFirst() ?>" aria-label="<?= lang('Pager.first') ?>">
                <span aria-hidden="true"><?= lang('Pager.first') ?></span>
            </a>
            <a class="rounded" href="<?= $pager->getPrevious() ?>" aria-label="<?= lang('Pager.previous') ?>">
                <span aria-hidden="true"><?= lang('Pager.previous') ?></span>
            </a>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <a class="<?= $link['active'] ? 'active ' : '' ?>rounded" href="<?= $link['uri'] ?>">
                <?= $link['title'] ?>
            </a>
        <?php endforeach ?>

        <?php if ($pager->hasNext()) : ?>
            <a class="rounded" href="<?= $pager->getNext() ?>" aria-label="<?= lang('Pager.next') ?>">
                <span aria-hidden="true"><?= lang('Pager.next') ?></span>
            </a>
            <a class="rounded" href="<?= $pager->getLast() ?>" aria-label="<?= lang('Pager.last') ?>">
                <span aria-hidden="true"><?= lang('Pager.last') ?></span>
            </a>
        <?php endif ?>
        <!-- <ay href="#" class="rounded">&raquo;</ay> -->
    </div>
</div>
