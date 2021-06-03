<?php
include('maintsys.php');

$user = new maintsys();


?>
<?php 
include_once 'config/database.php';
 function fetch_data($type, $start_date, $end_date)  
 {  
  $db_connection = new Database();
$conn = $db_connection->dbConnection();

      $output = '';  
      $i = 1;

       if($type =="zone"){
        // $sql = "call zonal('$start_date','$end_date')"; 
        $sql = "call zonal('$start_date','$end_date')"; 
      $stmt = $conn->prepare($sql);
      $stmt->execute();  

       $branch_array = array();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($branch_array,$row);
        $output .='<tr > 
                    <td>'.$i++.'</td>
                    <td>'.$row["Branch_name"].'</td>  
                    <td>'.$row["Matica"].'</td>  
                    <td>'.$row["Compuprint"].'</td>  
                    <td>'.$row["Epson"].'</td>
                    <td>'.$row["Avision_AV320E2"].'</td>
                    <td>'.$row["Avision_AD240U"].'</td>
                    <td style="font-weight:bold;">'.$row["Branch_Totals"].'</td>  
                 </tr>  
                          ';  
      }  
      return $output;  

    }
        else{

      $Matica = 0;
      $Compuprint = 0;
      $Epson = 0;
      $Avision_AD240U = 0;
      $Avision_AV320E2 = 0;
      $Branch_Total = 0;
      $sql = $sql = "call proc_text_stats('$start_date','$end_date')"; 
      $stmt = $conn->prepare($sql);
      $stmt->execute();  

       $branch_array = array();
    
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        
        extract($row);
            array_push($branch_array,$row); 
             
      $output .= '<tr>  
                          <td>'.$i++.'</td> 
                          <td>'.$row["Branch_name"].'</td>  
                          <td>'.$row["Matica"].'</td>  
                          <td>'.$row["Compuprint"].'</td>  
                          <td>'.$row["Epson"].'</td>
                          <td>'.$row["Avision_AV320E2"].'</td>
                          <td>'.$row["Avision_AD240U"].'</td>
                          <td style="font-weight:bold;">'.$row["Branch_Totals"].'</td>  
                     </tr>  
                          ';  
                          $Matica += $row['Matica'];
                      $Compuprint += $row['Compuprint'];
                      $Avision_AD240U += $row['Avision_AD240U'];
                      $Avision_AV320E2 += $row['Avision_AV320E2'];
                      $Epson += $row['Epson'];
                      $Branch_Total += $row['Branch_Totals'];

      }  
      return $output;

 }
}

 if(isset($_GET["pfd_report"])) { 
   $start_date = $_GET['start_date'];
   $end_date = $_GET['end_date'];
   $type = $_GET['type']; 
  
  $month = date("n", strtotime($end_date));
  $yearQuarter = ceil($month / 3);


switch ($yearQuarter) {
	case 1:
		$Quarter= "1st";
		break;
    case 2:
		$Quarter = "2nd";
		break;
    case 3:
		$Quarter ="3rd";
		break;
    case 4:
		$Quarter ="4th";
};

switch ($type) {
	case 'zone':
		$typeheader= "Zone";
		break;
    case 'branch':
		$typeheader = "Branch";
		break;
    default:
    $typeheader ="Branch";
    break;

};
$date = date("Y", strtotime($end_date));

      require 'TCPDF-master/tcpdf.php';  
      $obj_pdf = new TCPDF('P', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);  
      $obj_pdf->SetCreator(PDF_CREATOR);  
      $obj_pdf->SetTitle("Mid Atlantic Investments");  
      $obj_pdf->SetHeaderData('', '', PDF_HEADER_TITLE, PDF_HEADER_STRING);  
      $obj_pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));  
      $obj_pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));  
      $obj_pdf->SetDefaultMonospacedFont('helvetica');  
      $obj_pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
      $obj_pdf->SetMargins(PDF_MARGIN_LEFT, '10', PDF_MARGIN_RIGHT);  
      $obj_pdf->setPrintHeader(false);  
      $obj_pdf->setPrintFooter(false);  
      $obj_pdf->SetAutoPageBreak(TRUE, 10);  
      $obj_pdf->SetFont('helvetica', '', 11);  
      $obj_pdf->AddPage();  
      $content = '';  
      $content .= '  
      <h4 align="center">Mid Atlantic Investments</h4>
      <h4 align="center" >Routine Maintenanace For GCB Bank Ltd.  ' .$date. ' ' .$Quarter. ' Quarter</h4><br/>
      <h4 ></h4>
      <table border="1" cellspacing="0" cellpadding="3">  
           <tr style="font-weight:bold; text-align:left;"> <th width="6%">Item</th>
                <th width="30%">'.$typeheader.'</th>  
                <th width="8%">Matica</th>  
                <th width="14%">Compuprint <br/> SP40Plus</th> 
                <th width="8%">Epson</th> 
                
                <th width="13%" >Avision <br/> (AV320E2)</th>
                <th width="13%">Avision <br/> (AD240U)</th>
                <th style="font-weight:bold;"width="11%">Sub Total</th>

           </tr> ';  
      $content .= fetch_data($type, $start_date, $end_date);  
      $content .= '</table>';  
      $obj_pdf->writeHTML($content);  
      $obj_pdf->Output('Mid Atlantic Investments.pdf', 'I');  
 }  
 ?> 