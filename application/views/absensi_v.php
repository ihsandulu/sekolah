<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
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
                        Attendance : <?=$grup_name;?>                      
                    </div>	                    					
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div id="listsiswa-belumabsen" class="panel-body" style="padding-bottom:40px;">
                          
								
                            	
                       	
								
                            </div>
                        </div>
                    </div>
                </div>
				
				<hr/>
				<h4><strong><i class="fa fa-users" style="color:#0000CC;"></i> Attendance <?=date("d M Y");?></strong></h4>
				<div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div id="listsiswa-sudahabsen" class="panel-body" style="padding-bottom:40px;">
                          
								
                            	
                       	
								
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
		</div>
    </div>
	<!-- /#wrap -->
	<?php require_once("footer.php");?>
	<script>
	function listsiswa(status){
		$.get("<?=site_url("api/listsiswa");?>",{sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',grup_id:'<?=$grup_id;?>',kelas_id:'<?=$kelas_id;?>',absensi_date:'<?=date("Y-m-d");?>',status:status})
		.done(function(data){
			if(status==0){
				$("#listsiswa-belumabsen").html(data);
			}else{
				$("#listsiswa-sudahabsen").html(data);
			}
		});
	}
	
	function absensi(user_id,absensi_status,absensi_remarks){
		$.get("<?=site_url("api/absensi");?>",{user_id:user_id,absensi_status:absensi_status,sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',grup_id:'<?=$grup_id;?>',kelas_id:'<?=$kelas_id;?>',absensi_date:'<?=date("Y-m-d");?>',absensi_remarks:$(absensi_remarks).val()})
		.done(function(data){
			listsiswa(0);
			listsiswa(1);
		});
	}
	
	function delete_absensi(absensi_id){
		$.get("<?=site_url("api/delete_absensi");?>",{absensi_id:absensi_id})
		.done(function(data){
			listsiswa(0);
			listsiswa(1);
		});
	}
	
	$(document).ready(function(){	
			listsiswa(0);
			listsiswa(1);
	});
	</script>
	
</body>

</html>
