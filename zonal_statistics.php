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
        Machine stats
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Machine stats</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-body">
            <p>
              
               <table id="statisticsList" class="table  table-hover table-responsive ">
                <thead>
                  <th>Zone</th>
                  <th>Matica S3100</th>
                  <th>Compuprint SP40PLUS</th>
                  <th>Epson</th>
                  <th>Avision AD240U</th>
                  <th>Avision AV320E2+</th>
                  <th style="font-weight:bold;">SUB TOTAL</th>
                  <!-- <th style="font-weight:bold; color:red">BRANCH SUB TOTAL<th> -->
                </thead>
                <tbody>
                </tbody>
                 <tfoot>
                  <!-- <tr style="text-align:left; text-decoration: underline"></tr> -->
                  <tr style="text-align:left; text-decoration: underline">
                  <th>Total</th>
                  <th colspan=""style="text-align:left;"></th>
                  <th style="text-align:left"></th>
                  <th style="text-align:left"></th>
                  <th style="text-align:left"></th>
                  <th style="text-align:left"></th>
                  <th style="text-align:left"></th>
                  <!-- <th></th> -->
                </tr>
                </tfoot>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>   
  </div>
  <?php include 'includes/footer.php'; ?>
 
  <?php include 'includes/brand_modal.php'; ?>
</div>
<?php include 'includes/scripts.php'; ?>
<script>
function statisticsList() {
    if (!$.fn.DataTable.isDataTable('#statisticsList')) {
      
        $("#statisticsList").DataTable({
        //    rowReorder: {
        //     selector: 'td:nth-child(2)'
        // },
        // responsive: true,

         "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 1 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );

             total1 = api
                .column( 2 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              total2 = api
                .column( 3 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              total3 = api
                .column( 4 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              total4 = api
                .column( 5 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
              total5 = api
                .column( 6 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
           
 
            // Update footer
            if(end==data.length){
            $( api.column( 0 ).footer() ).html(
                 'Total'
            );
          }else{
            $( api.column( 0 ).footer() ).html('')
          };

            if(end==data.length){
            $( api.column( 1 ).footer() ).html(
                 total
            );
          }else{
            $( api.column( 1 ).footer() ).html('')
          };

             if(end==data.length){
             $( api.column( 2 ).footer() ).html(
                 total1
            );
            }else{
            $( api.column( 2 ).footer() ).html('')
          };
           if(end==data.length){
            $( api.column( 3 ).footer() ).html(
                 total2
            );
            }else{
            $( api.column( 3 ).footer() ).html('')
          };

           if(end==data.length){
            $( api.column( 4 ).footer() ).html(
                 total3
            );
            }else{
            $( api.column( 4 ).footer() ).html('')
          };

            if(end==data.length){
            $( api.column( 5 ).footer() ).html(
                 total4
            );
            }else{
            $( api.column( 5 ).footer() ).html('')
          };
          if(end==data.length){
            $( api.column( 6 ).footer() ).html(
                total5
            );
            }else{
            $( api.column( 6 ).footer() ).html('')
          };

        },
          dom: 'Bfrtip',
        buttons: [
           {
              extend: 'excelHtml5',
              title:'',
              footer: true,
            },
            {
              extend: 'pdf',
              title:'',
              footer: true,
            },
            {
              extend : 'print',
              title:'',
              footer: true,
            } 
        ],
            "ajax": {
                "url": "zonal_statistics_Api.php",
                "type": "GET",
                "dataSrc": ""
            },
            "columns": [
                {"data": "Branch_name"},
                {"data": "Matica"},
                {"data": "Compuprint"},
                {"data": "Epson"},
                {"data": "Avision_AD240U"},
                {"data": "Avision_AV320E2"},
                {"data": "Branch_Totals"}  
            ]
        });
    }
    $('table tr:last').css("font-weight","bold");
};
statisticsList();
</script>
</body>
</html>
