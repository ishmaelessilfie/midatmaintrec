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
        Machine type
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
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
              <table id="typeList" class="table table-bordered table-responsive">
                <thead>
                  <th>Machine type</th>
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
  <?php include 'includes/type_modal.php'; ?>
  <?php include 'includes/loader.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$('#addType').on('click', e => {
  e.preventDefault();
  // checkInputs();
      var jsonDataObj = JSON.stringify({
      "machine_type": $("#machine_type").val(),
      });
      $('.loader').modal('show');
    $.ajax({
        url: 'createMachineType',
        type: "POST",
        data: jsonDataObj,
        dataType: "json",
        error:function(){
          $('.loader').modal('hide');
          swal("Error!", "Oops.. somthing went wrong please try again", "error");
        },
      success: function (data) {   
        if(data.code==200){  
          $('.loader').modal('hide');
  swal("Good Job!", "Machune type added successfuly", "success");
  $('#addTypeForm')[0].reset();
  $('#addnew').modal('hide');
  $("#typeList").DataTable().ajax.reload();
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

function typeList() {
    if (!$.fn.DataTable.isDataTable('#typeList')) {
      
        $("#typeList").DataTable({
           
        responsive: true,

            "ajax": {
                "url": "readMachineType",
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "machine_type"},
                {"data": null,
                    "render": function (data, type, row) {
                        return  '<div class="btn btn-warning btn-sm edit btn"><i class="fa fa-edit"></i></div>\n\
                                <div class="btn btn-danger btn-sm delete btn"><i class="fa fa-times"></i></div>';
                    }
                }   
            ]
        });
    }
};
typeList();

var typeTable = $('#typeList').DataTable();
typeTable.on('click', '.edit', function () {
    $tr = $(this).closest('tr');
    var data = typeTable.row($tr).data();
    $('#edit_machine_type').val(data.machine_type);
    $('#typeid').val(data.id);
    $('#edit').modal('show');
});

typeTable.on('click', '.delete', function () {
    $tr = $(this).closest('tr');
    var data = typeTable.row($tr).data();
    var id = data.id;
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
                url: 'deleteMachineType',              
                success: function (data) {
                  $('.loader').modal('hide');
                    swal("Deleted!", "Your imaginary file has been deleted","success");
                    $("#typeList").DataTable().ajax.reload();
                }     
      });
          }
});
});

$('#update').on('click', function (e) {
  e.preventDefault();
   var jsonDataObj = JSON.stringify({
      "machine_type": $("#edit_machine_type").val(),
      "id": $("#typeid").val()
      });
    $('.loader').modal('show');
    $.ajax({
        url: 'updateMachineType',
        type: "PUT",
        data: jsonDataObj,
        dataType: "json",
        success: function (data) {      
   // if(data.code==200){
    $('.loader').modal('hide');
  swal("Good Job!", "Brand updated successfuly", "success");
  $('#editForm')[0].reset();
  $('#edit').modal('hide');
  $("#typeList").DataTable().ajax.reload();
}
});
});
</script>
</body>
</html>
