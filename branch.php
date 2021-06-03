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
        Branch
      </h1>
      <ol class="breadcrumb">
        <li><a href="home"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Branch</li>
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
              
              <table class="table table-bordered table-responsive" id="branchList">
                <thead>
                  <th>Branch Name</th>
                  <th>Contact</th>
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
  <?php include 'includes/branch_modal.php'; ?>
  <?php include 'includes/loader.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>

const form = document.getElementById('addBranchForm');
const branch_name = document.getElementById('branch_name');
function checkInputs() {
  const branch_nameval = branch_name.value.trim();
  
  if(branch_nameval === '') {
    setErrorFor(branch_name, 'Branch name cannot be blank');
  } else {
    setSuccessFor(branch_name);
  }
}

function setErrorFor(input, message) {
  const form_div = input.parentElement;
  const small = form_div.querySelector("small");
  form_div.className = 'form_div error';
  small.innerText = message;
}

function setSuccessFor(input) {
  const form_div = input.parentElement;
  form_div.className = 'form_div success';
}

form.addEventListener('submit', e => {
  e.preventDefault();
  checkInputs();
      var jsonDataObj = JSON.stringify({
      "branch_name": $("#branch_name").val(),
      "contact_info" : $("#contact_info").val()
      });
    $('.loader').modal('show'); 
    $.ajax({
        url: 'createBranch',
        type: "POST",
        data: jsonDataObj,
        dataType: "json",
        error: function(){
          $('.loader').modal('hide');
                 swal("Error!", "Request Timedout","error");
                },
        success: function (data) { 
        $('.loader').modal('hide');     
   if(data.code==200){
  swal("Good Job!", "Branch added successfuly", "success");
  $('#addBranchForm')[0].reset();
  $('#addnew').modal('hide');
  $("#branchList").DataTable().ajax.reload();
}else if(data.code==201){
  swal("Information!", data.message, "info");
}else{
  swal("Error!", "Oops.. somthing went wrong please try again", "error");
}
},
timeout: 10000
});
});

function branchList() {
    if (!$.fn.DataTable.isDataTable('#branchList')) {
      
        $("#branchList").DataTable({
            "ajax": {
                "url": "readBranch",
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "branch_name"},
                {"data": "contact_info"},
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
branchList();

var branchTable = $('#branchList').DataTable();
branchTable.on('click', '.edit', function () {
    $tr = $(this).closest('tr');
    var data = branchTable.row($tr).data();
    $('#branch_name_edit').val(data.branch_name);
    $('#contact_info_edit').val(data.contact_info);
    $('#branchid').val(data.id);
    $('#edit').modal('show');
});

branchTable.on('click', '.delete', function () {
    $tr = $(this).closest('tr');
    var data = branchTable.row($tr).data();
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
                url: 'deleteBranch', 
                error: function(){
          $('.loader').modal('hide');
                 swal("Error!", "Request Timedout","error");
                },  
                success: function (data) {
                  $('.loader').modal('hide');
                    swal("Deleted!", "Your imaginary file has been deleted","success");
                    $("#branchList").DataTable().ajax.reload();
                },
                timeout: 10000    
      });
          }
});
});
$('#update').on('click', function (e) {
  e.preventDefault();
   var jsonDataObj = JSON.stringify({
      "branch_name": $("#branch_name_edit").val(),
      "contact_info" : $("#contact_info_edit").val(),
      "id": $("#branchid").val()
      });
    $('.loader').modal('show');
    $.ajax({
        url: 'updateBranch',
        type: "PUT",
        data: jsonDataObj,
        dataType: "json",
        error: function(){
          $('.loader').modal('hide');
                 swal("Error!", "Request Timedout","error");
                },
        success: function (data) {      
   $('.loader').modal('hide');
  swal("Good Job!", "Branch updated successfuly", "success");
  $('#edit').modal('hide');
  $("#branchList").DataTable().ajax.reload();
},
timeout: 10000
});

});
</script>
</body>
</html>