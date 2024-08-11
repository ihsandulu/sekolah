<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
    <style>
	.grupluar{padding:5px;}
	.grupluar:hover{text-decoration:none;}
	.grup{
		border-radius:5px;
		border:#FFCCCC solid 3px !important;
		background-color:#EDE2EF !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:150px;
	}
	.grupadmin{
		border-radius:5px;
		border:#FFCCCC solid 3px !important;
		background-color:#FFA8A8 !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:150px;
	}
	.grup:hover{
		border:#FFCCCC solid 3px !important;
		background-color:#BB93C8 !important;
		color:#000 !important;
		text-decoration:none;
	}
	.grupisi{	
		font-size:18px;
		font-weight:bold;
		text-shadow:white 1px 1px;
		text-decoration:none;
		position:relative;
		left:50%;
		top:50%;
		transform:translate(-50%,-50%);
	}
	.border{
		border:black solid 1px;
	}
	.delete{position:absolute; right:0px;}
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
                    <li class="active">Group</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
					<h1>
						Group 
					
					<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
                    <?php if($this->session->userdata("position_id")!=1&&$this->session->userdata("position_id")!=2){
					$martop="margin-top:-30px;";
					?>
                    <form class="form-inline" method="post">	
						<div class="form-group">				
                        	<input placeholder="Group Number" type="text" name="grup_no" class="form-control"/>
						</div>
                        <button type="submit" class="btn btn-info btn-sm">Join</button>
                    </form>
					<?php }else{$martop="";}?>
					<?php if($this->session->userdata("position_id")!="4"){?>
					<form method="post" class="col-md-2" style="<?=$martop;?> float:right;">							
                       
                        <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                        <input type="hidden" name="grup_id"/>
                       
                    </form>
					<?php }?>
                    <?php }?>		                       
					</h1>			
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body" >
                            <?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
                                <div class="">
                                    <?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Group";}else{$namabutton='name="create"';$judul="New Group";}?>	
                                    <div class="lead"><h3><?=$judul;?></h3></div>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                      
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="grup_name">Group:</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="grup_name" name="grup_name" placeholder="Enter Group" value="<?=$grup_name;?>">
                                        </div>							  
                                    </div>
                                    <div class="col-md-offset-2 col-md-10 alert alert-danger alert-dismissable fade in" id="cekgrup" style="display:none;">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        <strong>Attention!</strong> Group has been used.
                                    </div>
        
                                      <script>
                                      $("#grup_name").keyup(function(){
                                          $.get("<?=site_url("api/cekgrup");?>",{grup_name:$("#grup_name").val(),sekolah_id:'<?=$this->session->userdata("sekolah_id");?>'})
                                          .done(function(data){
                                            if(data>0){
                                                $("#cekgrup").fadeIn();$("#submit").prop("disabled","disabled");
                                            }else{
                                                $("#cekgrup").fadeOut();$("#submit").prop("disabled","");
                                            }
                                          });
                                      });
                                      </script>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="kelas_id">Class:</label>
                                        <div class="col-sm-10">										 
                                          <select name="kelas_id" class="form-control">
                                          <?php 
										  if($this->session->userdata("position_id")=="3"){
											$kel=$this->db
											->join("kelas","kelas.kelas_id=kelas_guru.kelas_id","left")
											->where("user_id",$this->session->userdata("user_id"))
											->get("kelas_guru");
										  }
										   if($this->session->userdata("position_id")!="3"){
										  	$kel=$this->db
											->get("kelas");
										  }
										  
										  $kelas=$this->db->last_query();
										  foreach($kel->result() as $kelas){?>
                                          	<option value="<?=$kelas->kelas_id;?>" <?=($kelas_id==$kelas->kelas_id)?"selected":"";?>><?=$kelas->kelas_name;?></option>
                                          <?php }?>
                                          </select>
                                        </div>							  
                                    </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="matpel_id">Subjects:</label>
                                        <div class="col-sm-10"> 
                                          <select name="matpel_id" class="form-control">
										  <option value="0" <?=($matpel_id=="0")?"selected":"";?>>Select Subjects</option>
                                          <?php 
										  
										  if($this->session->userdata("position_id")=="3"){
											$mat=$this->db
											  ->join("matpel","matpel.matpel_id=matpel_sekolah.matpel_id","left")
											  ->get("matpel_sekolah");
										  }
										   if($this->session->userdata("position_id")!="3"){
										  	$mat=$this->db
											  ->join("matpel","matpel.matpel_id=matpel_sekolah.matpel_id","left")
											  ->get("matpel_sekolah");
										  }
										  
										  foreach($mat->result() as $matpel){?>
                                          	<option value="<?=$matpel->matpel_id;?>" <?=($matpel_id==$matpel->matpel_id)?"selected":"";?>><?=$matpel->matpel_name;?></option>
                                          <?php }?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                      
                                      
                                      <input type="hidden" name="sekolah_id" value="<?=$this->session->userdata("sekolah_id");?>"/>
                                      <input type="hidden" name="grup_id" value="<?=$grup_id;?>"/>					  				
                                      <input type="hidden" name="user_id" value="<?=$this->session->userdata("user_id");?>"/>					  					  
                                      <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("grup");?>">Back</button>
                                        </div>
                                      </div>
                                    </form>
                                </div>
                                <?php }else{?>	
								<?php if($message!=""){?>
								<div class="alert alert-info alert-dismissable">
								  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
								  <strong><?=$message;?></strong>
								</div>
								<?php }?>
                            	<?php
								
								if($this->session->userdata("position_id")=="1"||$this->session->userdata("position_id")=="2"){
									$this->db->select("*,grup.grup_id as gid");
									$this->db->join("kelas","kelas.kelas_id=grup.kelas_id","left");
									$this->db->join("matpel","matpel.matpel_id=grup.matpel_id","left");
									if($this->session->userdata("sekolah_id")!="0"){
										$this->db->where("grup.sekolah_id",$this->session->userdata("sekolah_id"));
									}
									$gru=$this->db->get("grup");
								}
								if($this->session->userdata("position_id")=="4"){
									$this->db->select("*,grup_siswa.grup_id as gid");
									$this->db->join("grup","grup.grup_id=grup_siswa.grup_id","left");
									$this->db->join("kelas","kelas.kelas_id=grup.kelas_id","left");
									$this->db->join("matpel","matpel.matpel_id=grup.matpel_id","left");
									$this->db->where("grup_siswa.sekolah_id",$this->session->userdata("sekolah_id"));
									$this->db->where("grup_siswa.user_id",$this->session->userdata("user_id"));
									$gru=$this->db->get("grup_siswa");
								}
								if($this->session->userdata("position_id")=="3"){
									$this->db->select("*,grup_guru.grup_id as gid");
									$this->db->join("grup","grup.grup_id=grup_guru.grup_id","left");
									$this->db->join("kelas","kelas.kelas_id=grup.kelas_id","left");
									$this->db->join("matpel","matpel.matpel_id=grup.matpel_id","left");
									$this->db->where("grup_guru.sekolah_id",$this->session->userdata("sekolah_id"));
									$this->db->where("grup_guru.user_id",$this->session->userdata("user_id"));
									$gru=$this->db->get("grup_guru");
								}
								//echo $this->db->last_query();
								foreach($gru->result() as $grup){?>
                                <a href="<?=site_url("materi?grup_id=".$grup->gid);?>" class="grupluar col-md-4 col-sm-6 col-xs-12">
									<button type="button" onClick="deleten(event,'<?=$grup->gid;?>')" name="delete" value="OK" class="btn btn-danger btn-xs delete">&times;</button>
									<?php if($grup->sekolah_id=="0"){$gr="grupadmin";}else{$gr="grup";}?>
									<div class="<?=$gr;?>">
										<div class="grupisi">
										<?=$grup->grup_name;?>
										<div style="font-size:14px; font-weight:normal; margin-top:20px; margin-bottom:20px;">( Class : <?=$grup->kelas_name;?>, Subjects : <?=$grup->matpel_name;?>, Token : <?=$grup->grup_no;?> )</div>
										<?php if($this->session->userdata("position_id")!=4){?>	
										<form method="post">
										<button type="submit" name="edit" value="ok" class="btn btn-warning btn-block">Update</button>
										<input type="hidden" name="grup_id" value="<?=$grup->gid;?>"/>
										</form>
										<?php }?>
										</div>
									</div>
                                </a>
								<div id="deleteid<?=$grup->gid;?>" style="display:none;padding:15px;">
								<form method="post">
									<button name="signout" value="OK" class="col-md-12 btn btn-warning" style="height:100px !important;">Sign Out from Group</button>
									<input type="hidden" name="grup_id" value="<?=$grup->gid;?>"/>
								</form>
								<?php if($this->session->userdata("position_id")!=4&&$this->session->userdata("position_id")!=3){?>	
								<div>&nbsp;</div>
								<form method="post">
									<button name="delete" value="OK" class="col-md-12 btn btn-danger" style="height:100px !important;">Delete Group</button>
									<input type="hidden" name="grup_id" value="<?=$grup->gid;?>"/>
								</form>
								</div>
								<?php }?>
								<?php }?>
							<?php }?>
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
	function deleten(event,a){
		 event.preventDefault();
		$(".modal-title").text("Delete Group");
		$(".modal-body").html($("#deleteid"+a).html());
		$(".modal-body").css("height",$("#deleteid").css("height"));
		$("#myModal").modal();
		
	}
	</script>
</body>

</html>
