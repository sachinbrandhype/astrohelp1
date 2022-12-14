<?php if ($this->session->flashdata('message')) :

   $message = $this->session->flashdata('message');
?>
   <!-- <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title" id="exampleModalLabel"><?= $message['message'] ?></h5>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">


               <div class="modal-footer">
                  <button type="button" class="btn btn-success" data-dismiss="modal">Okay</button>
               </div>
            </div>
         </div>
      </div>
   </div> -->
<?php endif ?>




<!-- sort modal -->
<div class="modal fade modal-container11" id="sort" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Sort By</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="filter-widget">

               <!--     <div>
      <label class="payment-radio sort-radi">
      <input type="radio"  name="radio1"  id="radio1" onclick = "MyAlert()" checked="">
            <span class="checkmark"></span>
                   Popularity 
                   </label>
                    </div> -->

               <div>
                  <label class="payment-radio sort-radi">
                     <input type="radio" name="radio1" id="radio1" onclick="MyAlert()" value="exhightolow">
                     <span class="checkmark"></span>
                     Experience : High to Low
                  </label>
               </div>

               <div>
                  <label class="payment-radio sort-radi">
                     <input type="radio" name="radio1" id="radio1" onclick="MyAlert()" value="exlowtohigh">
                     <span class="checkmark"></span>
                     Experience : Low to High
                  </label>
               </div>



               <div>
                  <label class="payment-radio sort-radi">
                     <input type="radio" name="radio1" id="radio1" onclick="MyAlert()" value="pricehightolow">
                     <span class="checkmark"></span>
                     Price : High to Low
                  </label>
               </div>

               <div>
                  <label class="payment-radio sort-radi">
                     <input type="radio" name="radio1" id="radio1" onclick="MyAlert()" value="pricelowtohigh">
                     <span class="checkmark"></span>
                     Price : Low to High
                  </label>
               </div>

               <div>
                  <label class="payment-radio sort-radi">
                     <input type="radio" name="radio1" id="radio1" onclick="MyAlert()" value="ratinghightolow">
                     <span class="checkmark"></span>
                     Rating : High to Low
                  </label>
               </div>
               <div>
                  <label class="payment-radio sort-radi">
                     <input type="radio" name="radio1" id="radio1" onclick="MyAlert()" value="ratinglowtohigh">
                     <span class="checkmark"></span>
                     Rating : Low to High
                  </label>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<!-- end sort modal -->


<!-- filter modal -->


<!-- end filter modal -->

<!-- 

<div class="modal fade" id="myModalcancel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel"></h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <h2 id="ermsgcancel"></h2>
            <p class="text-muted" id="ermsg"></p>
            <div class="modal-footer">
               <span id="cancelbookingid"></span>
             
               <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
         </div>
      </div>
   </div>
</div> -->

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


<div class="modal fade" id="loadMe" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
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
            <div class="form-group">
               <button class="btn btn-sm btn-danger" onclick="return reject_request()">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>


<div class="modal fade" id="loadMe2" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
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
               <p>Your request has been sent to astrologer. <br><br><small>Please wait for astrologer acceptance you will get a call from astrologer shortly.....</small></p>
            </div>
            <div class="form-group">
               <button class="btn btn-sm btn-danger" onclick="return reject_audio()">Cancel</button>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="accept_reject_model" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
   <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
         <div class="modal-body text-center">
            <!-- <img src="avatar.png" alt="Avatar" class="avatar astrologer_image"> -->


            <div clas="loader-txt">
               <p>Astrologer <span class="astrologer_name"></span> has been accepted. <br><br><small>Please accept request.....</small></p>
            </div>
            <ul class="list-inliine">
               <li class="list-inline-item">
                  <button class="btn btn-sm btn-success" onclick="return accept_reject_user('1')">Accept</button>
               </li>
               <li class="list-inline-item">
                  <button class="btn btn-sm btn-danger" onclick="return accept_reject_user('2')">Reject</button>
               </li>
            </ul>
         </div>
      </div>
   </div>
</div>
<?php //die; 
?>


<script>
   var user_idd = "<?= $this->session->userdata('user_id') ?>"
   // console.log(user_idd)

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
      socket.emit('audio_booking_request', {
         user_id: user_idd
      })
      socket.on('get_booking_status', (rs) => {
         console.log(rs)
         var chaturl = "<?= base_url('home/chat_new') ?>";

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



            } else if (data.is_accepted == 1) {
               astrologer_data = rs.data.astrologer
               $('#loadMe').modal('hide');

               $('#accept_reject_model').modal('hide');
               if (window.location.href != chaturl) {
                  window.location.replace('<?= base_url('home/chat_new') ?>')
               }
               // 

            } else {
               $('#loadMe').modal('hide');

               $('#accept_reject_model').modal('hide');
               if (window.location.href == chaturl) {
                  window.location.replace('<?= base_url('home') ?>')

               }
            }
         } else {
            $('#loadMe').modal('hide');
            $('#accept_reject_model').modal('hide');
            if (window.location.href == chaturl) {
               window.location.replace('<?= base_url('home') ?>')

            }



         }

      })


      socket.on('audio_booking_request', (rs) => {
         // console.log('audio ',rs)
         if (rs.status) {
            const data = rs.data;
            booking_data = data
            $('#loadMe').modal('hide');
            $('#accept_reject_model').modal('hide');
            $('#loadMe2').modal('show');
         } else {
            $('#loadMe2').modal('hide');
         }

      })


   });

   // audio_booking_request

   function end_chat_session() {
      var obj = {
         booking_id: booking_data.id,
         user_id: booking_data.user_id
      }
      $.ajax({
         url: "<?php echo base_url('home/end_session'); ?>/" + booking_data.id,
         method: "POST",

         success: function(data) {
            var socket2 = io(socket_url, {
               transports: ['websocket']
            });
            socket2.on('connect', () => {
               console.log('connected');

               socket2.emit('end_live_session', obj)
            });



         }
      });




   }

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


   function add_member_user(id, user_id, price) {
      $('#open_member_model').modal('toggle')

   }

   $("#add_member_form").submit(function(event) {
      event.preventDefault()
      var formData = {
         name: $("#member_name").val(),
         dob: $("#member_dob").val(),
         pob: $("#member_pob").val(),
         tob: $("#member_tob").val(),
         latitude: '',
         longitude: ''
      };
      alert(JSON.stringify(formData));
      return;

      $.ajax({
         type: "POST",
         url: "<?= base_url('home/add_member') ?>",
         data: formData,
         dataType: "json",
         encode: true,
      }).done(function(data) {
         chat_request(id, user_id, price)
      });
   })

   function reject_request() {
      const user_id = "<?= $this->session->userdata('user_id') ?>"



      const obj = {
         user_id,
      }

      var socket2 = io(socket_url, {
         transports: ['websocket']
      });
      socket2.on('connect', () => {
         console.log('socket connected');
         socket2.emit('reject_request', (obj))
         socket2.disconnect()
      });
      // socket.emit('end_puja',{booking_hist_id:id,user_id:user_id}) 



   }

   function reject_audio() {
      const user_id = "<?= $this->session->userdata('user_id') ?>"



      const obj = {
         user_id,
         booking_id: booking_data.id
      }

      var socket2 = io(socket_url, {
         transports: ['websocket']
      });
      socket2.on('connect', () => {
         console.log('socket connected');
         socket2.emit('cancel_audio', (obj))
         socket2.disconnect()
      });
      // socket.emit('end_puja',{booking_hist_id:id,user_id:user_id}) 



   }



   function audio_request(id, user_id, price) {

      var astrologer_id = id;
      var price_per_mint = price;
      var type = type;
      var user_id = user_id;

      const obj = {
         user_id,
         astrologer_id,
         price_per_mint,
         type: 2
      }

      var socket2 = io(socket_url, {
         transports: ['websocket']
      });
      socket2.on('connect', () => {
         console.log('socket connected');
        const aa= socket2.emit('astrologer_realtimebook', (obj))
        $('#loadMe2').modal('show');

        console.log(aa);
         socket2.disconnect()
      });
      // socket.emit('end_puja',{booking_hist_id:id,user_id:user_id}) 



   }

   function chat_request(id, user_id, price,type=3) {

      var astrologer_id = id;
      var price_per_mint = price;
      var type = type;
      var user_id = user_id;

      const obj = {
         user_id,
         astrologer_id,
         price_per_mint,
         type: type
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
         $userdata = $this->applib->user_profile([]);
         $userdata = $userdata->status ? $userdata->data : false

         ?>
         <div class="modal-body">
            <!-- <form method="post" id="add_member_form"> -->
            <div class="form-group">
               <label for="">Name</label>
               <input type="text" name="name" id="member_name" class="form-control" value="<?= $userdata ? $userdata->name : '' ?>" placeholder="Name" required>
            </div>
            <div class="form-group">
               <label for="">DOB</label>
               <input type="date" name="dob" id="member_dob" class="form-control" value="<?= $userdata ? $userdata->dob : '' ?>" placeholder="DOB" required>
            </div>
            <div class="form-group">
               <label for="">Birth Time</label>
               <input type="time" name="tob" id="member_tob" class="form-control" value="<?= $userdata ? $userdata->birth_time : '' ?>" placeholder="Birth Time" required>
            </div>
            <div class="form-group">
               <label for="">Birth Place</label>
               <input type="text" name="pob" id="member_pob" class="form-control" value="<?= $userdata ? $userdata->place_of_birth : '' ?>" placeholder="Birth Place" required>
            </div>
            <div class="form-group">
               <button type="button" value="Submit" class="btn btn-sm btn-primary">Submit</button>
            </div>
            <!-- </form> -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
         </div>
      </div>
   </div>
</div>






<script type="text/javascript">
   $(document).ready(function() {
      $("#search-box").keyup(function() {
         var that = this,
            search = $(this).val();
         // alert(value);


         $.ajax({
            url: "<?php echo base_url('sdauth/filter_data'); ?>",
            method: "POST",
            data: {
               search: search,
               mode: 'chat'
            },
            success: function(data) {
               // console.log(data);
               $("#filter_data").html(data);
               $('.modal-container11').modal('hide');
               $(".hide_data").hide();



            }
         });


      });
   });
</script>


<script type="text/javascript">
   function MyAlert() {
      // alert("aa");
      var radio1 = $('input[type="radio"]:checked').val();
      // alert(radio1);



      var language = '';
      var speciality = '';
      var service = '';
      var gender = '';
      var country = '';

      $.ajax({
         url: "<?php echo base_url('sdauth/filter_data'); ?>",
         method: "POST",
         data: {
            language: language,
            speciality: speciality,
            service: service,
            gender: gender,
            country: country,
            sort_by: radio1,
            mode: 'chat'
         },
         success: function(data) {
            //var service = JSON.parse(data);
            // var obj = JSON.parse(data);
            // console.log(data);
            // alert(data);
            $("#filter_data").html(data);

            $('.modal-container11').modal('hide');

            // $("p")s.hide();
            $(".hide_data").hide();



         }
      });


   }
</script>



<script type="text/javascript">
   $('#cvDisburs').click(function() {

      // language
      var cbc = document.getElementsByName('language[]');
      var language = '';
      for (var i = 0; i < cbc.length; i++) {
         if (cbc[i].checked) language += (language.length > 0 ? "|" : "") + cbc[i].value;
      }
      // speciality
      var cbc_speciality = document.getElementsByName('speciality[]');
      var speciality = '';
      for (var i = 0; i < cbc_speciality.length; i++) {
         if (cbc_speciality[i].checked) speciality += (speciality.length > 0 ? "|" : "") + cbc_speciality[i].value;
      }
      // service
      var cbc_service = document.getElementsByName('service[]');
      var service = '';
      for (var i = 0; i < cbc_service.length; i++) {
         if (cbc_service[i].checked) service += (service.length > 0 ? "|" : "") + cbc_service[i].value;
      }

      // gender
      var cbc_gender = document.getElementsByName('gender[]');
      var gender = '';
      for (var i = 0; i < cbc_gender.length; i++) {
         if (cbc_gender[i].checked) gender += (gender.length > 0 ? "|" : "") + cbc_gender[i].value;
      }

      // country
      var cbc_country = document.getElementsByName('country[]');
      var country = '';
      var sort_by = '';
      for (var i = 0; i < cbc_country.length; i++) {
         if (cbc_country[i].checked) country += (country.length > 0 ? "|" : "") + cbc_country[i].value;
      }

      $.ajax({
         url: "<?php echo base_url('sdauth/filter_data'); ?>",
         method: "POST",
         data: {
            language: language,
            speciality: speciality,
            service: service,
            gender: gender,
            country: country,
            mode: 'chat',
            sort_by: sort_by
         },
         success: function(data) {
            //var service = JSON.parse(data);
            // var obj = JSON.parse(data);
            // console.log(data);
            // alert(data);
            $("#filter_data").html(data);

            $('.modal-container').modal('hide');

            // $("p")s.hide();
            $(".hide_data").hide();



         }
      });


   });
</script>



<script>
   document.onreadystatechange = function() {
      var state = document.readyState
      if (state == 'interactive') {
         document.getElementById('contents').style.visibility = "hidden";
      } else if (state == 'complete') {
         // setTimeout(function() {
         //    document.getElementById('interactive');
         //    document.getElementById('load').style.visibility = "hidden";
         //    document.getElementById('contents').style.visibility = "visible";
         // }, 1000);
      }
   }
</script>

<style>
   #load {
      width: 100%;
      height: 100%;
      position: fixed;
      z-index: 9999;
      background: url("https://astrohelp24.com/admin/uploads/unnamed.gif") no-repeat center center rgba(0, 0, 0, 0.25)
   }
</style>


<script>
   $(document).ajaxStart(function() {
      $("#loading").show();
      $("#loadingotp").show();
      $("#loadingotpforgetpwd").show();
      $("#loadingotppwd").show();
   }).ajaxStop(function() {
      $("#loading").hide();
      $("#loadingotp").hide();
      $("#loadingotpforgetpwd").hide();
      $("#loadingotppwd").hide();
   });

   <?php if ($this->session->flashdata('message')) : ?>
      $(window).on('load', function() {
         $('#myModal').modal('show');
      });
   <?php endif ?>


   $(document).ready(function() {
      $(".sd_one").hover(function() {
            $(this).css("background-color", "#cc0f73");
            $(".blog_cc_one").css("color", "#fff");
            $(".blog_tt_one").css("color", "#fff");
         },

         function() {
            $(this).css("background-color", "#fff");
            $(".blog_cc_one").css("color", "black");
            $(".blog_tt_one").css("color", "black");

         });

      $(".sd_two").hover(function() {
            $(this).css("background-color", "#cc0f73");
            $(".blog_cc_two").css("color", "#fff");
            $(".blog_tt_two").css("color", "#fff");
         },

         function() {
            $(this).css("background-color", "#fff");
            $(".blog_cc_two").css("color", "black");
            $(".blog_tt_two").css("color", "black");

         });

      $(".sd_three").hover(function() {
            $(this).css("background-color", "#cc0f73");
            $(".blog_cc_three").css("color", "#fff");
            $(".blog_tt_three").css("color", "#fff");
         },

         function() {
            $(this).css("background-color", "#fff");
            $(".blog_cc_three").css("color", "black");
            $(".blog_tt_three").css("color", "black");

         });

      $(".sd_four").hover(function() {
            $(this).css("background-color", "#cc0f73");
            $(".blog_cc_four").css("color", "#fff");
            $(".blog_tt_four").css("color", "#fff");
         },

         function() {
            $(this).css("background-color", "#fff");
            $(".blog_cc_four").css("color", "black");
            $(".blog_tt_four").css("color", "black");

         });

      <?php if (isset($_SESSION['user_id'])) : ?>
         <?php if ($_SESSION['user_id'] > 0) : ?>
            var apiurl = "<?= base_url('sdauth/GetUserdetails') ?>";
            $.ajax({
               url: apiurl,
               type: "POST",
               success: function(data) {
                  var final_v = '';
                  var wallet = 0;
                  if (data.length != '') {
                     var json = JSON.parse(data);
                     if (json['status'] == true) {
                        final_v = json['user_details'].wallet;
                     }
                     $("#wallet-detail-user").html(final_v);
                     // $("#chatbuttone").html(chat_button);
                  }
               },
            });
         <?php endif ?>
      <?php endif ?>

   });

   <?php if (isset($_SESSION['user_id'])) : ?>
      <?php if ($_SESSION['user_id'] > 0) : ?>

         function get_user_details() {
            var apiurl = "<?= base_url('sdauth/GetUserdetails') ?>";
            $.ajax({
               url: apiurl,
               type: "POST",
               success: function(data) {
                  var final_v = '';
                  var wallet = 0;
                  if (data.length != '') {
                     var json = JSON.parse(data);
                     if (json['status'] == true) {
                        final_v = json['user_details'].wallet;
                     }
                     $("#wallet-detail-user").html(final_v);
                     // $("#chatbuttone").html(chat_button);
                  }
               },
            });
         }
         // setInterval('get_user_details()', 10000);
      <?php endif ?>
   <?php endif ?>

   <?php if (isset($_SESSION['is_request'])) : ?>
      <?php if ($_SESSION['is_request'] == 1) : ?>
         $('#request-modal').modal({
            backdrop: 'static',
            keyboard: false
         });

         function checkrequest() {
            var apiurl = "<?= base_url('sdauth/checkrequest') ?>";
            $.ajax({
               url: apiurl,
               type: "POST",
               success: function(data) {
                  if (data.length != '') {
                     var json = JSON.parse(data);
                     if (json['status'] == true) {
                        if (json['flag'] == 2) {
                           $("#requesttile").html(json['title']);
                           var countDownDate = new Date(json['added_on']).getTime();
                           var now = new Date().getTime();
                           var distance = now - countDownDate;
                           var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                           var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                           var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                           var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                           document.getElementById("requesttimer").innerHTML = minutes + "m " + seconds + "s ";
                        } else {
                           window.location = "<?= current_url() ?>";
                        }
                     } else {
                        window.location = "<?= current_url() ?>";
                     }
                  } else {
                     window.location = "<?= current_url() ?>";
                  }
               },
            });
         }
         // setInterval('checkrequest()', 1000);
      <?php endif ?>
   <?php endif ?>
</script>



<script>
   // This example requires the Places library. Include the libraries=places
   // parameter when you first load the API. For example:
   // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

   function initMap() {
      var elementExists = document.getElementById("rz_location-map");
      if (elementExists) {

         var map = new google.maps.Map(document.getElementById('rz_location-map'), {
            center: {
               lat: -33.8688,
               lng: 151.2195
            },
            zoom: 13,
            mapTypeId: 'roadmap'
         });

         // Create the search box and link it to the UI element.
         var input = document.getElementById('rz_location-pac-input');
         var geocoder = new google.maps.Geocoder;

         var searchBox = new google.maps.places.SearchBox(input);
         map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

         // var searchBox = new google.maps.places.Autocomplete(input);
         // searchBox.setComponentRestrictions(
         // {'country': ['in']});

         // Bias the SearchBox results towards current map's viewport.
         map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
         });
         console.log(searchBox);


         var markers = [];
         // Listen for the event fired when the user selects a prediction and retrieve
         // more details for that place.
         searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
               return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
               marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
               if (!place.geometry) {
                  console.log("Returned place contains no geometry");
                  return;
               }
               var icon = {
                  url: place.icon,
                  size: new google.maps.Size(71, 71),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(17, 34),
                  scaledSize: new google.maps.Size(25, 25)
               };

               // Create a marker for each place.
               markers.push(new google.maps.Marker({
                  map: map,
                  icon: icon,
                  title: place.name,
                  position: place.geometry.location
               }));

               if (place.geometry.viewport) {
                  // Only geocodes have viewport.
                  bounds.union(place.geometry.viewport);
                  // document.getElementsByClassName('drop_lat').value = place.geometry.location.lat();
                  // document.getElementsByClassName('drop_lng').value = place.geometry.location.lng();
                  console.log(place)
                  $(".drop_lat").val(place.geometry.location.lat());
                  $(".drop_lng").val(place.geometry.location.lng());
               } else {
                  bounds.extend(place.geometry.location);
               }
            });
            map.fitBounds(bounds);
         });
      }
   }



   function initMap2() {
      var elementExists = document.getElementById("rz_location-map2");
      if (elementExists) {

         var map = new google.maps.Map(document.getElementById('rz_location-map2'), {
            center: {
               lat: -33.8688,
               lng: 151.2195
            },
            zoom: 13,
            mapTypeId: 'roadmap'
         });

         // Create the search box and link it to the UI element.
         var input = document.getElementById('rz_location-pac-input2');
         var geocoder = new google.maps.Geocoder;

         var searchBox = new google.maps.places.SearchBox(input);
         map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);

         // var searchBox = new google.maps.places.Autocomplete(input);
         // searchBox.setComponentRestrictions(
         // {'country': ['in']});

         // Bias the SearchBox results towards current map's viewport.
         map.addListener('bounds_changed', function() {
            searchBox.setBounds(map.getBounds());
         });
         console.log(searchBox);


         var markers = [];
         // Listen for the event fired when the user selects a prediction and retrieve
         // more details for that place.
         searchBox.addListener('places_changed', function() {
            var places = searchBox.getPlaces();

            if (places.length == 0) {
               return;
            }

            // Clear out the old markers.
            markers.forEach(function(marker) {
               marker.setMap(null);
            });
            markers = [];

            // For each place, get the icon, name and location.
            var bounds = new google.maps.LatLngBounds();
            places.forEach(function(place) {
               if (!place.geometry) {
                  console.log("Returned place contains no geometry");
                  return;
               }
               var icon = {
                  url: place.icon,
                  size: new google.maps.Size(71, 71),
                  origin: new google.maps.Point(0, 0),
                  anchor: new google.maps.Point(17, 34),
                  scaledSize: new google.maps.Size(25, 25)
               };

               // Create a marker for each place.
               markers.push(new google.maps.Marker({
                  map: map,
                  icon: icon,
                  title: place.name,
                  position: place.geometry.location
               }));

               if (place.geometry.viewport) {
                  // Only geocodes have viewport.
                  bounds.union(place.geometry.viewport);
                  // document.getElementsByClassName('drop_lat').value = place.geometry.location.lat();
                  // document.getElementsByClassName('drop_lng').value = place.geometry.location.lng();
                  console.log(place)
                  $(".drop_lat2").val(place.geometry.location.lat());
                  $(".drop_lng2").val(place.geometry.location.lng());
               } else {
                  bounds.extend(place.geometry.location);
               }
            });
            map.fitBounds(bounds);
         });
      }
   }


   function initmapdata() {
      initMap()
      initMap2()
   }
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD7BIoSvmyufubmdVEdlb2sTr4waQUexHQ&libraries=places&region=in&callback=initmapdata">
</script>