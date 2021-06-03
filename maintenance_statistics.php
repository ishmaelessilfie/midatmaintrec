<?php
include('maintsys.php');

$user = new maintsys();



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
             Maintenance stats
            </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Maintenance stats</li>
          </ol>
          </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
               <p>   
          <div class="row">  
          <form id="reportform" action="pdf_gen.php" method="GET" target="_blank">
             <div class="form-group">
               <div class="col-md-3">
                  <select class="form-control  dropdown-toggle" name="type" id="type"   >
                        <option value="" selected>Select reporting type</option>
                        <option value="branch" >Branches</option>
                        <option value="zone" >Zonal</option> 
                      </select>
               </div>
            </div>
            <div class="form-group">
               <div class="col-md-2">
                  
                       <input type="text" class="form-control" id="start_date" placeholder="Start Date" name="start_date" >
               </div>
            </div>
            <div class="form-group">
               <div class="col-md-2">
                   <input type="text" class="form-control" id="end_date" placeholder="End Date" name="end_date" >
               </div>
            </div>
             <div class="form-group">
               <div class="col-md-2 ">
                  <button class="btn btn-info"  id="generate"> Search</button>
            </div>   
            <div col-md-2>
              <img src="img/sample.gif" class="spin" style=" display:none;height:50px; width:50px; margin-bottom: -45px;margin-top: -35px; margin-left:-70px; " alt="User Image" >
            </div>
            </div>
            </div>
            <div class="form-group">
            <div class="col-md-2 col-sm-6" id="pdf_btn" style="padding-right:-300px;" hidden>
               <input type="submit" class="btn btn-danger"   name="pfd_report" id="pdf" value="Print" >
            </div>
            </div>
          </form>
      </div>
    </div>
      </p>
               <table id="datatable"class="table table-hover ">
                <thead>
                  <th>Branch</th>
                  <th>Matica S3100</th>
                  <th>Compuprint SP40PLUS</th>
                  <th>Epson</th>
                  <th>Avision AD240U</th>
                  <th>Avision AV320E2+</th>
                  <th>SUB TOTAL<th>
                  <!-- <th style="font-weight:bold; color:red">SUB TOTAL<th> -->
                </thead>
                <tbody>                  
                </tbody>
              </table>
              
            </div>
          </div>
        </div>
      
    </section>   
  </div>
  <?php include 'includes/footer.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
$('#generate').click(function(event){  
  // alert('God');
  event.preventDefault();
   var formData = $("#reportform").serialize();
  $('.spin').css({height:'50px',display:'block', width:'50px' margin-bottom: '-45px',margin-top: '-35px', margin-left:'-70px'});
$("#table_div").empty();
$.ajax({
  url: "maintenance_statistics_Api.php", 
  method:"POST", 
  data :formData,
  dataType: 'json',
  error: function(){
    
    swal("TimedOut", "Request timeout; Please try again","error");
  },
  success: function(result){
    $('.spin').css('display','none');
$(".table tbody").html('');
if(result.length>0) {
$.each(result, function(data,value) {
   $("#pdf_btn").show();
  var htmlStr = "<tr><td>"+result[data].Branch_name+"</td><td>"+result[data].Matica+"</td><td>"+result[data].Compuprint+"</td>"
                +"</td><td>"+result[data].Avision_AD240U+"</td><td>"+result[data].Epson+"</td>"+"</td><td>"+result[data].Avision_AV320E2+"</td>"+"</td><td style='font-weight:bold;'>"+result[data].Branch_Totals+"</td>"
              $(".table tbody").append(htmlStr);
            });
            } else {
              $("#pdf_btn").hide();
              $(".table tbody").append('<tr><td colspan="8" style="color:red; text-align:center;font-weight:bold">No records to display</td></tr>');
            }
$('table tr:last').css("font-weight","bold");

            },
            timeout: 10000
          });


});


</script>
</body>
</html>
