<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
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
                    <h1>Group</h1>
					<?php if(!isset($_POST['new'])&&!isset($_POST['edit'])){?>
                    
                    <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">							
                       
                        <button name="new" class="btn btn-info btn-block btn-sm" value="OK" style="">New</button>
                        <input type="hidden" name="grup_id"/>
                       
                    </form>
                  
                    <?php }?>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
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
                                          <?php $kel=$this->db
										  ->join("kelas","kelas.kelas_id=kelas_sekolah.kelas_id","left")
										  ->get("kelas_sekolah");
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
                                          <?php $mat=$this->db
										  ->join("matpel","matpel.matpel_id=matpel_sekolah.matpel_id","left")
										  ->get("matpel_sekolah");
										  foreach($mat->result() as $matpel){?>
                                          	<option value="<?=$matpel->matpel_id;?>" <?=($matpel_id==$matpel->matpel_id)?"selected":"";?>><?=$matpel->matpel_name;?></option>
                                          <?php }?>
                                          </select>
                                        </div>
                                      </div>
                                      
                                      
                                      
                                      
                                      <input type="hidden" name="sekolah_id" value="<?=$this->session->userdata("sekolah_id");?>"/>
                                      <input type="hidden" name="grup_id" value="<?=$grup_id;?>"/>					  					  
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
                                      <strong><?=$message;?></strong><br/><?=$uploadgrup_picture;?>
                                    </div>
                                    <?php }?>
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">				
                                        <table id="dataTable" class="table table-condensed table-hover">
                                            <thead>
                                                <tr>
                                                  <th>School</th>
                                                    <th>No.</th>
                                                    <th>Group</th>
                                                    <th>Class</th>
                                                    <th>Subjects</th>
                                                    <th>Student</th>
                                                    <th class="col-md-2">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody> 
                                                <?php 
												if($this->session->userdata("sekolah_id")>0){
													$this->db->where("grup.sekolah_id",$this->session->userdata("sekolah_id"));
												}
												$usr=$this->db
                                                ->join("(SELECT grup_id, COUNT(grup_siswa_id)AS jmlorg FROM grup_siswa GROUP BY grup_id)grup_siswa","grup_siswa.grup_id=grup.grup_id","left")
                                                ->join("sekolah","sekolah.sekolah_id=grup.sekolah_id","left")
                                                ->join("kelas","kelas.kelas_id=grup.kelas_id","left")
                                                ->join("matpel","matpel.matpel_id=grup.matpel_id","left")
                                                ->get("grup");
												//echo $this->db->last_query();
                                                foreach($usr->result() as $grup){?>
                                                <tr>
                                                  <td><?=$grup->sekolah_name;?></td>											
                                                    <td><?=$grup->grup_no;?></td>										
                                                    <td><?=$grup->grup_name;?></td>
                                                    <td><?=$grup->kelas_name;?></td>
                                                    <td><?=$grup->matpel_name;?></td>
                                                    <td><?=$grup->jmlorg;?></td>
                                                    <td style="padding-left:0px; padding-right:0px;">
                                                        <form method="post" class="col-md-4" style="padding:0px;">
                                                            <a title="Student List" data-toggle="tooltip" href="<?=site_url("grup_siswa?grup_id=".$grup->grup_id);?>" class="btn btn-info "><span class="fa fa-users" style="color:white;"></span> </a>
                                                        </form>
                                                    
                                                        <form method="post" class="col-md-4" style="padding:0px;">
                                                            <button class="btn btn-warning " name="edit" value="OK"><span class="fa fa-edit" style="color:white;"></span> </button>
                                                            <input type="hidden" name="grup_id" value="<?=$grup->grup_id;?>"/>
                                                        </form>
                                                    
                                                        <form method="post" class="col-md-4" style="padding:0px;">
                                                            <button class="btn btn-danger delete" name="delete" value="OK"><span class="fa fa-close" style="color:white;"></span> </button>
                                                            <input type="hidden" name="grup_id" value="<?=$grup->grup_id;?>"/>
                                                        </form>											</td>
                                                </tr>
                                                <?php }?>
                                            </tbody>
                                        </table>
                                      </div>
                                    </div>
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
</body>

</html>
