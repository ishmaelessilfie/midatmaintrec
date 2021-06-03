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
        Brands
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Brands</li>
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
              
              <table id="brandList" class="table table-bordered table-responsive">
                <thead>
                  <th>Brand</th>
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
  <?php include 'includes/brand_modal.php'; ?>
  <?php include 'includes/loader.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>

const branch_name = document.getElementById('brand_name');
function checkInputs() {
  // trim to remove the whitespaces
  const brand_nameval = brand_name.value.trim();
  
  if(brand_nameval === '') {
    setErrorFor(brand_name, 'Brand name cannot be blank');
  } else {
    setSuccessFor(brand_name);
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

$('#addBrand').on('click', e => {
  e.preventDefault();
  checkInputs();

       var jsonDataObj = JSON.stringify({
      "brand_name": $("#brand_name").val(),
      });
       $('.loader').modal('show');
    $.ajax({
        url: 'createBrand',
        type: "POST",
        data: jsonDataObj,
        dataType: "json",
        error: function(){
          $('.loader').modal('hide');
                 swal("Error!", "Request Timedout","error");
                },
        success: function (data) {      
   if(data.code==200){
   
  swal("Good Job!", "Brand added successfuly", "success");

  $('#brandForm')[0].reset();
  $('#addnew').modal('hide');
  $('.loader').modal('hide');
  $("#brandList").DataTable().ajax.reload();
}else if(data.code==201){
  swal("Information!", data.message, "info");
}else{
  swal("Error!", "Oops.. somthing went wrong please try again", "error");
}
}, 
timeout: 10000
});
});

function brandList() {
    if (!$.fn.DataTable.isDataTable('#brandList')) {
      
        $("#brandList").DataTable({

            "ajax": {
                "url": "readBrand",
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "brand_name"},
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
brandList();

var brandTable = $('#brandList').DataTable();
brandTable.on('click', '.edit', function () {
    $tr = $(this).closest('tr');
    var data = brandTable.row($tr).data();
    $('#edit_brand_name').val(data.brand_name);
    $('#brandid').val(data.id);
    $('#edit').modal('show');
});

brandTable.on('click', '.delete', function () {
    $tr = $(this).closest('tr');
    var data = brandTable.row($tr).data();
    var id = data.id;
    
    swal({
        title: "Are you sure?",
        text: "You will no be able to recover this imaginary file!",
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
                url: 'deleteBrand',  
                error: function(){
          $('.loader').modal('hide');
                 swal("Error!", "Request Timedout","error");
                },            
                success: function (data) {
                  $('.loader').modal('hide');
                    swal("Deleted!", "Your imaginary file has been deleted","success");
                    $("#brandList").DataTable().ajax.reload();
                },
                timeout: 10000     
      });
          }
});
});

$('#update').on('click', function (e) {
  e.preventDefault();
   var jsonDataObj = JSON.stringify({
      "brand_name": $("#edit_brand_name").val(),
      "id": $("#brandid").val()
      });
      $('.loader').modal('show');
    $.ajax({
        url: 'updateBrand',
        type: "PUT",
        data: jsonDataObj,
        dataType: "json",
        error: function(){
          $('.loader').modal('hide');
                 swal("Error!", "Request Timedout","error");
                },
        success: function (data) {      
      $('.loader').modal('hide');
      swal("Good Job!", "Brand updated successfuly", "success");
      $('#edit').modal('hide');
      $("#brandList").DataTable().ajax.reload();
},
timeout: 10000
});

});

</script>
</body>
</html>
