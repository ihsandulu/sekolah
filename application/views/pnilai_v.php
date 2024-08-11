<!doctype html>
<html>

<head>
	<?php 
	if(isset($_GET['report'])&&$_GET['report']=="excel"){
		header("Content-type: application/octet-stream");
		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header("Content-Disposition: attachment; filename=nilai".date("dMY").".xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		
	}
	?>
    <?php 
	require_once("meta.php");
	$status=array("1"=>"Masuk","Sakit","Izin","Alpha");
	if(isset($_GET['test_detail_date'])){$test_detail_date=$_GET['test_detail_date'];}else{$test_detail_date=date("Y-m-d");}
	if(isset($_GET['grup_id'])){$grup_id=$_GET['grup_id'];}else{$grup_id=0;}
	if(isset($_GET['materi_id'])){$materi_id=$_GET['materi_id'];}else{$materi_id=0;}
	?>
    <style>
	.test_detail{
		border-radius:5px;
		border:#FFCCCC solid 3px !important;
		background-color:#EDE2EF !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.test_detail:hover{
		border:#FFCCCC solid 3px !important;
		background-color:#BB93C8 !important;
		color:#000 !important;
		text-decoration:none;
	}
	.utest_detail{
		border-radius:5px;
		border:#EBEBEB solid 3px !important;
		background-color:#CCCCCC !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.uwtest_detail{
		border-radius:5px;
		border:#EBEBEB solid 3px !important;
		background-color:#CCCCCC !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
	}
	.utest_detail:hover{
		border:#EBEBEB solid 3px !important;
		background-color:#666666 !important;
		color:#FFF !important;
		text-decoration:none;
	}
	.test_detailisi{	
		font-size:18px;
		font-weight:bold;
		text-shadow:white 1px 1px;
		text-decoration:none;
		position:relative;
		left:50%;
		top:50%;
		transform:translate(-50%,-50%);
	}
	.wtest_detailisi{	
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
                        Scores : <?=$grup_name;?>                      
                    </div>	                 					
                </div>
                <table id="dataTable" class="table table-hovered table-condensed">
					<thead>
						<tr>
							<th>School</th>
							<th>Group</th>
							<th>Lesson</th>
							<th>Name</th>
							<th>Value</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					
					if($this->session->userdata("sekolah_id")>0){
						$this->db->where("test_detail.sekolah_id",$this->session->userdata("sekolah_id"));
					}
					if($this->session->userdata("position_id")=="3"){
						$this->db->where("grup_guru.user_id",$this->session->userdata("user_id"));
					}
					
					
					if(isset($_GET['grup_id'])&&$_GET['grup_id']>0){
						$this->db->where("grup_guru.grup_id",$grup_id);
					}
					
					
					if($this->session->userdata("position_id")==4){
						$this->db->where("test_detail.user_id",$this->session->userdata("user_id"));
					}
					$tdetail=$this->db
					->select("sekolah.sekolah_name, grup.grup_name, materi.materi_title,user.user_name AS siswa_name, SUM(IF(test_detail_answer=soal_key,1,0))AS nilai, COUNT(test_detail_answer)AS jml_soal")
					->join("user","user.user_id=test_detail.user_id","left")
					->join("materi","materi.materi_id=test_detail.materi_id","left")
					->join("grup_guru","grup_guru.grup_id=materi.grup_id","left")
					->join("grup","grup.grup_id=grup_guru.grup_id","left")
					->join("sekolah","sekolah.sekolah_id=test_detail.sekolah_id","left")
					->where("user.position_id","4")
					->group_by("test_detail.user_id")
					->get("test_detail");
					//echo $this->db->last_query();
					foreach($tdetail->result() as $test_detail){
					?>
						<tr>
							<td><?=$test_detail->sekolah_name;?></td>
							<td><?=$test_detail->grup_name;?></td>
							<td><?=$test_detail->materi_title;?></td>
							<td><?=$test_detail->siswa_name;?></td>
							<td><?=round($test_detail->nilai/$test_detail->jml_soal*100);?></td>
						</tr>
					<?php }?>
					</tbody>
				</table>
				
            </div>
		</div>
    </div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
	<script>
	function cari_materi(a){
	$.get("<?=site_url("api/cari_materi");?>",{grup_id:a,materi_id:'0'})
	.done(function(data){$("#materi_id").html(data);});
	}
	</script>
	
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