<?php

// $booking_data = $this->db->query("SELECT * FROM `bookings` WHERE `user_id` = '" . $this->session->userdata('user_id') . "' AND `type` IN ('3') AND `booking_type`='2' AND `status` = 6 LIMIT 1")->row();
// print_r($booking_data);
//    die;
$booking_data = $booking_details;

if ($booking_data) {
   
   $astrologer_data = $booking_details->astrologer;
   $user_data = $user_data;
   $end_time = $booking_data->schedule_date_time;
?>

   <script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-app.js"></script>
   <!-- include firebase database -->
   <script src="https://www.gstatic.com/firebasejs/6.6.1/firebase-database.js"></script>
   <script>
      // Your web app's Firebase configuration

//       apiKey: "AIzaSyAckdfBrLzrau4PvvdxrH-Zc8tRlF8Wg1o",
//   authDomain: "dummyproject-eb28c.firebaseapp.com",
//   projectId: "dummyproject-eb28c",
//   storageBucket: "dummyproject-eb28c.appspot.com",
//   messagingSenderId: "599992454067",
//   appId: "1:599992454067:web:429e2a81750a32a37319c6",
//   measurementId: "G-BC42HHPDV6"


      var firebaseConfig = {
         apiKey: "AIzaSyCclp8O4gDizbZFvRBxVlTRp1Slyf8LFig",
         authDomain: "astrohelp24-75109.firebaseapp.com",
         databaseURL: "https://astrohelp24-75109-default-rtdb.firebaseio.com",
         projectId: "astrohelp24-75109",
         storageBucket: "astrohelp24-75109.appspot.com",
         messagingSenderId: "318372956157",
         appId: "1:318372956157:web:0ef9dafee9ed0dc9357b94"
      };

      if (!firebase.apps.length) {
         // firebase.initializeApp({});
         // Initialize Firebase
         firebase.initializeApp(firebaseConfig);

      }


      // Initialize Firebase
      // firebase.initializeApp(firebaseConfig);

      // var myName = prompt("Enter your name");
      var myName = 'Admin';
   </script>
   <div class="content">
      <section>
         <div class="container-fluid">
            <!-- <h2 class="mb-5">
            My Chats
            </h2> -->
            <div class="row">
               <div class="page-content col-lg-12 mb-12 mb-lg-0">
                  <div class="page-content-inner">
                     <div class="chat-window">
                        <!-- Chat Right -->
                        <div class="chat-cont-right">
                           <div class="chat-header">
                              <a id="back_user_list" href="javascript:void(0)" class="back-user-list">
                                 <i class="fas fa-chevron-left body-grey-color"></i>
                              </a>
                              <div class="media">
                                 <div class="media-img-wrap">
                                    <div class="avatar avatar-online">
                                       <img src="<?=  $astrologer_data->imageUrl ?>" alt="User Image" class="avatar-img rounded-circle">
                                    </div>
                                 </div>
                                 <div class="media-body">
                                    <div class="user-name"><?php echo $astrologer_data->name; ?></div>
                                    <div class="user-status">online</div>
                                 </div>
                              </div>
                              <h4 class="time-left">
                                 Time Left:
                                 <span class="time-count">
                                    <p id="timer-new"></p>
                                 </span>
                              </h4>
                              <button type="button" class="btn btn-sm btn-danger" onclick="return end_chat_session()" >End Chat</button>
                           </div>
                           <div class="chat-body">
                              <div class="chat-scroll">
                                 <ul class="list-unstyled" id="messages">
                                 </ul>
                              </div>
                           </div>
                           <div class="chat-footer" id="chat_id">
                              <form onsubmit="return sendMessage();" id="chat_div" style="width:100%;">
                                 <div class="input-group">
                                    <div class="input-group-prepend">
                                       <div class="btn-file btn sen-bt">
                                          <i class="fa fa-paperclip"></i>
                                          <input type="file" accept="image/*" name="file" id="file" onchange="return uploadFile(event);" />
                                       </div>
                                    </div>
                                    <input type="text" id="message" class="input-msg-send form-control" autocomplete="off" placeholder="Type something">
                                    <div class="input-group-append arr-bt">
                                       <button type="submit" class="btn msg-send-btn"><i class="fab fa-telegram-plane"></i></button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                        <!-- /Chat Right -->

                        <!--                       <input type="button"  name="end" value="end" onchange="return checkbookingend(event);" />
 -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </div>
   <script>
       function startTimer(duration, display) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = minutes + ":" + seconds;

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}
window.onload = function () {
    var fiveMinutes = parseInt('<?=$booking_details->remaining_time?>'),
        display = document.querySelector('#timer-new');
    startTimer(fiveMinutes, display);
};
      function sendMessage() {
         // get message
         var message = document.getElementById("message").value;

         // save in database
         var dict = {
            _id: <?php echo $user_data->id; ?>,
            name: "<?php echo $user_data->name; ?>"
         }
         firebase.database().ref().child("chat/" + '<?php echo $booking_data->bridge_id; ?>').push().set({

            "anotherid": "<?php echo $astrologer_data->id; ?>",
            "user_id": "<?php echo $user_data->id; ?>",
            "text": message,
            "createdAt": "<?= date('Y-m-d H:i:s') ?>",
            "user": dict,
            "status": false,
            "image": ""

         });
         document.getElementById('message').value = "";

         // prevent form from submitting
         return false;
      }
   </script>
   <script>
      // listen for incoming messages

      firebase.database().ref().child("chat/" + '<?php echo $booking_data->bridge_id; ?>').on("child_added", function(snapshot) {
         // console.log(snapshot.key);
         var html = "";
         // if (snapshot.val().sender == myName || snapshot.val().sender == 'admin') {
         // give each message a unique ID

         // show delete button if message is sent by me
         var admin_user_id = '<?php echo $user_data->id; ?>';
         if (snapshot.val().anotherid == admin_user_id) {
            html += "<li class='media received' id='message-" + snapshot.key + "'><div class='media-body'><div class='msg-box'><div>";
            html += "<p> " + snapshot.val().text + "</p>";
            if (snapshot.val().image) {
               html += "<img width=150 src=" + snapshot.val().image + "></img>";
            }
            html += "<ul class='chat-msg-info'><li><div class='chat-time'><span> " + snapshot.val().createdAt + "</span></div></li></ul></div>";
            html += "</li>";
         } else {
            html += "<li class='media sent' id='message-" + snapshot.key + "'><div class='media-body'><div class='msg-box'><div>";
            html += "<p> " + snapshot.val().text + "</p>";
            if (snapshot.val().image) {
               html += "<img width=150 src=" + snapshot.val().image + "></img>";
            }
            html += "<ul class='chat-msg-info'><li><div class='chat-time'><span> " + snapshot.val().createdAt + "</span></div></li></ul></div>";
            html += "</li>";
         }

         document.getElementById("messages").innerHTML += html;
         // }
      });

      function deleteMessage(self) {
         // get message ID
         var messageId = self.getAttribute("data-id");

         // delete message
         firebase.database().ref("messages").child(messageId).remove();
      }

      // attach listener for delete message
      firebase.database().ref("messages").on("child_removed", function(snapshot) {
         // remove message node
         document.getElementById("message-" + snapshot.key).innerHTML = "This message has been removed";
      });
   </script>
   <script>
      // Set the date we're counting down to
      //var countDownDate = new Date("March 6, 2021 18:10:25").getTime();
      var countDownDate = new Date('<?php echo $end_time; ?>').getTime();

      // Update the count down every 1 second
      var x = setInterval(function() {

         // Get today's date and time
         var now = new Date().getTime();

         // Find the distance between now and the count down date
         var distance = now - countDownDate;

         // Time calculations for days, hours, minutes and seconds
         var days = Math.floor(distance / (1000 * 60 * 60 * 24));
         var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
         var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
         var seconds = Math.floor((distance % (1000 * 60)) / 1000);
         // var m = "<?php echo $booking_data->time_minutes; ?>";
         //var s ='10';
         // Output the result in an element with id="demo" //days + "d " + hours + "h " +
         document.getElementById("demo").innerHTML = minutes + "m " + seconds + "s ";

         // If the count down is over, write some text 
         if (distance < 0) {
            $("#chat_id").hide();
            clearInterval(x);
            document.getElementById("demo").innerHTML = "EXPIRED";
         }
      }, 1000);

      function uploadFile(e) {
         var form = $('#chat_div')[0];
         var formData = new FormData(form);
         $.ajax({
            url: "<?php echo base_url('sdauth/save_file'); ?>", // your request url
            data: formData,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function(data) {
               // console.log(data);
               //$("#message").html('<img src="'+data+'" width=25 />');
               var html = '<li class="media sent"><div class="media-body"><div class="msg-box"><div><a href="' + data + '" target="_blank"><img src="' + data + '" width=150 /></a></div></div></li>';
               //document.getElementById("messages").innerHTML += html;

               var dict = {
                  _id: "<?php echo $user_data->id; ?>",
                  name: "<?php echo $user_data->name; ?>"
               }
               firebase.database().ref().child("chat/" + '<?php echo $booking_data->bridge_id; ?>').push().set({

                  "anotherid": "<?php echo $booking_data->user_id; ?>",
                  "user_id": "<?php echo $user_data->id; ?>",
                  "text": "Attachment",
                  "createdAt": "<?= date('Y-m-d H:i:s') ?>",
                  "user": dict,
                  "status": false,
                  "image": data

               });

            },
            error: function() {

            }
         });
      }

   </script>


<?php
} else {
   redirect(base_url());
}
?>
<!-- /Page Content -->