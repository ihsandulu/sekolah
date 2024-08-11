<!doctype html>
<html>

<head>

	<?php 
	if(isset($_GET['report'])&&$_GET['report']=="excel"){
		header("Content-type: application/octet-stream");
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment; filename=absensi".date("dMY").".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
	}
	?>
    <?php 
	require_once("meta.php");
	$status=array("1"=>"Masuk","Sakit","Izin","Alpha");
	if(isset($_GET['absensi_date'])){$absensi_date=$_GET['absensi_date'];}else{$absensi_date=date("Y-m-d");}
	if(isset($_GET['grup_id'])){$grup_id=$_GET['grup_id'];}else{$grup_id=0;}
	?>
    <style>
	.absensi{
		border-radius:5px;
		border:#FFCCCC solid 3px !important;
		background-color:#EDE2EF !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.absensi:hover{
		border:#FFCCCC solid 3px !important;
		background-color:#BB93C8 !important;
		color:#000 !important;
		text-decoration:none;
	}
	.uabsensi{
		border-radius:5px;
		border:#EBEBEB solid 3px !important;
		background-color:#CCCCCC !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.uwabsensi{
		border-radius:5px;
		border:#EBEBEB solid 3px !important;
		background-color:#CCCCCC !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
	}
	.uabsensi:hover{
		border:#EBEBEB solid 3px !important;
		background-color:#666666 !important;
		color:#FFF !important;
		text-decoration:none;
	}
	.absensiisi{	
		font-size:18px;
		font-weight:bold;
		text-shadow:white 1px 1px;
		text-decoration:none;
		position:relative;
		left:50%;
		top:50%;
		transform:translate(-50%,-50%);
	}
	.wabsensiisi{	
		font-size:18px;
		font-weight:bold;
		text-shadow:white 1px 1px;
		text-decoration:none;
		position:relative;
	}
	.action{
		position:absolute; 
		left:-0px; 
		bottom:0px; 
		height:35%; 
		/*text-align:right;*/
	}
	.displaynone{display:none;}
	.displayinline{display:inline;}
	</style>
</head>

<body class="no-skin">
	<div class="main-content">
        <div class="main-content-inner">
            
            <div class="page-content">

                <div class="page-header">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="font-size:18px; font-weight:bold;">
                        Attendance : <?=date("d M Y",strtotime($absensi_date));?>                      
                    </div>                 					
                </div>
                <table id="dataTable" class="table table-hovered table-condensed">
					<thead>
						<tr>
							<th>School</th>
							<th>Group</th>
							<th>Date</th>
							<th>Name</th>
							<th>Status</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					
					if($this->session->userdata("sekolah_id")>0){
						$this->db->where("absensi.sekolah_id",$this->session->userdata("sekolah_id"));
					}
					if($this->session->userdata("position_id")=="3"){
						$this->db->where("grup_guru.user_id",$this->session->userdata("user_id"));
					}
					
					
					$this->db->where("absensi.absensi_date",$absensi_date);
					
					if(isset($_GET['grup_id'])&&$_GET['grup_id']>0){
						$this->db->where("absensi.grup_id",$grup_id);
					}
					if($this->session->userdata("position_id")==4){
						$this->db->where("absensi.user_id",$this->session->userdata("user_id"));
					}
					$ab=$this->db
					->select("*,user.user_name as siswa_name")
					->join("sekolah","sekolah.sekolah_id=absensi.sekolah_id","left")
					->join("grup","grup.grup_id=absensi.grup_id","left")
					->join("grup_guru","grup_guru.grup_id=absensi.grup_id","left")
					->join("user","user.user_id=absensi.user_id","left")
					->get("absensi");
					//echo $this->db->last_query();
					foreach($ab->result() as $absensi){?>
						<tr>
							<td><?=$absensi->sekolah_name;?></td>
							<td><?=$absensi->grup_name;?></td>
							<td><?=$absensi->absensi_date;?></td>
							<td><?=$absensi->siswa_name;?></td>
							<td><?=$status[$absensi->absensi_status];?></td>
							<td><?=$absensi->absensi_remarks;?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
				
            </div>
		</div>
    </div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
	
	
</body>

</html>
<?php 
if(isset($_GET['report'])&&$_GET['report']=="print"){?>
<script>
window.print();
</script>
<?php }?>
<script>
setTimeout(function(){ this.close(); }, 500);
</script>