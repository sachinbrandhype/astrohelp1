$('div');
Zepto(function ($) 
{
	// var base_url = 'http://139.59.25.187/';
	var base_url = 'https://astrohelp24.com/';
	$('#err_msg').hide();
	$('#err_msg2').hide();
	$('#tc_err').hide();
	$('#error_message').hide();
	$("#error_message_reply").hide()


	$(document).on('ajaxStart', function(e, xhr, options){
	 	$("#loading").show();
        $("#appointment_struc").hide();
        $("#comment_loader").show();
        $("#reply_loader").show();

        // console.log('ajax_start');
	 	
	  // This gets fired for every Ajax request performed on the page.
	  // The xhr object and $.ajax() options are available for editing.
	  // Return false to cancel this request.
	})

	$(document).on('ajaxStop', function(e, xhr, options){
	 	$("#loading").hide();
	 	$("#comment_loader").hide();
        $("#reply_loader").hide();


        // console.log('ajax_stop');

	 	
	  // This gets fired for every Ajax request performed on the page.
	  // The xhr object and $.ajax() options are available for editing.
	  // Return false to cancel this request.
	})
	
	// Login
	$('#content').on('click', function(e){ 
		var email = $("#email_phone").val();
		var password = $("#loginPassword").val();
		var back_link = '';//$("#back_link").val();
		if (email != '' || password != '') 
		{
			var apiurl = base_url+"Login";
			$.post(apiurl, { phone: email, password: password,back_link: back_link} , function(response){
			 if (response == 1) 
			 {
			 	if (back_link != '') 
			 	{
			 		window.location=base_url+'home/login';//back_link;
			 	}
			 	else
			 	{
			 		window.location=base_url+'home';
			 	}
			 }
			 else
			 {
			 	$('#err_msg2').show();
			 	$('#err_msg').hide();
			 } 
			});	
		}
		else
		{
			$('#err_msg').show();
			$('#err_msg2').hide();
		}
		
	})

	// Forget Password
	$('#content2').on('click', function(e){ 
		var email = $("#emailAddress").val();
		if (email != '') 
		{
			var apiurl = base_url+"Forget";
			$.post(apiurl, { email: email} , function(response){
			 if (response == 0) 
			 {
			 	var error_message = '* Not found any account!';
		 		$( "#error_message_shown_forget" ).html( error_message );
		 	 }
			 else
			 {
			 	var f = $.parseJSON(response)
			 	if (f['status'] == true) 
			 	{
			 		$("#forgetpage").hide();
			 		$("#forgetotp").show();
			 		var tokeid = '<input type="hidden" id="main_token_for_forget_pwd" value="'+f['token']+'" name="_token">';
			 		$( "#tokenforgetpwd" ).html( tokeid );
			 		var otp = f['otp'];
			 		$( "#viewotpforgetpwd" ).html( otp );
			 	}
			 	else
			 	{
			 		var error_message = '* Something Error Happen Please try again later';
			 		$( "#error_message_shown" ).html( error_message );
			 	}
			 } 
			});	
		}
		else
		{
			var error_message = '* Something Error Happen Please try again later';
			$( "#error_message_shown" ).html( error_message );
		}
		
	})

	// Resend OTP
	$('#content23').on('click', function(e){ 
		var _token = $("#main_token_for_forget_pwd").val();
		var apiurl = base_url+"ResendOtp";
		$.post(apiurl, { _token: _token} , function(response){
		 if (response == 1) 
		 {
		 	$("#loadingotpforgetpwd").hide();
		 	var error_message = '* OTP Resend Successfully';
		 	$( "#error_message_shown_forget_two" ).html( error_message );
	 		var tokeid = '<input type="hidden" id="main_token_for_change_pwd" value="'+_token+'" name="_token">';
	 		$( "#tokenchangepwd" ).html( tokeid );
	 	 }	 
	 	 else
	 	 {
	 		var error_message = '* Something Error Happen Please try again later';
	 		$( "#error_message_shown" ).html( error_message );
	 	 }
		});
		
	})

	// Verify otp forget OTP
	$('#content23456').on('click', function(e){ 
		var otp = $("#ipotpfwd").val();
		var _token = $("#main_token_for_forget_pwd").val();
		if (otp != '') 
		{
			var apiurl = base_url+"Otpverifypwd";
			$.post(apiurl, { otp: otp, _token: _token} , function(response){
			 if (response == 1) 
			 {
			 	$("#forgetotp").hide();
		 		$("#changepasswordotp").show();
		 		$("#loadingotppwd").hide();
		 		var tokeid = '<input type="hidden" id="main_token_for_change_pwd" value="'+_token+'" name="_token">';
		 		$( "#tokenchangepwd" ).html( tokeid );
		 	 }
			 else
			 {
			 	var error_message = '* Something error happen please try again later';
			 	$("#error_message_shown_forget_three").html(error_message);
			 } 
			});
			
		}
		else
		{
			var error_message = '* Something error happen please try again later';
			$("#error_message_shown_forget_three").html(error_message);
		}
		
	})

	// Change Password
	$('#content234').on('click', function(e){ 
		var password = $("#newpassword").val();
		var newconfirmpassword = $("#newconfirmpassword").val();
		var _token = $("#main_token_for_change_pwd").val();
		if (password == newconfirmpassword) 
		{
			if (_token != '' || password != '') 
			{
				var apiurl = base_url+"Change-password";
				$.post(apiurl, { password: password, _token: _token} , function(response){
				 if (response == 1) 
				 {
				 	window.location=base_url+'HOME';
				 }
				 else
				 {
				 	var error_message = '* Something Error Happen Please try again later';
	 			    $( "#error_message_shown_forget_three" ).html( error_message );
				 } 
				});
				
			}
			else
			{
				var error_message = '* Something Error Happen Please try again later';
	 			$( "#error_message_shown_forget_three" ).html( error_message );
			}
		}
		else
		{
			var error_message = '* Password not matched!';
	 		$( "#error_message_shown_forget_two" ).html( error_message );
		}
	})

	// Registration
	$('#content4').on('click', function(e){ 
		// alert("xcxc");
		var fullname = $("#newName").val();
		var email = $("#newEmail").val();
		var password = $("#newPassword").val();
		var mobile = $("#newMobile").val();
		var gender = $("#newGender").val();
		var tc = $("#tc").val();
		if (tc != '') 
		{
			if (fullname != '' && email != '' && password != '' && mobile != '' && gender != '') 
			{
			  if(email== ''){
		          $('#email').next().show();
		          return false;
		        }
		        if(IsEmail(email)==false){
		        	var error_message = '* Invalid Email Id';
				 	$( "#error_message_shown" ).html( error_message );
		          return false;
		        }

		        var validateMobNum= /^\d*(?:\.\d{1,2})?$/;

		        if (validateMobNum.test(mobile ) && mobile.length == 10) 
		        {
				    //alert("Valid Mobile Number");
				}
				else {
					var error_message = '* Invalid Mobile Number';
		        		$( "#error_message_shown" ).html( error_message );
		          return false;
				   
				}

				var apiurl = base_url+"Registration";
				$.post(apiurl, { name: fullname, email: email ,password: password, phone: mobile,gender:gender} , function(response){
				 if (response == 1) 
				 {
				 	var error_message = '* Email already registered';
				 	$( "#error_message_shown" ).html( error_message );
				 }
				 else if(response == 2)
				 {
				 	var error_message = '* Mobile number already registered';
				 	$( "#error_message_shown" ).html( error_message );
				 	// $('#err_msg2').show();
				 }
				 else if(response == 3)
				 {
				 	var error_message = '* Something Error Happen Please try again later';
				 	$( "#error_message_shown" ).html( error_message );
				 }
				 else if(response == 123)
				 {
				 	$("#error_message").show()
				 	var error_message = '* Already have a account!@';
				 	$( "#error_message" ).html( error_message );
				 }
				 else
				 {
				 	console.log(response);
				 	
				 	var f = $.parseJSON(response)
				 	if (f['status'] == true) 
				 	{
				 		$("#register-row").hide();
				 		$("#otpscreen").show();
				 		var tokeid = '<input type="hidden" id="main_token" value="'+f['token']+'" name="_token">';
				 		$( "#token" ).html( tokeid );
				 		var otp = f['otp'];
				 		$( "#viewotp" ).html( otp );
				 	}
				 	else
				 	{
				 		var error_message = '* Something Error Happen Please try again later';
				 		$( "#error_message_shown" ).html( error_message );
				 	}
				 	// window.location='otp-verification.php?_token='+f['stringp'];
				 } 
				});
			}
			else
			{
				$("#error_message_shown").html("All fileds required1111!");
			}
		}
		else
		{
			$("#error_message_shown").html("All fileds required1!");
		}
		
	})

function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  if(!regex.test(email)) {
    return false;
  }else{
    return true;
  }
}
	// OTP Verify
	// Change Password
	$('#content5').on('click', function(e){ 
		var otp = $("#ipotp").val();
		var _token = $("#main_token").val();
		if (otp != '') 
		{
			var apiurl = base_url+"Otpverify";
			$.post(apiurl, { otp: otp, _token: _token} , function(response){
			 if (response == 1) 
			 {
			 	var error_message = '* OTP is wrong please try again';
			 	$("#error_message_shown_two").html(error_message);
			 }
			 else if(response == 2)
			 {
			 	var error_message = '* Something error happen please try again later';
			 	$("#error_message_shown_two").html(error_message);
			 }
			 else if(response == 3)
			 {
			 	window.location=base_url+'HOME';
			 }
			 else if(response == 0)
			 {
			 	var error_message = '* Something error happen please try again later';
			 	$("#error_message_shown_two").html(error_message);
			 }
			 else
			 {
			 	var error_message = '* Something error happen please try again later';
			 	$("#error_message_shown_two").html(error_message);
			 } 
			});
			
		}
		else
		{
			var error_message = '* OTP required';
		 	$("#error_message_shown_two").html(error_message);
		}
		
	})


	// Resend OTP
	$('#content6').on('click', function(e){ 
		var _token = $("#main_token").val();
		var apiurl = base_url+"ResendOtp";
		$.post(apiurl, { _token: _token} , function(response){
		 console.log(response);
		 if (response == 1) 
		 {
		 	var error_message = '* OTP Resend Successfully';
		 	$( "#error_message_shown_two" ).html( error_message );
		 }
		 else
		 {
		 	var error_message = '* Something error happen please try again later';
		 	$( "#error_message_shown_two" ).html( error_message );
		 } 
		});
		
	})

	//Comment Added
	$('#cancel_comment1').on('click', function(e){ 
		// console.log(cancel_comment1);
		var name = $("#name").val();
		var email = $("#email").val();
		var u_id = $("#u_id").val();
		var message = $("#message").val();
		var news_id = $("#news_id").val();
		$('#message').prop("required", true);
		if (message != '' || name != '' || email != '') 
		{
			$.post('insert_comment.php', { name: name,email: email,u_id: u_id,message: message,news_id: news_id} , function(response){
			 console.log(response);
			 if (response != 0) 
			 {
			 	alert("Successfully Comment Added!");
			 	window.location='news_detail.php?id='+news_id;
			 }
			 else
			 {
			 	$("#error_message").show()
			 	var error_message = '* Something error happen please try again later';
			 	$( "#error_message" ).html( error_message );
			 } 
			});
		}
		else
		{
			$("#error_message").show()
			var error_message = 'All fields are required';
			$( "#error_message" ).html( error_message );
		}

		
		
	})

	//Comment Reply Added
	$('#cancel_comment2').on('click', function(e){ 
		// console.log(cancel_comment1);
		var reply_comment = $("#reply_comment").val();
		var comment_id = $("#comment_id").val();
		var news_id = $("#news_r_id").val();
		var u_id = $("#u_id2").val();
		if (name != '' || comment_id != '' || u_id != '') 
		{
			$.post('insert_comment_reply.php', {news_id: news_id, reply_comment: reply_comment,comment_id: comment_id,u_id: u_id} , function(response){
			 console.log(response);
			 if (response != 0) 
			 {
			 	alert("Successfully Added Your Reply!");
			 	window.location='news_detail.php?id='+news_id;
			 }
			 else
			 {
			 	$("#error_message").show()
			 	var error_message = '* Something error happen please try again later';
			 	$( "#error_message" ).html( error_message );
			 } 
			});
		}
		else
		{
			$("#error_message_reply").show()
			var error_message = 'All fields are required';
			$( "#error_message_reply" ).html( error_message );
		}

		
		
	})

	


	
     


	
})

