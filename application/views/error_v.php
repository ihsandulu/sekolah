<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
	<style>
	#error{
		position:fixed; 
		left:50%; top:50%; 
		transform:translate(-50%,-50%); 
		font-size:24px; 
		font-weight:bold;
		text-align:center;
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
                    <li class="active">Error</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Error
                        
                    </h1>
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div id="error" class="col-xs-12 col-md-12 col-lg-12">
							<div class="col-xs-6 col-md-6 col-lg-6" style="text-align:right">
								<img src="<?=base_url("assets/images/global/Error.gif");?>" width="200" height="200"/>
							</div>
							<div class="col-xs-6 col-md-6 col-lg-6" style="text-align:left">
								<div>Page Not Found</div>
								<div><a href="<?=base_url();?>" class="btn btn-warning btn-lg">Back to <i class="fa fa-home"></i></a></div>
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
