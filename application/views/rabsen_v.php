<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");
	$status=array("1"=>"Masuk","Sakit","Izin","Alpha");
	if(isset($_GET['absen_date'])){$absen_date=$_GET['absen_date'];}else{$absen_date=date("Y-m-d");}
	if(isset($_GET['kelas_id'])){$kelas_id=$_GET['kelas_id'];}else{$kelas_id=0;}
	?>
    <style>
	.absen{
		border-radius:5px;
		border:#FFCCCC solid 3px !important;
		background-color:#EDE2EF !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.absen:hover{
		border:#FFCCCC solid 3px !important;
		background-color:#BB93C8 !important;
		color:#000 !important;
		text-decoration:none;
	}
	.uabsen{
		border-radius:5px;
		border:#EBEBEB solid 3px !important;
		background-color:#CCCCCC !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.uwabsen{
		border-radius:5px;
		border:#EBEBEB solid 3px !important;
		background-color:#CCCCCC !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
	}
	.uabsen:hover{
		border:#EBEBEB solid 3px !important;
		background-color:#666666 !important;
		color:#FFF !important;
		text-decoration:none;
	}
	.absenisi{	
		font-size:18px;
		font-weight:bold;
		text-shadow:white 1px 1px;
		text-decoration:none;
		position:relative;
		left:50%;
		top:50%;
		transform:translate(-50%,-50%);
	}
	.wabsenisi{	
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
<?php require_once("header.php");?>
	<div class="main-content">
        <div class="main-content-inner">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <ul class="breadcrumb">
                    <li>
                        <i class="ace-icon fa fa-home home-icon"></i>
                        <a href="<?=site_url();?>">Home</a>
                    </li>
                    <li class="active">Attendance</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="font-size:18px; font-weight:bold;">
                        Attendance : <?=$kelas_name;?>                      
                    </div>	
					<div>
					<form class="form-inline">
					  <div class="form-group">
						<label for="absen_date">Date:</label>
						<input type="date" class="form-control date" id="absen_date" name="absen_date" value="<?=$absen_date;?>">
					  </div>
					  &nbsp;&nbsp;
					  <div class="form-group">
						<label for="kelas_id">Class:</label>
						<select name="kelas_id" id="kelas_id" class="form-control">
							<option value="0" <?=($kelas_id==0)?'selected="selected"':"";?>>Select Class</option>
							<?php 
							if($this->session->userdata("sekolah_id")>0){
								$this->db->where("kelas_sekolah.sekolah_id",$this->session->userdata("sekolah_id"));
							}
							$gru=$this->db
							->join("kelas","kelas.kelas_id=kelas_sekolah.kelas_id","left")
							->get("kelas_sekolah");
							foreach($gru->result() as $kelas){?>							
							<option value="<?=$kelas->kelas_id;?>" <?=($kelas_id==$kelas->kelas_id)?'selected="selected"':"";?>><?=$kelas->kelas_name;?></option>
							<?php }?>
						</select>
					  </div>
					  
					  <button type="submit" class="btn btn-default">Submit</button>
					  <a target="_blank" href="pabsen?absen_date=<?=$absen_date;?>&kelas_id=<?=$kelas_id;?>&report=print" class="btn btn-warning">Print</a>
					  <a target="_blank" href="pabsen?absen_date=<?=$absen_date;?>&kelas_id=<?=$kelas_id;?>&report=excel" class="btn btn-info">Excel</a>
					</form>
					</div>                    					
                </div>
                <table id="dataTable" class="table table-hovered table-condensed">
					<thead>
						<tr>
							<th>School</th>
							<th>Date</th>
							<th>Class</th>
							<th>Name</th>
							<th>Status</th>
							<th>Remarks</th>
						</tr>
					</thead>
					<tbody>
					<?php 
					
					if($this->session->userdata("sekolah_id")>0){
						$this->db->where("absen.sekolah_id",$this->session->userdata("sekolah_id"));
					}				
					
					$this->db->where("absen.absen_date",$absen_date);
					if($this->session->userdata("position_id")==4){
						$this->db->where("absen.user_id",$this->session->userdata("user_id"));
					}
					$ab=$this->db
					->select("*,user.user_name as siswa_name")
					->join("sekolah","sekolah.sekolah_id=absen.sekolah_id","left")
					->join("user","user.user_id=absen.user_id","left")
					->join("kelas","kelas.kelas_id=absen.kelas_id","left")
					->get("absen");
					// echo $this->db->last_query();
					foreach($ab->result() as $absen){?>
						<tr>
							<td><?=$absen->sekolah_name;?></td>
							<td><?=$absen->absen_date;?></td>
							<td><?=$absen->kelas_name;?></td>
							<td><?=$absen->siswa_name;?></td>
							<td><?=$status[$absen->absen_status];?></td>
							<td><?=$absen->absen_remarks;?></td>
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
