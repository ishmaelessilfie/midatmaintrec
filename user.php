<?php
include('maintsys.php');

$user = new maintsys();

if(!$user->is_login())
{
  header("location:".$user->base_url."");
}
if(!$user->is_master_user())
{
  header("location:".$user->base_url."index.php");
}

?>

<?php include 'includes/header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php include 'includes/navbar.php'; ?>
  <?php include 'includes/menubar.php'; ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User Management
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">User</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a id="add_user" data-toggle="modal" class="btn btn-primary btn-sm btn"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              
              <table class="table table-striped table-bordered table-responsive" id="userList">

                <thead>
                   <th>Photo</th>
                  <th>Full name</th>
                  <th>User Contact No.</th>
                  <th>User Email</th>
                  <th>User Type</th>
                  <th>Created On</th>
                  <!-- <th>user status</th> -->
                  <th>Action</th>
                </thead>
                <tbody>
               
                </tbody>

              </table>
            
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div> 
  <?php include 'includes/footer.php'; ?>
  <?php include 'includes/user_modal.php'; ?>
  <?php include 'includes/loader.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$(document).ready(function(){
var dataTable = $('#userList').DataTable({
		"processing" : true,
		"serverSide" : true,
		"order" : [],
		"ajax" : {
			url:"user_action",
			type:"POST",
			data:{action:'fetch'}
		},
		"columnDefs":[
			{
				"targets":[0, 5],
				"orderable":false,
			},
		],
	});


$('#add_user').click(function(){
		$('#user_form')[0].reset();
		$('#user_form').parsley().reset();
    	$('#modal_title').text('Add User');
    	$('#action').val('Add');
    	$('#submit_button').val('Add');
    	$('#userModal').modal('show');
    	$('#password').attr('required', true);
	    $('#password').attr('data-parsley-minlength', '6');
	    $('#password').attr('data-parsley-maxlength', '16');
	    $('#password').attr('data-parsley-trigger', 'keyup');
	});

	$('#photo').change(function(){
		var extension = $('#photo').val().split('.').pop().toLowerCase();
		if(extension != '')
		{
			if($.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
			{
				swal("ooops!", "Invalid Image File","error");
				$('#photo').val('');
				return false;
			}
		}
	});

	$('#user_form').parsley();

	$('#user_form').on('submit', function(event){
		$('.loader').modal('show');
		event.preventDefault();
		if($('#user_form').parsley().isValid())
		{		
			var extension = $('#photo').val().split('.').pop().toLowerCase();
			if(extension != '')
			{
				if($.inArray(extension, ['gif','png','jpg','jpeg']) == -1)
				{
					swal("ooops!", "Invalid Image File","error");
					$('#photo').val('');
					return false;
				}
			}
			$.ajax({
				url:"user_action.php",
				method:"POST",
				data:new FormData(this),
				contentType:false,
				processData:false,
                dataType:'json',

				error: function(){
					$('.loader').modal('hide');
					swal("Error!", "Request Timedout","error");
				},
				success:function(data)
				{
					// alert(data.error);
					if(data.error != ''){
					$('.loader').modal('hide');	
					swal("Info", data.error ,"info");
					
					}else{
					
					$("#userModal").modal('hide');
					$('.loader').modal('hide');
					swal("Good Job", data.success,"success",{closeOnClickOutside: false, allowEscapeKey:false});
					dataTable.ajax.reload();
					}
					// var data = JSON.stringify({
     //  "password": data.password,
     //  "email": $('#email').val()      });
					// alert(data);

		// 	$.ajax({
		// 	url:'email.php',
		// 	type:'post',
		// 	data:data,
		// 	success:function(result){
		// 		alert(result);
		// 	}
		// });
				},
				timeout: 10000
			})
		}
	});


$(document).on('click', '.delete_button', function(){
		var id = $(this).data('id');
		var status = $(this).data('status');
		var next_status = 'Enable';
		if(status == 'Enable')
		{
			next_status = 'Disable';
		}
    	 swal({
    	// closeOnClickOutside:false,
        title: "Are you sure?",
        text: "You want to "+next_status+" user?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(function (willdelete) {
    	
      if(willdelete){
      	$('.loader').modal('show');
            $.ajax({
    			url:"user_action.php",
    			method:"POST",
    			data:{id:id, action:'delete', status:status, next_status:next_status},
    			error: function(){
						$('.loader').modal('hide');
						swal("Error!", "Request Timedout","error");
    			},
    			success:function(data)
                 {
                 	$('.loader').modal('hide');
                    swal(""+next_status+"d!", "User "+next_status+"d Successfully","success",{allowOutsideClick:false});
                    dataTable.ajax.reload();
                    
                },
                timeout: 10000 
      });
          }
});
  	});

$(document).on('click', '.delete_user_button', function(){
		var id = $(this).data('id');
	
    	 swal({
        title: "Are you sure?",
        text: "You won't be able to recover this data!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(function (willdelete) {
    	
      if(willdelete){
      	$('.loader').modal('show');
            $.ajax({
    			url:"user_action.php",
    			method:"POST",
    			data:{id:id, action:'delete_user'},
    			error: function(){
						$('.loader').modal('hide');
						swal("Error!", "Request Timedout","error");
    			},

    			success:function(data)
                 {
                 	$('.loader').modal('hide');
                    swal("Deleted!", "Your imaginary file has been deleted","success");
                    dataTable.ajax.reload();
                },
                timeout:10000
      });
          }
});
  	});

$(document).on('click', '.edit_button', function(){
		var id = $(this).data('id');

		$('#user_form').parsley().reset();
		$.ajax({
	      	url:"user_action.php",
	      	method:"POST",
	      	data:{id:id, action:'fetch_single'},
	      	dataType:'JSON',
	      	success:function(data)
	      	{
	        	$('#name').val(data.name);
	        	$('#user_email').val(data.user_email);
	        	$('#contact').val(data.contact);
	        	$('#email').val(data.email);
	        	$('#type').val(data.type);

	        	$('#user_uploaded_image').html('<img src="'+data.photo+'" class="img-fluid img-thumbnail" width="75" height="75" /><input type="hidden" name="hidden_user_image" value="'+data.photo+'" />');

	        	$('#password').attr('required', false);

	    $('#password').attr('data-parsley-minlength', '6');

	    $('#password').attr('data-parsley-maxlength', '16');

	    $('#password').attr('data-parsley-trigger', 'keyup');
	        	
	        	$('#modal_title').text('Edit User');
	        	$('#action').val('Edit');
	        	$('#submit_button').val('Edit');
	        	$('#userModal').modal('show');
	        	$('#hidden_id').val(id);

	      	}
	    })
	});

});
</script>
</body>
</html>
