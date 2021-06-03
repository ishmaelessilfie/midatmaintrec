
<?php
include('maintsys.php');

$user = new maintsys();

if(!$user->is_login())
{
  header("location:".$user->base_url."");
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
        Faulty Machines Reporting Portal
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reporting</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header with-border">
              <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn"><i class="fa fa-plus"></i> New</a>
            </div>
            <div class="box-body">
              <table id="saitList" class="table table-bordered table-responsive">
                <thead>
                  <th>Date</th>
                  <th>Serial No</th>
                  <th>Original Branch</th>
                  <th>Branch From</th>
                  <th>Problem status</th>
                  <th>Acknowledgement Status</th>    
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
  <?php include 'includes/sait_reporting_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
function saitList() {
    if (!$.fn.DataTable.isDataTable('#saitList')) {
        $("#saitList").DataTable({
          responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.childRowImmediate,
              type: ''
            }
        },
        responsive: true,
            "ajax": {
                "url": "readSait",
                "type": "GET",
                "dataSrc": ""
            },
        
        order: [ 1, 'asc' ],
            "columns": [
                {"data": "date_recieved"},
                {"data": "serial_number"},
                {"data": "original_branch"},
                {"data": "branch_from"},
                {"data": "problem_statement"},
                {"data": "acknowlegement_status",
                
                 "render": function (data, type, row) {
                      if(data=="not"){
                        return  '<button class="btn btn-warning btn-sm text-weight-bold ack_btn"> <strong>Sent</strong></button>'
                    }else if(data=="ackd" || data=="assigned"){
                      return '<button class="btn btn-info btn-sm text-weight-bold asign_to"> <strong>Received_By Mid</strong></button>'
                    }else if(data=='techrecieved'){
                      return '<button type="button" class="btn btn-danger btn-sm text-weight-bold"><i class="fa fa-refresh fa-spin"></i> <strong>Working_On_It...</strong></button>'
                    }else if(data=='done'){
                      return '<button type="button" class="btn btn-success btn-sm text-weight-bold "  <strong>Done_Working_on</strong></button>'
                    }else if(data=='sent'){
                      return '<button class="btn btn-warning btn-sm  done_btn" > <strong>Ack. Receipt</strong></button>'
                    }else if(data=='recieved'){
                      return '<button class="btn btn-success btn-sm "> <strong>Received_By S&IT</strong></button>'
                    }
                  }
                 }
            ]
        });
    }
};
saitList();
$('#addMaintenance').on('click', e => {
  e.preventDefault();
      var jsonDataObj = JSON.stringify({
      "machine_id": $("#machine").val(),
      "brand_id": $("#hidden_brand").val(),
      "branch_id": $("#hidden_original_branch").val(),
      "problem_statement": $("#problem_statement").val(),
      "cur_branch": $("#cur_branch").val(),
      });
      // alert(jsonDataObj);
    $.ajax({
        url: 'createSait',
        type: "POST",
        data: jsonDataObj,
        dataType: "json",
        timeout:10000,
        success: function (data) {   
        if(data.code==200){   
  swal("Good Job!", "Maintenance added successfully", "success");
  $('#maintenanceForm')[0].reset();
  $('#addnew').modal('hide');
  $("#saitList").DataTable().ajax.reload();
}else if(data.code==201){
  swal("Information!", data.message, "info");
}else{
  swal("Ooops..!", "Somthing went wrong please try again", "error");
}
},
error: function(jqXHR,textStatus){
  if (textStatus==='timeout'){
    swal("Failed from timeout", "Please try again", "error");
  }
}
});
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
    success: function(response){
      $('.spin').css('display','none');
      // alert(response.branch_name);
      $('#brand').val(response.brand_name);
      $('#original_branch').val(response.branch_name);
      $('#type').val(response.machine_type);
      $('#hidden_brand').val(response.brand_id);
      $('#hidden_original_branch').val(response.branch_id);
      $('#description').show();
    }
  });
}
});
var saitList = $("#saitList").DataTable();
saitList.on('click', '.done_btn', function () {
    $tr = $(this).closest('tr');
    var data = saitList.row($tr).data();
    var id = data.id;
    var acknowlegement_status = data.acknowlegement_status;
   
    var next_status;
    switch(acknowlegement_status){
      case 'sent': next_status ='recieved';
      break;
      
    }
       swal({
        title: "Are you sure?",
        text: "You want to "+next_status+"?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then(function (willdelete) {
      if(willdelete){
            $.ajax({
          url:"updateSait.php",
          method:"POST",
          data:JSON.stringify({id:id, acknowlegement_status:next_status}),
          success:function(data)
                 {
                  
                                swal(""+next_status+"d!", "User "+next_status+"d Successfully","success");
                    saitList.ajax.reload();
                    
                }     
      });
          }
});
    });

</script>
</body>
</html>
