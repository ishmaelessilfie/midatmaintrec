<?php
 include('maintsys.php');

$user = new maintsys();
?>
<?php include 'includes/header.php'; ?>
<body class="hold-transition login-page">
<div class="login-box">
  	<div class="login-logo">
  		<b>User - Login</b>
  	</div>
  	<div class="login-box-body">
    	<p class="login-box-msg">Sign in to start your session</p>
    	<form method="post" id="login_form">
      		<div class="form-group has-feedback">
        		<input type="text" class="form-control" name="email" id='email' placeholder="input Email Address" required data-parsley-type="email" data-parsley-trigger="keyup" autofocus>
        		<span class="glyphicon glyphicon-user form-control-feedback"></span>
      		</div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" name="password" id="password" placeholder="input Password" required data-parsley-trigger="keyup">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
      		<div class="row">
    			<div class="col-xs-4">
          			<button type="submit" class="btn btn-success btn-block" name="login" id="login_button"><i class="fa fa-sign-in"></i> Sign In</button>
        		</div>
            <div class="col-xs-3">
            <img src="img/sample.gif" class="spin" style="display:block;margin:-10px;margin-right:auto; margin-top:3px; height:30px; width:30px; display: none" alt="User Image" >
          </div>
      		</div>
    	</form>
<?php include 'includes/scripts.php' ?>

<script>
$(document).ready(function(){
  $('#login_form').parsley();
  $('#login_form').on('submit', function(event){
    $('#login_button').attr('disabled', true);
    event.preventDefault();
    if($('#login_form').parsley().isValid())
    {   
      $('.spin').css('display','block');
      $.ajax({
        url:"https://midatlanticmaintsys.herokuapp.com/login.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:'json',
        error: function(){
        $('#login_button').attr('disabled', false);
       $('.spin').css('display','none');
        swal("TimedOut!", "Request timeout. Please try again","error");
    },
        success:function(data)
        {
          if(data.error != '')
          {
            $('#login_button').attr('disabled', false);
            $('.spin').css('display','none');
            swal("Ooops..",data.error,"error");
          }
          else if(data.type=='Sait')
          {
            window.location.href = "<?php echo $user->base_url; ?>midatlantic";
          }else{
            window.location.href = "<?php echo $user->base_url; ?>home";
          }
        }, 
        timeout:10000
      })
    }
  });
});

</script>
