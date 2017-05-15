<br>
<div class="inner cover">
    <?php
    if (isset($data['errors'])) {
        require __DIR__ . '/../errors/errorsList.php';
    }

    if (isset($data['successful'])) {
        require __DIR__ . '/../successful/successfulList.php';
    }
    ?>
    <?php foreach ($data['quotes'] as $qoute): ?>
        <div class="panel panel-default panel-quote" id="quote<?php echo $qoute['quote_id']; ?>">
            <div class="panel-body">
                <blockquote class="text-left">
                    <p><?php echo $this->html($qoute['text']); ?></p>
                    <footer>
                        <a href="?author_id=<?php echo $qoute['author_id']; ?>"><cite title="<?php echo $this->html($qoute['author']); ?>"><?php echo $this->html($qoute['author']); ?></cite></a>
                    </footer>
                </blockquote>
            </div>
            <div class="panel-footer">
                <a href="quotes#quote<?php echo $qoute['quote_id']; ?>">id<?php echo $qoute['quote_id']; ?></a>
                <span> / </span>
                <a href="quotes#quoteedit?quote_id=<?php echo $qoute['quote_id']; ?>">Изменить</a>
                <span> / </span>
                <a href="delquote?quote_id=<?php echo $qoute['quote_id']; ?>">Удалить</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>



<!-- Всплывающее окно для подтверждения удаления цитаты -->
<!--
<div class="modal fade bs-example-modal-sm" id="confirmDeletion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
-->
<!--
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    <h4 class="modal-title" id="myModalLabel">Подтверждение</h4>
</div>
-->
<!--
<div class="modal-body">
    <h4>Вы уверены что хотите удалть цитату?</h4>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger">Удалить</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Отменить</button>
</div>
</div>
</div>
</div>
-->