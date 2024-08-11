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
<?php 
require_once("header.php");
?>
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
                    <?php if($_GET["type"]==1){$type="Masuk";}else{$type="Pulang";}?>
                        Absensi : <span style="color:<?=$_GET["color"];?> ;"><?=$type;?></span>                     
                    </div>	                    					
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12" style="padding:50px;">
                        <div class="col-md-6" style="padding:50px; border-right:#d7d7d7 solid 1px;">
                            <form class="form-inline" action="" onsubmit="return submitHandler()">
                                <div class="form-group">
                                    <label for="nisn">Scan NISN di sini:</label>
                                    <input autofocus width="50" type="nisn" class="form-control" id="nisn" onChange="qrcodesiswa(this.value);">
                                </div>
                                <button type="button" class="btn btn-default">Submit</button>
                            </form>
                        </div>
                        <div class="col-md-6" style="padding:50px;" align="center">
                            <div id="status" align="center" style="font-size:20px;"></div>
                            <img style="border:none; width:191px; height:191px; display:none;" id="tampilqrcode"/>
                            <div id="statuswa" align="center" style="font-size:30px;"></div>
                        </div>
                        <script>
							tablesiswa();
                            var submitHandler = function() {
                                // do stuff
                                return false;
                            }
							function tablesiswa(){
								$.get("<?=base_url("api/tableabsen");?>")
								.done(function(data){
									$("#tableabsen").html(data);
								});
							}
							</script>	
													
							
							<script>
							function cektelpon(name,typename,datetime,number,id){
								let pesanwa='Ananda '+name+' telah '+typename+' pada '+datetime;
								// alert('<?=base_url("api/cektelpon");?>?message='+pesanwa+'&number='+number+'&server=<?=$this->session->userdata('server_name');?>&id='+id);	

								$.get("<?=base_url("api/cektelpon");?>",{message:pesanwa,id:id})
								.done(function(data){
									$.each( data, function( key, value ) {
										// alert(value.message+','+value.number+','+value.server);
										kirimpesan(value.message,value.number,value.server,value.email,value.password);
									});
								});
							}
                            function qrcodesiswa(nisn){       
                                $("#tampilqrcode").attr("src","");
                                $.get("<?=base_url("api/absensiswa");?>",{nisn:nisn,type:'<?=$_GET["type"];?>'})
                                .done(function(data){
									// alert(data.name+','+data.typename+','+data.datetime+','+data.number+','+data.id);
                                    $("#status").html(data.message);
                                    if(data.success==1){                
                                        $("#tampilqrcode").show();                                      
                                        $("#tampilqrcode").attr("src",data.url);               
                                        $("#status").css("color","green");             
                                        $("#status").css("font-size","25px");
										// alert(data.name+','+data.typename+','+data.datetime+','+data.number+','+data.id);
										cektelpon(data.name,data.typename,data.datetime,data.number,data.id);
										setTimeout(() => {
											tablesiswa();
										}, 1000);  
                                    }else{            
                                        $("#status").css("color","red");               
                                        $("#tampilqrcode").hide(); 
                                    }
                                });
                                $("#nisn").val("");
                            }
                        </script>
                        <div id="listsiswa-belumabsen" class="panel-body" style="padding-bottom:40px;">
                        
                            
                            
                    
                            
                        </div>
                    </div>
                </div>
				
				<hr/>
				<h4><strong><i class="fa fa-users" style="color:#0000CC;"></i> Attendance <?=date("d M Y");?></strong></h4>
				<div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div id="tableabsen" class="panel-body" style="padding-bottom:40px;">
                          
								
                            	
                       	
								
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
