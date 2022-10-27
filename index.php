<?php
include ("database.php");
$db = new database();	

$page = "";
 if(!empty($_GET["page"])){
 	$page = $_GET["page"];
 }else{
 	$page = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>แบบทดสอบ Web Programmer</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<style>
* {
  box-sizing: border-box;
}

body {
 margin: 0 auto;
 font-size: 16px
}

/* Style the header */
header {
  background-color: #666;
  padding: 8px;
  text-align: center;
 color: white;
}

header a{
	 color: white;
  text-decoration: none;
}
/* Container for flexboxes */
section {
  display: -webkit-flex;
  display: flex;
}

/* Style the navigation menu */
nav {
  -webkit-flex: 1;
  -ms-flex: 1;
  flex: 1;
  background: #ccc;
  padding: 20px;
}

/* Style the list inside the menu */
nav ul {
  list-style-type: none;
  padding: 0;
}

/* Style the content */
article {
  -webkit-flex: 3;
  -ms-flex: 3;
  flex: 3;
  background-color: #f1f1f1;
  padding: 10px;
}

/* Style the footer */
footer {
  background-color: #777;
  padding: 10px;
  text-align: center;
  color: white;
}

/* Responsive layout - makes the menu and the content (inside the section) sit on top of each other instead of next to each other */
@media (max-width: 600px) {
  section {
    -webkit-flex-direction: column;
    flex-direction: column;
  }
}

.required{
	color: red;
}

input{
	width: 100%;
	padding:8px;
}

label{
	display:block;
	margin-top: 16px;
}

.bt_save{
	margin-top: 20px;
	padding: 8px;
	font-size: 15px;
}

table {
  width: 100%;
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid;
  padding:6px;
  text-align:center !important;
}
</style>
</head>
<body>
<header>
  <a href="index.php"><h2>แบบทดสอบ Web Programmer</h2></a>
  <h4>โดย เพชรรัตน์ เขียวรอดไพร</h4>
</header>

<section>
  <nav>
    <ul>
      <li><a href="index.php">หน้าแรก</a></li>
      <li><a href="index.php?page=1">เพิ่มข้อมูลพนักงาน</a></li>
      <li><a href="index.php?page=2">ข้อมูลพนักงาน</a></li>
    </ul>
  </nav>
  
  <article>
  	<?php
  	function cal($saraly=0){
		$netincome = ($saraly*12)-60000;//เงินเดือนพนักงานทั้งปี
		
		$percent = 0;//ร้อยละ
		$limit = 0;//ไม่เกิน
		
		if($netincome<=150000){
			$percent = 0;
			$limit = 0;
		}else if($netincome>=150001 && $netincome<=300000){
			$percent = 5;
			$limit = 7500;
		}else if($netincome>=300001 && $netincome<=500000){
			$percent = 10;
			$limit = 0;
		}else if($netincome>=500001 && $netincome<=750000){
			$percent = 15;
			$limit = 0;
		}else if($netincome>=750001 && $netincome<=1000000){
			$percent = 20;
			$limit = 0;
		}else if($netincome>=1000001 && $netincome<=2000000){
		    $percent = 25;
			$limit = 0;
		}else if($netincome>=2000001 && $netincome<=5000000){
		 	$percent = 30;
			$limit = 0;
		}else if($netincome>=5000001){
			$percent = 35;
			$limit = 0;
		}
		
		$net = ($netincome*$percent)/100;//คำตอบ
		
		if(($net>$limit) && $limit>0){
			$result = $limit;
		}else{
			$result = $net;
		}
		
		return $result;
  	}
  	
  	?>
    <?php if($page=="1"){ ?>
    	<h1>เพิ่มข้อมูลพนักงาน</h1>
    	<div id="divShow">
    	<form action="" id="form" class="form-horizontal validation_basic" method="post">
    		<label>ชื่อ <span class="required"> * </span></label>
    		<input type="text" name="emp_fname" id="emp_fname" class="form-control" required="required" >
    		
    		
    		<label>นามสกุล <span class="required"> * </span></label>
    		<input type="text" name="emp_lname" id="emp_lname" class="form-control" required="required" >
    		
    		<label>แผนก <span class="required"> * </span></label>
    		<input type="text" name="emp_department" id="emp_department" class="form-control" required="required" >
    		
    		<label>เงินเดือน <span class="required"> * </span></label>
    		<input type="number" name="emp_salary" id="emp_salary" class="form-control" required="required" >
    		
    		<button type="button" id="bt_save" class="btn btn-success" onclick="onSave()">บันทึก</button>
    	</form>
    	</div>
    	
    	<script>
    	function onSave(){
    		var divShow = $("#divShow")
			var form         = $('#form');
			
			if(confirm("คุณต้องการ บันทึกข้อมูล ใช่หรือไม่?")){
				$.ajax({
					type: "POST",
					url: "action.php?inc=action_1",
					data: form.serialize(),
					success: function(res){
						divShow.html(res);
					}
				});
			}
		}

    	</script>
    	
    <?php }else if($page=="2"){ ?>
    	<h1>ข้อมูลพนักงาน</h1>
    	
	  <?php
 
	  $sql ="SELECT
			emp_id,
		emp_fname,
		emp_lname,
		emp_department,
		emp_salary
		FROM tb_employee ORDER BY	emp_department ASC
		";
		$rowcount = $db->query($sql)->num_rows();
	    $query = $db->query($sql)->result();
	  ?>  	
	    	<div id="divShow">
	    		<table border="1">
				<thead>
				<tr>
					<th style="text-align: center;width: 100px;min-width: 100px">Action</th>
					<th style="text-align: center;width: 60px;min-width: 60px">No.</th>
					<th style="text-align: left;width: 200px;min-width: 200px">ชื่อ</th>
					<th style="text-align: left;width: 150px;min-width: 150px">นามสกุล</th>
					<th style="text-align: left;width: 120px;;min-width: 120px">แผนก</th>
					<th style="text-align: left;width: 180px;min-width: 180px">เงินเดือน</th>
					<th style="text-align: left;width: 180px;min-width: 180px">เงินภาษีที่จะต้องจ่ายต่อปี</th>
				</tr>
			</thead>
	 		<tbody>
	 		<?php
	 		$n =1;
	 		if($rowcount >0){
				foreach ($query as $datalist) {
					$emp_id = $datalist["emp_id"];
					$emp_fname = $datalist["emp_fname"];
					$emp_lname = $datalist["emp_lname"];
					$emp_department = $datalist["emp_department"];
					$emp_salary = $datalist["emp_salary"];
	 		?>
 			<tr>
 				<td>
 					<button type="button" onclick="onEdit(<?=$emp_id;?>)">แก้ไข</button>
 					<button type="button"onclick="onDel(<?=$emp_id;?>)">ลบ</button>
 				</td>
 				<td><?=$n;?></td>
 				<td><?=$emp_fname;?></td>
 				<td><?=$emp_lname;?></td>
 				<td><?=$emp_department;?></td>
 				<td><?=number_format($emp_salary,2);?></td>
 				<td><?=number_format(cal($emp_salary),2);?></td>
 			</tr>
 		<?php $n++;}}?> 		
 		</tbody>
 		</table>
    	</div>
    	
    	<script>
    	function onDel(id=0){
    		var divShow = $("#divShow")
			var form         = $('#form');
			
			if(confirm("คุณต้องการ ลบข้อมูล ใช่หรือไม่?")){
				$.ajax({
					type: "POST",
					url: "action.php?inc=action_3",
					data: form.serialize()+"&id="+id,
					success: function(res){
						divShow.html(res);
					}
				});
			}
		}
		
		function onEdit(id=0){
    			location.href = "index.php?page=3&id="+id;
		}

    	</script>
    <?php }else if($page=="3"){ ?>
    	<?php
		$id = 0;
		 if(!empty($_GET["id"])){
		 	$id = $_GET["id"];
		 }else{
		 	$id = "";
		}
		 
    	 $sql ="SELECT
			emp_id,
		emp_fname,
		emp_lname,
		emp_department,
		emp_salary
		FROM tb_employee WHERE  emp_id = '".$id."';
		";
	    $datalist = $db->query($sql)->row();
		
		$emp_id = $datalist["emp_id"];
		$emp_fname = $datalist["emp_fname"];
		$emp_lname = $datalist["emp_lname"];
		$emp_department = $datalist["emp_department"];
		$emp_salary = $datalist["emp_salary"];
    	?>
    	<h1>แก้ไขข้อมูลพนักงาน</h1>
    	<div id="divShow">
    	<form action="" id="form" class="form-horizontal validation_basic" method="post">
    		<input type="hidden" name="id" id="id" class="form-control" required="required" value="<?=$emp_id;?>">
    		
    		<label>ชื่อ <span class="required"> * </span></label>
    		<input type="text" name="emp_fname" id="emp_fname" class="form-control" required="required" value="<?=$emp_fname;?>">
    		
    		<label>นามสกุล <span class="required"> * </span></label>
    		<input type="text" name="emp_lname" id="emp_lname" class="form-control" required="required" value="<?=$emp_lname;?>">
    		
    		<label>แผนก <span class="required"> * </span></label>
    		<input type="text" name="emp_department" id="emp_department" class="form-control" required="required" value="<?=$emp_department;?>">
    		
    		<label>เงินเดือน <span class="required"> * </span></label>
    		<input type="number" name="emp_salary" id="emp_salary" class="form-control" required="required" value="<?=$emp_salary;?>">
    		
    		<button type="button" id="bt_save" class="btn bt_save" onclick="onSave()">บันทึก</button>
    	</form>
    	</div>
    	
    	<script>
    	function onSave(){
    		var divShow = $("#divShow")
			var form         = $('#form');
			
			if(confirm("คุณต้องการ บันทึกข้อมูล ใช่หรือไม่?")){
				$.ajax({
					type: "POST",
					url: "action.php?inc=action_2",
					data: form.serialize(),
					success: function(res){
						divShow.html(res);
					}
				});
			}
		}

    	</script>
    <?php }else{ ?>
    	<h1>Welcome</h1>
   <?php }?>
  </article>
</section>

<footer>
  <p>End</p>
</footer>

</body>
</html>

