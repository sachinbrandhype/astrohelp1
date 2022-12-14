<!doctype html>
<html lang="en">
<?php $data = array();?>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php $this->load->view('Templates/header',$data); ?>
     <body>
 <div></div>
 <div class="modal fade call-modal" id="download-popup">
<div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content">
      <div class="modal-body get-app">
            <!-- Outgoing Call -->
      <div class="call-box incoming-box">
         <div class="call-wrapper">
         <div class="call-inner">
          <div class="call-user">
        <h4>Get The App Download Now !</h4>
    <p class="video-con">For video consultation</p>
             <div class="down-app">
   <a href=""><img src="<?php echo base_url();?>assets/img/play-store.png"></a>
                </div>
                </div>  

                </div>
                </div>
                </div>
            <!-- Outgoing Call -->

               </div>
                </div>
                 </div>
                  </div>
      <!-- Main Wrapper -->
     <div class="main-wrapper">
      
       <?php $this->load->view('Templates/header-menu',$data); ?>


        <?php $this->load->view($page); ?>


        <?php  $this->load->view('Templates/footer',$data); ?>

</div>

<?php  $this->load->view('Templates/footer_script',$data); ?>
</body>

</html>