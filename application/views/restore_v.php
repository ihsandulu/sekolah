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
                    <li class="active">Restore Database</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
                    <div class="col-md-12 col-sm-12 col-xs-12" style="font-size:18px; font-weight:bold;">
                        Restore Database                      
                    </div>	                    					
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
							<div class="panel-body">
							<?=$messages;?>
                            <form class="form" enctype="multipart/form-data" method="post">
								<div class="form-group">
									<label>Choose File :</label>
									<input type="file" name="file" />
								</div>
								<button class="btn btn-primary">Submit</button>
							</form>
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
