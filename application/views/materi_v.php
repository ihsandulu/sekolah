<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
    <style>
	.materi{
		border-radius:5px;
		border:#FFCCCC solid 3px !important;
		background-color:#EDE2EF !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.materi:hover{
		border:#FFCCCC solid 3px !important;
		background-color:#BB93C8 !important;
		color:#000 !important;
		text-decoration:none;
	}
	.umateri{
		border-radius:5px;
		border:#EBEBEB solid 3px !important;
		background-color:#CCCCCC !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;		
	}
	.umateri:hover{
		border:#EBEBEB solid 3px !important;
		background-color:#666666 !important;
		color:#FFF !important;
		text-decoration:none;
	}
	.materiisi{	
		font-size:18px;
		font-weight:bold;
		text-shadow:white 1px 1px;
		text-decoration:none;
		position:relative;
		left:50%;
		top:50%;
		transform:translate(-50%,-50%);
	}
	.action{position:absolute; left:-0px; bottom:0px; height:35%; text-align:right;}
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
                    <li class="active">Lesson</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
					<?php if($this->session->userdata("position_id")!=4){$colmd="col-md-6 col-sm-12 col-xs-12";}else{$colmd="col-md-10 col-sm-12 col-xs-12";}?>
                    <div class="<?=$colmd;?>" style="font-size:18px; font-weight:bold;">
                        Lesson : <?=$grup_name;?>                      
                    </div>	
                    <?php if(!isset($_POST['new'])&&!isset($_POST['edit'])&&$this->session->userdata("position")!="4"){?>
                     <form method="post" class="col-md-2 col-sm-12 col-xs-12" style="">							
                       
                        <a href="<?=site_url("grupt");?>" class="btn btn-warning btn-block btn-sm fa fa-mail-reply"> Back</a>
                       
                    </form>
					<?php if($this->session->userdata("position_id")!=4){?>
                    <form method="post" class="col-md-2 col-sm-12 col-xs-12" style="">							
                       
                        <button name="new" class="btn btn-info btn-block btn-sm fa fa-bullseye" value="OK" style=""> New</button>
                        <input type="hidden" name="user_id"/>
                       
                    </form>
                    <form method="post" class="col-md-2 col-sm-12 col-xs-12" style="">							
                       
                       <a href="<?=site_url("absensi?grup_id=".$grup_id);?>" class="btn btn-primary btn-block btn-sm fa fa-users"> Attendance</a>
                       
                    </form>
                  	<?php }?>
                    <?php }?>					
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body" >
                            <?php if(isset($_POST['new'])||isset($_POST['edit'])){?>
							<?php if($this->session->userdata("sekolah_id")!=0){?>
							 <!--<form class="form-inline">							  
							  <div class="form-group">
								<label for="matpel">Subjects:</label>
								<select onChange="cari_internet()" class="form-control" id="matpel">
								<option selected="selected">Select Subjects</option>
								<?php $mat=$this->db
								->get("matpel");
								foreach($mat->result() as $matpel){?>
								<option value="<?=$matpel->matpel_id;?>"><?=$matpel->matpel_name;?></option>
								<?php }?>
								</select>
							  </div>
							  <div class="form-group">
								<label for="kelas">Class:</label>
								<select onChange="cari_internet()" class="form-control" id="kelas">
								<option selected="selected">Select Class</option>
								<?php $kel=$this->db
								->join("kelas","kelas.kelas_id=kelas_guru.kelas_id","left")
								->where("user_id",$this->session->userdata("user_id"))
								->get("kelas_guru");
								foreach($kel->result() as $kelas){?>
								<option value="<?=$kelas->kelas_id;?>"><?=$kelas->kelas_name;?></option>
								<?php }?>
								</select>
							  </div>
							</form> -->
							<div id="materiinternet" style="margin-top:20px;"></div>
							<script>
							$(document).ready(function(){cari_internet();});
							function cari_internet(){
								$("#loading").show();
								$.get("<?=$identity->identity_server;?>/api/tampil_materi",{kelas_id:'<?=$kelas_id;?>',matpel_id:'<?=$matpel_id;?>',grup_id:'<?=$grup_id;?>',sekolah_id:'<?=$this->session->userdata("sekolah_id");?>'})
								.done(function(data){
									//echo data;
									$("#materiinternet").html(data);
									$("#loading").hide();
								});
							}
							</script>
							<script>
							function masukin_materi(a,b,c,d,e){
								$.get("<?=site_url("api/masukin_materi");?>",{materi_title:a,grup_id:b,materi_content:$("#materi_content"+c).html(),sekolah_id:d,materi_server:e})
								.done(function(data){
									window.location.href = window.location.href;
								});
							}
							</script>
							<?php }else{?>
                               <div class="">
                                    <?php if(isset($_POST['edit'])){$namabutton='name="change"';$judul="Update Lesson";}else{$namabutton='name="create"';$judul="New Lesson";}?>	
                                    <div class="lead"><h3><?=$judul;?></h3></div>
                                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                      
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="materi_title">Title:</label>
                                        <div class="col-sm-10">
                                          <input type="text" maxlength="150" class="form-control" id="materi_title" name="materi_title" placeholder="Enter Title" value="<?=$materi_title;?>">
                                        </div>							  
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-2" for="materi_content">Content:</label>
                                        <div class="col-sm-10">
                                          <textarea class="form-control" id="materi_content" name="materi_content"><?=$materi_content;?></textarea>
                                        </div>							  
                                    </div>
                                    <script>
									var roxyFileman = '<?=site_url("fileman/index.html");?>'; 
									  CKEDITOR.replace(
										'materi_content',{filebrowserBrowseUrl:roxyFileman,
																	filebrowserImageBrowseUrl:roxyFileman+'?type=image',
																	removeDialogTabs: 'link:upload;image:upload',
																	height: '100px',
																	stylesSet: 'my_custom_style'}
										); 
									</script>
                                      
                                      
                                      <input type="hidden" name="sekolah_id" value="<?=$this->session->userdata("sekolah_id");?>"/>
                                      <input type="hidden" name="grup_id" value="<?=$grup_id;?>"/>					  				
                                      <input type="hidden" name="materi_id" value="<?=$materi_id;?>"/>					  					  
                                      <div class="form-group"> 
                                        <div class="col-sm-offset-2 col-sm-10">
                                            <button type="submit" id="submit" class="btn btn-primary col-md-5" <?=$namabutton;?> value="OK">Submit</button>
                                            <button class="btn btn-warning col-md-offset-1 col-md-5" onClick="location.href=<?=site_url("user");?>">Back</button>
                                        </div>
                                      </div>
                                    </form>
                                </div>
							<?php }?>
                                <?php }else{?>	
								<div id="jam"></div>
                            	<?php
								
								if($this->session->userdata("sekolah_id")>0){
									$this->db->where("sekolah_id",$this->session->userdata("sekolah_id"));
								}
								
								$mate=$this->db
								->where("grup_id",$grup_id)
								->get("materi");
								foreach($mate->result() as $materi){?>
								<?php 
								if($materi->materi_publish==0){
								
									$faeye="fa-eye-slash"; 
									$btn="btn-default"; 
									$title="Unpublish"; 
									$matr="umateri";
									
								}else{
								
									$faeye="fa-eye"; 
									$btn="btn-success"; 
									$title="Publish"; 
									$matr="materi";
									
								}
																
								if($this->session->userdata("position_id")==4){
									if($materi->soal_publish==0){
									
										$display="displaynone";
										
									}else{
									
										$display="displayinline";
										
									}											
								}else{
								
									$display="";
									
								}
								?>							
								
                                <div class="col-md-4  col-sm-6 col-xs-12 <?=$display;?>" style="" id="materiu<?=$materi->materi_id;?>">
                                <a id="materi<?=$materi->materi_id;?>" href="<?=site_url("soal?materi_id=".$materi->materi_id."&grup_id=".$grup_id);?>" class="<?=$matr;?> col-md-12 col-sm-12 col-xs-12">
									<div class="materiisi" id="materiisi<?=$materi->materi_id;?>"><?=$materi->materi_title;?></div>
                                </a>
                                    <?php if($this->session->userdata("position_id")!="4"){?>
                                    <div class="action col-md-6">
                                    <div class="" style="padding:0px; width:30%; height:100%; float:left;">
										
                                        <button onClick="publishin('<?=$materi->materi_id;?>',this.value)" data-toggle="tooltip" title="<?=$title;?>" class="btn <?=$btn;?> btn-xs fa <?=$faeye;?>" id="materi_publish<?=$materi->materi_id;?>" name="publish" value="<?=$materi->materi_publish;?>" style="width:100%; height:100%; color:white;"></button>
                                    </div>
									
									<?php if($this->session->userdata("sekolah_id")==0){?>
									<form method="post" class="" style="padding:0px; width:30%; height:100%; float:left;">
                                        <button data-toggle="tooltip" title="Update" class="btn btn-warning btn-xs" name="edit" value="OK" style="width:100%; height:100%;"><span class="fa fa-edit" style="color:white;"></span> </button>
                                        <input type="hidden" name="materi_id" value="<?=$materi->materi_id;?>"/>
                                    </form>
                                	<?php }?>
                                    <form method="post" class="" style="padding:0px; width:30%; height:100%; float:left;">
                                        <button data-toggle="tooltip" title="Delete" class="btn btn-danger btn-xs delete" name="delete" value="OK" style="width:100%; height:100%;"><span class="fa fa-close" style="color:white;"></span> </button>
                                        <input type="hidden" name="materi_id" value="<?=$materi->materi_id;?>"/>
                                    </form>	
                                    </div>
                                    <?php }?>
                                </div>
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
	function publish(materi_id){
		$("#materi_publish"+materi_id).val("1").attr("title","Publish").removeClass("fa-eye-slash").addClass("fa-eye").removeClass("btn-default").addClass("btn-success");
		$("#materi"+materi_id).removeClass("umateri").addClass("materi");
		<?php if($this->session->userdata("position_id")!=4){?>
		$(".modal-header").html("Publish");
		$(".modal-body").html("Publish Success");
		$("#myModal").modal();
		<?php }?>
	}
	
	function unpublish(materi_id){
		$("#materi_publish"+materi_id).val("0").attr("title","Unpublish").removeClass("fa-eye").addClass("fa-eye-slash").removeClass("btn-success").addClass("btn-default");
		$("#materi"+materi_id).removeClass("materi").addClass("umateri");
		<?php if($this->session->userdata("position_id")!=4){?>
		$(".modal-header").html("Publish");
		$(".modal-body").html("Unpublish Success");
		$("#myModal").modal();
		<?php }?>
	}
	
	function publishin(materi_id,materi_publish){
		$.get("<?=site_url("api/publish");?>",{sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',materi_id:materi_id,materi_publish:materi_publish})
		.done(function(data){
			if(data=="Publish"){
				publish(materi_id);
			}else{
				unpublish(materi_id);
			}
		});
	}
	</script>
	<script>
	function cek_publish_materi(materi_id){
		
		$.get("<?=site_url("api/cek_publish_materi");?>",{sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',materi_id:materi_id})
		.done(function(data){ 
			if(data=="1"){
				publish(materi_id);
				$("#materiu"+materi_id).removeClass("displaynone").addClass("displayinline");
			}else{
				unpublish(materi_id);
				$("#materiu"+materi_id).removeClass("displayinline").addClass("displaynone");
			}	
		});
		
	}
	var a =0;
	<?php if($this->session->userdata("position_id")==4){?>
		setInterval(function(){
		
		<?php
		$mate=$this->db
		->where("grup_id",$grup_id)
		->get("materi");
		foreach($mate->result() as $materi){?>
		
			cek_publish_materi(<?=$materi->materi_id;?>,'0');
		
		<?php } ?>
		
		},1000);						
	<?php }?>	
	
	</script>
</body>

</html>
