<?php $view->extend('::base.html.php'); ?>

<section class="billboard">
    <img src="http://cloudadmin.mx/images/cloudadmin.png" />
</section>

<div class='sharebar'>

    <div class="social">
       Share now
    </div>

    <div class="purchase-wrapper">

    </div>

</div>

<?php $view['slots']->start('include_js_body'); ?>
<script type="text/javascript" src="<?=$view['assets']->getUrl('js/home.js');?>"></script>
<?php $view['slots']->stop(); ?>