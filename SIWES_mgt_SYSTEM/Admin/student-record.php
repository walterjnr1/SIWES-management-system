<?php 
include 'header2.php'; 
if(empty($_SESSION['login_email']))
  {   
   header("Location: login.php"); 
   }
?>



<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/table-data-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:25 GMT -->
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Student Record|<?php echo $row_website['website_name'];   ?></title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- v4.0.0 -->
<link rel="stylesheet" href="dist/bootstrap/css/bootstrap.min.css">

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $row_website['favicon'];   ?>">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- Theme style -->
<link rel="stylesheet" href="dist/css/style.css">
<link rel="stylesheet" href="dist/css/font-awesome/css/font-awesome.min.css">
<link rel="stylesheet" href="dist/css/et-line-font/et-line-font.css">
<link rel="stylesheet" href="dist/css/themify-icons/themify-icons.css">
<link rel="stylesheet" href="dist/css/simple-lineicon/simple-line-icons.css">

<!-- DataTables -->
<link rel="stylesheet" href="dist/plugins/datatables/css/dataTables.bootstrap.min.css">

 <script type="text/javascript">
		function deldata(fullname){
if(confirm("ARE YOU SURE YOU WISH TO DELETE " + " " + fullname+ " " + " FROM THE LIST?"))
{
return  true;
}
else {return false;
}
	 
}

</script>
<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
<style type="text/css">
<!--
.style1 {
	color: #FFFFFF;
	font-weight: bold;
}
.style2 {color: #000000}
-->
.zoom {
  padding: 10px;
  transition: transform .2s; /* Animation */
  width: 300px;
  height: 300px;
  margin: 0 auto;
}

.zoom:hover {
  transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
}
</style>
<script language="javascript">
        function printdiv(printpage) {
            var headstr = "<html><head><title>Payment Eeport</title></head><body>";
            var footstr = "</body>";
            var newstr = document.all.item(printpage).innerHTML;
            var oldstr = document.body.innerHTML;
            document.body.innerHTML = headstr + newstr + footstr;
            window.print();
            document.body.innerHTML = oldstr;
            return false;
        }
    </script>
</head>
<body class="skin-blue sidebar-mini">
<div class="wrapper boxed-wrapper">

    <p>
      <?php include 'header.php'; ?>
      
      <!-- Left side column. contains the logo and sidebar -->
      <?php include 'sidebar.php'; ?>
      
      <!-- Content Wrapper. Contains page content -->
       </p>  
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>Student Record </h1>
      <ol class="breadcrumb">
        <li><a href="#">Home</a></li>
        <li><i class="fa fa-angle-right"></i> Student Record </li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content" id="reportDIV">
      <div class="card m-t-3">
      <div class="card-body">
      <h4 class="text-black">Student Record </h4>
     <button id="print" onClick="printdiv('reportDIV');" class="btn btn-sm btn-primary pull-right m-t-n-xs" ><i class="fa fa-print"></i> Print</button>
	 <p> </p>
	 <p> </p>
      <div class="table-responsive">
        <table id="example1" class="table table-bordered table-striped">
		  
		  <thead class="bg-primary text-white">
               	  
            <tr>
						    		 <th><div align="center">#</div></th>
			    		 <th><div align="center">Photo</div></th>
						 <th><div align="center">Reg No </div></th>
				           <th><div align="center">Student Name</div></th>
                          <th><div align="center">Email</div></th>
                          <th><div align="center">Address</div></th>
                          <th><div align="center">State</div></th>
						  <th><div align="center">Department</div></th>
                          <th><div align="center">Siwes Place</div></th>
                          <th><div align="center">Supervisor</div></th>
						 <th><div align="center">Action</div></th>

            </tr>
          </thead>
          <tbody>
    <?php 
$data = $dbh->query("SELECT tblstudent.*,users.fullname as name FROM tblstudent INNER JOIN users ON tblstudent.siwes_supervisor=users.ID")->fetchAll();
$cnt=1;
foreach ($data as $row) {

?>
           <tr>


                          <td><div align="center"><?php echo $cnt; ?></div></td>
						  <td><div align="center"><img src="<?php echo (!empty($row['photo'])) ? $row['photo'] : 'dist/img/No_image_available.svg.png'; ?>"  width="56" height="50" border="2"/></div></td>

						    <td><div align="center"><?php echo $row['reg_num']; ?></div></td>
													    <td><div align="center"><?php echo $row['fullname']; ?></div></td>
                             <td><div align="center"><?php echo $row['email'] ?></div></td>
							    <td><div align="center"><?php echo $row['address']; ?></div></td>
						  	  <td><div align="center"><?php echo $row['state']; ?></div></td>
							  						  	  <td><div align="center"><?php echo $row['dept']; ?></div></td>

						    <td><div align="center"><?php echo $row['siwes_place']; ?></div></td>
						    <td><div align="center"><?php echo $row['name']; ?></div></td>
                   <td><div align="center"> <a href="delete-student.php?rid=<?php echo $row['reg_num'];?>">
                <button type="submit" name="btndelete" class="btn btn-danger" onClick="return deldata('<?php echo $row['fullname']; ?>');">Delete</button> </a>
                </a></div></td>
</tr>
<?php $cnt=$cnt+1;} ?>



          </tfoot>
        </table>
      </div>
      </div></div>
    </div>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-left hidden-xs"><?php include'footer.php';  ?>.</footer>
</div>
<!-- ./wrapper --> 

<!-- jQuery 3 --> 
<script src="dist/js/jquery.min.js"></script>
 
<script src="dist/plugins/popper/popper.min.js"></script>

<!-- v4.0.0-alpha.6 -->
<script src="dist/bootstrap/js/bootstrap.min.js"></script>

<!-- template --> 
<script src="dist/js/adminkit.js"></script>

<!-- DataTable --> 
<script src="dist/plugins/datatables/jquery.dataTables.min.js"></script> 
<script src="dist/plugins/datatables/dataTables.bootstrap.min.js"></script> 
<script>
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  })
</script>

<script src="dist/plugins/table-expo/filesaver.min.js"></script>
<script src="dist/plugins/table-expo/xls.core.min.js"></script>
<script src="dist/plugins/table-expo/tableexport.js"></script>
<script>
$("table").tableExport({formats: ["xlsx","xls", "csv", "txt"],    });
</script>
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/main/ltr/table-data-table.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 17:41:27 GMT -->
</html>
