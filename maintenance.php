<?php
include('maintsys.php');

$user = new maintsys();

if(!$user->is_login())
{
  header("location:".$user->base_url."");
}

if(!($user->is_master_user()|| $user->is_tech()))
{
  header("location:".$user->base_url."home");
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
        Maintenance
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Maintenance</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a id="add_maintenance" data-toggle="modal" class="btn btn-primary btn-sm btn"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              
              <table id="maintenanceList" class="table  table-striped table-responsive">
                <thead>
                  <th>Date</th>
                  <th>Type</th>
                  <th>Serial No</th>
                  <th>Branch</th>
                  <th>Venue</th>
                  <th>Status</th>
                  <?php
                  if($user->is_master_user()){
                  echo "<th>Worked_On_By</th>";
                      }
                  ?>
                  
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
  <?php include 'includes/maintenance_modal.php'; ?>
  <?php include 'includes/loader.php';?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
  $('#maintenanceList').DataTable({
    "processing" : true,
    "serverSide" : true,
    "order" : [],
    "ajax" : {
      url:"action.php",
      type:"POST",
      data:{action:'fetch_maintenance'}
    },
  });
   $('#add_maintenance').click(function(){
    $('#maintenanceForm')[0].reset();
    $('#action').val('add_maintenance');
    $('#addnew').modal('show');

  });

  $('#maintenanceForm').on('submit', function(event){
    event.preventDefault(); 
    $('.loader').modal('show');  
      $.ajax({
        url:"action.php",
        method:"POST",
        data:$(this).serialize(),
        dataType:'json',
        error: function(){
          $('.loader').modal('hide');
          swal("TimedOut!", "Request timeout. Please try again","error");
        },
        success:function(data)
        {
          if(data.error != '')
          {
            $('.loader').modal('hide');
             swal("Good Job!", data.error, "info");
          }else{
            $('.loader').modal('hide');
            swal("Good Job!", data.success, "success");
           $("#maintenanceList").DataTable().ajax.reload();
           $('#addnew').modal('hide');
 
          }
        },
        timeout: 10000
      });
  });

$("#ispart_replaced").change(function(){
  var value = $('#ispart_replaced').val();
    if (value == "No") {
      $('#part_replaced').prop('required',false);
      $('#part_replaced').val('');
       $('#replace').hide();
    }else if(value == "Yes"){
      $('#replace').show();
    }else{
      $('#replace').hide();
      $('#part_replaced').val('');
      $('#part_replaced').prop('required',false);
    }
  });

$("#status").change(function(){
  var value = $('#status').val();
    if (value == "Good") {
      $('#problem').hide();
      $('#problem_statement').val('');
      $('#problem_statement').prop('required',false);
    }else if(value=="Faulty"){
      $('#problem').show(); 
    }else{
      $('#problem').hide();
      $('#problem_statement').prop('required',false);
    }
  });

$("#machine").change(function(){
  var id = this.value;
  // alert(id);
  machineVal = $('#machine').val();
   $('.spin').css('display','block');
  $('#brand').val('');
       if(machineVal ==""){
        $('.spin').css('display','none');
       $('#original_branch').val('');
       $('#type').val('');
       $('#hidden_brand').val('');
       $('#hidden_original_branch').val('');
       $('#description').hide();
     }else{
      
  $.ajax({
    type: 'POST',
    url: 'action.php',
    data: {id:id,action:'fetch_single'},
    dataType: 'json',
    error: function(){
       $('.spin').css('display','none');
        swal("TimedOut!", "Request timeout. Please try again","error");
    },
    success: function(response){
      $('.spin').css('display','none');
      // alert(response.branch_name);
      $('#brand').val(response.brand_name);
      $('#original_branch').val(response.branch_name);
      $('#type').val(response.machine_type);
      $('#hidden_brand').val(response.brand_id);
      $('#hidden_original_branch').val(response.branch_id);
      $('#description').show();
    },
    timeout: 10000
  });
}
});
$(document).on('click', '.edit_button', function(){

    var id = $(this).data('id');
    $('#maintid').val(id);
    $.ajax({
          url:"action.php",
          method:"POST",
          data:{id:id, action:'fetch_single_maintenance'},
          dataType:'JSON',
          success:function(response)
          {

            $("#edit_status").change(function(){
            var value = $('#edit_status').val();
    if (value == "Good") {
      $('#edit_problem_statement_div').hide(); 
      $('#edit_problem_statement').val('');
      $('#edit_problem_statement').prop('required',false);
    }else{
      $('#edit_problem_statement').val(response.problem_statement);
      $('#edit_problem_statement_div').show();
    }
  });

$("#edit_ispart_replaced").change(function(){
  var value = $('#edit_ispart_replaced').val();
    if (value == "No") {
      $('#edit_part_replaced_div').hide();
      $('#edit_part_replaced').val('');
      $('#edit_part_replaced').prop('required',false);
    }else{
      $('#edit_part_replaced').val(response.part_replaced);
      $('#edit_part_replaced_div').show();
    }
  });
      if(response.problem_statement.trim() == ""){
            // var problem_statement = "N/A";
        $('#edit_problem_statement_div').hide();
        $('#edit_problem_statement_div').hide();
         $('#probem_statement_detail_div').hide();
         
      }
      else{
        var problem_statement = response.problem_statement;
        $('#edit_problem_statement_div').show();
      }

      if(response.ispart_replaced=="Yes"){
        $('#replace_detail').show();
        $('#edit_part_replaced_div').show();
      }else{
        $('#replace_detail').hide();
        $('#edit_part_replaced_div').hide();

      }

      $('#edit_cur_branch').val(response.branch_id);
      $('#edit_machine').val(response.machine_id);
      $('#edit_technician').val(response.technician_id)
      $('#edit_branch').val(response.branch_id);
      $('#edit_brand').val(response.brand_id);
      $('#edit_machine_type').val(response.machine_type_id);
      $('#edit_status').val(response.statuss);
      $('#edit_ispart_replaced').val(response.ispart_replaced);
      $('#edit_problem_statement').val(response.problem_statement);
      $('#edit_venue').val(response.venue);
      $('#edit_part_replaced').val(response.part_replaced);
      
          }
      });

    $('#edit').modal('show');
  });

$('#update').on('click', function (e) {
  e.preventDefault();
  $('.loader').modal('show');
   var jsonDataObj = JSON.stringify({


      "id": $("#maintid").val(),
      "brand_id": $("#edit_brand").val(),
      "machine_id": $("#edit_machine").val(),
      "branch_id": $("#edit_branch").val(),
      "technician_id": $("#edit_technician").val(),
      "statuss": $("#edit_status").val(),
      "problem_statement": $("#edit_problem_statement").val(),
      "ispart_replaced": $("#edit_ispart_replaced").val(),
      "part_replaced": $("#edit_part_replaced").val(),
      "venue": $("#edit_venue").val(),
      "cur_branch": $("#edit_cur_branch").val(),
      "recommendation": $("#recommendation_edit").val(),
      });
    $.ajax({
        url: 'updateMaintenance',
        type: "PUT",
        data: jsonDataObj,
        dataType: "json",
        error: function(){
          $('.loader').modal('hide');
          swal("TimedOut!", "Request timeout. Please try again","error");
        },
        success: function (data) {      
   $('.loader').modal('hide');
  swal("Good Job!", "Maintenance information updated successfully", "success");
  // $('#editBranchForm')[0].reset();
  $('#edit').modal('hide');
  $("#maintenanceList").DataTable().ajax.reload();
},
timeout: 10000
});
});
// var maintenanceTable = $('#maintenanceList').DataTable();
$(document).on('click', '.delete_button', function () {
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
                type: "POST",
                contentType: "application/json",
                data: JSON.stringify({id:id}),
                url: 'deleteMaintenance', 
                error: function(){
                  $('.loader').modal('hide');
                  swal("TimedOut!", "Request timeout. Please try again","error");
                },             
                success: function (data) {
                  $('.loader').modal('hide');
                  $("#maintenanceList").DataTable().ajax.reload();
                    swal("Deleted!", "Your imaginary file has been deleted","success");
                },
                timeout:10000     
      });
          }
});
});


$(document).on('click', '.view_button', function () {
    var id = $(this).data('id');
    $('#detail').modal('show');
    
  $('#maintid').val(id);
    getRow(id);
  });

function getRow(id){
  $.ajax({
   type: 'POST',
    url: 'action.php',
    data: {id:id,action:'fetch_single_maintenance'},
    dataType: 'json',
    success: function(response){
      $('#serial_number_detail').val(response.serial_number);
      $('#brand_detail').val(response.brand_name);
      $('#type_detail').val(response.machine_type);
      $('#Cbranch_detail').val(response.branch_name);
      $('#serial_number_detail').val(response.serial_number);
      $('#technician_detail').val(response.name);
      $('#status_detail').val(response.statuss);
      $("#part_replaced_detail").val(response.part_replaced);
      $('#problem_statement_detail').val(response.problem_statement);
      $('#ispart_replaced_detail').val(response.ispart_replaced);
      $('#venue_detail').val(response.venue);
      if (response.recommendation == "") {
        var response = "N/A";
        $('#recommendation_detail').val(response);
      }else{
        $('#recommendation_detail').val(response.recommendation);
      }
    }
  });
}

</script>
</body>
</html>