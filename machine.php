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
        Machine List
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Machine type</li>
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
             
              <table id="machineList" class="table table-bordered table-responsive">
                <thead>
                  <th>Serial Nmber</th>
                  <th>Branch Name</th>
                  <!-- <th>Zone</th> -->
                  <th>Brand</th>
                  <th>Type</th>
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
  <?php include 'includes/machine_modal.php'; ?>
  <?php include 'includes/loader.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>

$('#addMachine').on('click', e => {
  e.preventDefault();
  // checkInputs();
      var jsonDataObj = JSON.stringify({
      "serial_number": $("#serial_number").val(),
      "branch_id": $("#branch").val(),
      "brand_id": $("#brand").val(),
      "machine_type_id": $("#type").val(),
      "zone": $("#zone").val(),
      });
      $('.loader').modal('show'); 
    $.ajax({
        url: 'createMachine',
        type: "POST",
        data: jsonDataObj,
        dataType: "json",
        error: function(){
          $('.loader').modal('show'); 
        },
        success: function (data) {

          if(data.code==200){
       $('.loader').modal('hide');
  swal("Good Job!", "Machine added successfuly", "success");
  $('#machineForm')[0].reset();
  $('#addnew').modal('hide');
  $("#machineList").DataTable().ajax.reload();
}else if(data.code==201){
  $('.loader').modal('hide');
  swal("Information!", data.message, "info");
}else{
  $('.loader').modal('hide');
  swal("Error!", "Oops.. somthing went wrong please try again", "error");
}
},
timeout: 10000
});
});

function machineList() {
    if (!$.fn.DataTable.isDataTable('#machineList')) {
      
        $("#machineList").DataTable({

           responsive: {
            details: {
              display: $.fn.dataTable.Responsive.display.modal(),
              type: ''
            }
        },
        responsive: true,
            "ajax": {
                "url": "readMachine",
                "type": "GET",
                "dataSrc": ""
            },
                 dom: 'Bfrtip',
        buttons: [
           {
              extend: 'excelHtml5',
              title:'',
              exportOptions:{
                columns : [0,1,2,3]
              }
            },
            
            {
              extend: 'pdf',
              title:'',
              exportOptions:{
                columns : [0,1,2,3]
              }
            },
            {
              extend : 'print',
              title:'',
              exportOptions :{
                columns : [0,1,2,3]
              }
            }
            
        ],
            "columns": [
                {"data": "serial_number"},
                {"data": "branch_name"},
                {"data": "brand_name"},
                {"data": "machine_type"},
                {"data": null,
                    "defaultContent": '<button class="btn btn-warning btn-sm edit btn" ><i class="fa fa-edit"></i></button>\n\
                            <button class="btn btn-danger btn-sm delete btn" ><i class="fa fa-times"></i></button>'
                }
            ]
           
        });
    }
};
machineList();

var machineTable = $('#machineList').DataTable();
machineTable.on('click', '.edit', function () {
    $tr = $(this).closest('tr');
    
    var data = machineTable.row($tr).data();
    $('#edit_serial_number').val(data.serial_number);
    $('.edit_brand').val(data.brandid);
    $('.edit_type').val(data.typeid);
    $('.edit_branch').val(data.branchid);
    $('#edit_zone').val(data.zone);
    $('.machineid').val(data.id);
    $('#edit').modal('show');
});

$('#update').on('click', function (e) {
  e.preventDefault();
   var jsonDataObj = JSON.stringify({
       "serial_number": $("#edit_serial_number").val(),
      "branch_id": $(".edit_branch").val(),
      "brand_id": $(".edit_brand").val(),
      "machine_type_id": $(".edit_type").val(),
      "zone": $("#edit_zone").val(),
      "id": $(".machineid").val()
      });
   $('.loader').modal('show');
    $.ajax({
        url: 'updateMachine',
        type: "PUT",
        data: jsonDataObj,
        dataType: "json",
        error: function(){
          $('.loader').modal('hide');
          swal("TimeedOut!", "Request timeout, please try again","error");
        },
        success: function (data) { 
        $('.loader').modal('hide');     
  swal("Good Job!", "Brand updated successfuly", "success");
  $('#edit').modal('hide');
  $("#machineList").DataTable().ajax.reload();
},
timeout: 10000
});

});

machineTable.on('click', '.delete', function () {
    $tr = $(this).closest('tr');
    var data = machineTable.row($tr).data();
    var id = data.id;
    // alert(id);
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
                url: 'deleteMachine',              
                success: function (data) {
                  $('.loader').modal('hide');
                    swal("Deleted!", "Your imaginary file has been deleted","success");
                    $("#machineList").DataTable().ajax.reload();
                }     
      });
          }
});
});

</script>
</body>
</html>