
<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
<!-- Bootstrap Core JS -->
<script src="<?php echo base_url(); ?>assets/js/popper.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
<!-- Slick JS -->
<script src="<?php echo base_url(); ?>assets/js/slick.js"></script>
<!-- Custom JS -->
<script src="<?php echo base_url(); ?>assets/js/script.js"></script>

<!-- Sticky Sidebar JS -->
<script src="<?php echo base_url(); ?>assets/plugins/theia-sticky-sidebar/ResizeSensor.js"></script>
<script src="<?php echo base_url(); ?>assets/plugins/theia-sticky-sidebar/theia-sticky-sidebar.js"></script>
<!-- Select2 JS -->
<script src="<?php echo base_url(); ?>assets/plugins/select2/js/select2.min.js"></script>
<!-- Datetimepicker JS -->
<script src="<?php echo base_url(); ?>assets/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<!-- Fancybox JS -->
<script src="<?php echo base_url(); ?>assets/plugins/fancybox/jquery.fancybox.min.js"></script>
<script src="<?php echo base_url(); ?>assets/webiste_js_function/zepto.js"></script>
<script src="<?php echo base_url(); ?>assets/webiste_js_function/sd.js"></script>

<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.3.0/socket.io.js"></script>


<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
<div class="modal-dialog modal-sm" role="document">
   <div class="modal-content">
      <div class="modal-body text-center">
         <div class="loader"></div>
         <div class="text-center">
            <div class="spinner-border" role="status">
               <span class="sr-only">Loading...</span>
            </div>
         </div>
         <div clas="loader-txt">
            <p>Your request has been sent to astrologer. <br><br><small>Please wait for astrologer acceptance.....</small></p>
         </div>
      </div>
   </div>
</div>
</div>

<div class="modal fade" id="accept_reject_model" tabindex="-1" role="dialog" aria-labelledby="loadMeLabel">
<div class="modal-dialog modal-sm" role="document">
   <div class="modal-content">
      <div class="modal-body text-center">
         <!-- <div class="loader"></div> -->
         <img src="avatar.png" alt="Avatar" class="avatar astrologer_image">


         <div clas="loader-txt">
            <p>Astrologer <span class="astrologer_name"></span> has been accepted. <br><br><small>Please accept request.....</small></p>
         </div>
         <ul class="list-inliine">
            <li class="list-inline-item">
               <button class="btn btn-smbtn-success" onclick="return accept_reject_user('1')">Accept</button>
            </li>
            <li class="list-inline-item">
               <button class="btn btn-smbtn-success" onclick="return accept_reject_user('2')">Reject</button>
            </li>
         </ul>
      </div>
   </div>
</div>
</div>

<script>
var user_idd = "<?= $this->session->userdata('user_id') ?>"
console.log(user_idd)

// const socket = io();
var socket_url = 'https://astrohelp24.com:5030'
var booking_data = {}
var astrologer_data = {}

var socket = io(socket_url, {
   transports: ['websocket']
});
socket.on('connect', () => {
   console.log('socket connected');

   socket.emit('get_booking_status', {
      user_id: user_idd
   })
   socket.on('get_booking_status', (rs) => {
      console.log(rs)
      if (rs.status) {
         const data = rs.data;
         const astrologer = rs.astrologer;
         booking_data = data

         if (data.is_accepted == 2) {
            astrologer_data = rs.astrologer

            $('#loadMe').modal('show');
         } else if (data.is_accepted == 0) {
            astrologer_data = rs.data.astrologer
            $('#loadMe').modal('hide');
            $('#accept_reject_model').modal('show');
            $('.astrologer_name').text(astrologer.name)
            $(".astrologer_image").attr("src", astrologer.imageUrl);



         }else if(data.is_accepted == 1){
            astrologer_data = rs.data.astrologer
            $('#loadMe').modal('hide');

            $('#accept_reject_model').modal('hide');
            // window.location.replace('<?=base_url('home/chat_new')?>')

         }else{
            $('#loadMe').modal('hide');

            $('#accept_reject_model').modal('hide');
         }
      } else {
         $('#loadMe').modal('hide');
         $('#accept_reject_model').modal('hide');
        


      }

   })


});

function accept_reject_user(what) {
   var obj = {};
   if (what == 1) {
      obj = {
         booking_id: booking_data.id,
         user_id: booking_data.user_id,
         what: 1
      }
   } else if (what == 2) {
      obj = {
         booking_id: booking_data.id,
         user_id: booking_data.user_id,
         what: 2
      }
   }
   console.log(obj)
   var socket2 = io(socket_url, {
      transports: ['websocket']
   });
   socket2.on('connect', () => {
      console.log('connected');

      socket2.emit('accept_reject_user_booking', obj)
   });

}




function chat_request(id, user_id, price) {
   var astrologer_id = id;
   var price_per_mint = price;
   var type = type;
   var user_id = user_id;

   const obj = {
      user_id,
      astrologer_id,
      price_per_mint,
      type: 3
   }

   var socket2 = io(socket_url, {
      transports: ['websocket']
   });
   socket2.on('connect', () => {
      console.log('socket connected');
      socket2.emit('astrologer_realtimebook', (obj))
      socket2.disconnect()
   });
   // socket.emit('end_puja',{booking_hist_id:id,user_id:user_id}) 



}
</script>

<?php //die; 
?>

<script>
// function modal() {
//    $('#loadMe').modal('show');
//    setTimeout(function() {
//       console.log('hejsan');
//       $('#loadMe').modal('hide');
//    }, 3000);
// }
// modal()
</script>




<div class="modal fade" id="open_member_model" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content">
      <div class="modal-header">
         <h5 class="modal-title" id="exampleModalLongTitle">Add Member</h5>
         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>
      <?php
      $userdata = $this->session->userdata('userdata');

      ?>
      <div class="modal-body">
         <form method="post">
            <div class="form-group">
               <label for="">Name</label>
               <input type="text" name="name" class="form-control" value="<?= $userdata ? $userdata->name : '' ?>" placeholder="Name" required>
            </div>
            <div class="form-group">
               <label for="">DOB</label>
               <input type="date" name="dob" class="form-control" value="<?= $userdata ? $userdata->dob : '' ?>" placeholder="DOB" required>
            </div>
            <div class="form-group">
               <label for="">Birth Time</label>
               <input type="time" name="tob" class="form-control" value="<?= $userdata ? $userdata->birth_time : '' ?>" placeholder="Birth Time" required>
            </div>
            <div class="form-group">
               <label for="">Birth Place</label>
               <input type="text" name="pob" class="form-control" value="<?= $userdata ? $userdata->place_of_birth : '' ?>" placeholder="Birth Place" required>
            </div>
            <div class="form-group">
               <input type="submit" value="Submit" class="btn btn-sm btn-primary">
            </div>
         </form>
      </div>
      <div class="modal-footer">
         <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
         <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
      </div>
   </div>
</div>
</div>


