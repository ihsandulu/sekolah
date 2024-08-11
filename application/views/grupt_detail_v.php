<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
    <style>
	.grup{
		border-radius:5px;
		border:#FFCCCC solid 3px !important;
		background-color:#EDE2EF !important;
		color:#000 !important;
		padding:10px;
		text-align:center;
		height:100px;
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
                    <li class="active">Grup</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Grup : <?=$grup_name;?>                      
                    </h1>					
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body" >
                            	<?php
								 
								if($this->session->userdata("sekolah_id")>0){
									$this->db->where("sekolah_id",$this->session->userdata("sekolah_id"));
								}
								
								if($this->session->userdata("kelas_id")>0){
									$this->db->where("kelas_id",$this->session->userdata("kelas_id"));
								}
								
								$gru=$this->db->get("grup");
								foreach($gru->result() as $grup){?>
                                
                                <a href="<?=site_url("grupt_detail?grup_id=".$grup->grup_id);?>" class="grup col-md-4  col-sm-6 col-xs-12">
									<div class="grupisi"><?=$grup->grup_name;?></div>
                                </a>
                                
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
