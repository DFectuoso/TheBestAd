<?php $view->extend('::base.html.php'); ?>

<style>
    #holder { border: 10px dashed #ccc; width: 300px; height: 300px; margin: 20px auto;}
    #holder.hover { border: 10px dashed #333; }
</style>

<section class="billboard">
    <img src="http://cloudadmin.mx/images/cloudadmin.png" />
</section>

<div class='sharebar'>

    <div class="social">
       Share now
    </div>

    <div>
        <div id="holder" ></div> 
        <button style="display:none">Send</button>
    </div>


  <div> 
    Connected users: <span id="connected_users">0</span>
  </div>
    
  <div> 
    Adds seen: <span id="ad_seen">0</span>
  </div>
  
  <div>
    ads clicks: <span id="ad_clicks">0</span>
  </div>

  <input type="hidden" id="loadedAdId" value="AQUIVAELIDDELANUNCIO!!!!YEAH"/>

</div>

<?php $view['slots']->start('include_js_body'); ?>
<script type='text/javascript' src='https://cdn.firebase.com/v0/firebase.js'></script>
<script type="text/javascript" src="<?=$view['assets']->getUrl('js/home.js');?>"></script>
<?php $view['slots']->stop(); ?>
