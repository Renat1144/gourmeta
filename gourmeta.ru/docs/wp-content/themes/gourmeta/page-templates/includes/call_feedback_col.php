<!-- call to actions -->
<div class="col-wrapper col-box call-to-action">
    <em><?= langS('Предложите решение,<br/>которое подходит именно для меня...', 'Contact us for personal coffee advice'); ?></em>
    <? $phone = get_option('phone'); ?>
    <div class="call-button-holder">
        <a href="tel:<?= $phone['clear'] ?>" class="call-link"><?= $phone['formated'] ?><span></span></a> <span><?= langS('или', 'or') ?></span> <? include 'feedback_button.php' ?>
    </div>
</div>