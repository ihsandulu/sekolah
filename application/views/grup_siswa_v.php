<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
    <script>
	function isi_grup_siswa(){
		$.get("<?=site_url("api/isi_grup_siswa");?>",{sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',kelas_id:'<?=$kelas_id;?>',grup_id:'<?=$this->input->get("grup_id");?>'})
		.done(function(data){
			$("#grup_siswa_id").html(data);
		});
	}
	
	function isi_siswa(){
		$.get("<?=site_url("api/isi_siswa");?>",{sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',kelas_id:'<?=$kelas_id;?>',position_id:'4'})
		.done(function(data){
			$("#user_id").html(data);
		});
	}
	
	function inputsiswa(){
		$.get("<?=site_url("api/inputsiswa");?>",{sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',user_id:$("#user_id").val(),kelas_id:'<?=$kelas_id;?>',grup_id:'<?=$this->input->get("grup_id");?>'})
		.done(function(data){
			isi_grup_siswa();
			isi_siswa();
		});
	}
	
	function deletesiswa(){
		$.get("<?=site_url("api/deletesiswa");?>",{sekolah_id:'<?=$this->session->userdata("sekolah_id");?>',grup_siswa_id:$("#grup_siswa_id").val()})
		.done(function(data){
			isi_grup_siswa();
			isi_siswa();
		});
	}
	</script>
    
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
                    <li class="active">Siswa Grup</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Siswa Group : <?=$grup_name;?>                         
                    </h1>	
                    
                    <form method="post" class="col-md-2" style="margin-top:-30px; float:right;">							
                       
                        <a type="button" href="<?=site_url("grup");?>" class="btn btn-warning btn-block btn-sm fa fa-mail-reply"> Back</a>
                       
                    </form>				
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                                   
                                    <div class="box">
                                        <div id="collapse4" class="body table-responsive">	
                                       
                                        <div class="col-md-12">
                                            <div class="panel panel-info" style="">
                                                <div class="panel-heading">
													<span style="font-size:20px; font-weight:bold;">Siswa</span> 
													(Tekan CTRL untuk memilih lebih dari satu)
												</div>
                                                <div class="panel-body">
                                                    <div class="col-md-5">
                                                       <select id="user_id" name="user_id" multiple class="form-control" style="height:350px;">
                                                        <?php $sis=$this->db
														->where("kelas_id",$kelas_id)
														->where("position_id",4)
														->where("sekolah_id",$this->session->userdata("sekolah_id"))
														->get("user");
														//$a = $this->db->last_query();
                                                        foreach($sis->result() as $siswa){
                                                        $siswagrup=$this->db
                                                        ->where("grup_id",$this->input->get("grup_id"))
                                                        ->where("user_id",$siswa->user_id)
														->where("kelas_id",$kelas_id)
                                                        ->where("sekolah_id",$this->session->userdata("sekolah_id"))
                                                        ->get("grup_siswa")->num_rows();
                                                        if($siswagrup==0){
                                                        ?>
                                                          <option value="<?=$siswa->user_id;?>"><?=$siswa->user_name;?></option>
                                                         <?php }}?>
                                                        </select>														
                                                    </div>
                                                    <div class="col-md-2" style="height:350px;" align="center">
                                                        <div style="position:relative; left:50%; top:50%; transform:translate(-50%,-50%);">
                                                            <div class="col-md-12 ">
                                                                <button type="button" onClick="inputsiswa()" class="btn btn-success fa fa-arrow-right"></button>
                                                            </div>
                                                            <br/>
                                                            <br/>
                                                            <br/>
                                                            <br/>
                                                            <div class="col-md-12 ">
                                                                <button type="button" onClick="deletesiswa()" class="btn btn-warning fa fa-arrow-left"></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-5">                                                   
                                                       <select id="grup_siswa_id" name="grup_siswa_id" multiple class="form-control" style="height:350px;">
                                                        <?php $sisa=$this->db
                                                        ->join("user","user.user_id=grup_siswa.user_id","left")
                                                        ->where("grup_siswa.sekolah_id",$this->session->userdata("sekolah_id"))
                                                        ->where("grup_siswa.grup_id",$this->input->get("grup_id"))
                                                        ->where("grup_siswa.kelas_id",$kelas_id)
                                                        ->get("grup_siswa");
														//$a = $this->db->last_query();
                                                        foreach($sisa->result() as $siswagrup){												
                                                        ?>
                                                          <option value="<?=$siswagrup->grup_siswa_id;?>"><?=$siswagrup->user_name;?></option>
                                                         <?php }?>
                                                        </select>                                                        
                                                    </div>  
                                                </div>                                         
                                            </div>
                                        </div>                             
                                    
                                                                 
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
