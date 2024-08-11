<!doctype html>
<html>

<head>
    <?php 
	require_once("meta.php");?>
	
   <script>
	function loading(){
		$("#loading").show();
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
                    <li class="active">Sync</li>
                </ul><!-- /.breadcrumb -->

                
            </div>
            <div class="page-content">

                <div class="page-header">
                    <h1>
                        Sync
                        
                    </h1>
					
                </div>
                
                <div class="row">
                    <div class="col-xs-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                           
						   
						   <div id="log"><h3>Sync Log :</h3><br/></div>
	
	<?php
	
	$identity_client=$this->db->get("identity")->row()->identity_client;
	//$table = array("0"=>"absensi","grup","grup_guru","grup_siswa","jawaban","kelas_guru","kelas_sekolah","login","matpel_sekolah","test","test_detail","user");
	$table = array("0"=>"soal","soal_umum","materi","sekolah","absensi","grup","grup_guru","grup_siswa","jawaban","kelas_guru","kelas_sekolah","login","matpel_sekolah","test","test_detail","user");
	$sekolah_id=$this->db->get("sekolah")->row()->sekolah_id;
	$z=0;
	for($y=0;$y<count($table);$y++){
		?>
		<script>
			
				$.get("<?=$identity_server;?>/api/hapus_table",{table:'<?=$table[$y];?>',sekolah_id:'<?=$sekolah_id;?>'})
				.done(function(data){
					$("#log").append(data);
					<?php
						if($y!=count($table)){$z++;}
					?>
				});
		</script>
	<?php 	
	}
	
	if($z==count($table)){
	
		for($x=0;$x<count($table);$x++){
		
			unset($tablename);		
			$where["sekolah_id"]=$sekolah_id;
			$isi=$this->db
			->get_where($table[$x],$where);	
			//echo $this->db->last_query();
			if($isi->num_rows()>0)
			{
				foreach($isi->result() as $isinya){	
					$input="";
					foreach($this->db->list_fields($table[$x]) as $field)
					{						
						$input.=",".$field.":'".$isinya->$field."'";
					}	
					?>					
					<script>
			
					$.get("<?=$identity_server;?>/api/insert_table",{table:'<?=$table[$x];?>'<?=$input;?>})
					.done(function(data){
						$("#log").append(data);
					});
					
					</script>
					<?php	//echo $identity_server." / ".$table[$x]." / ".$sekolah_id." / ".$input;			
				}
			}
			
		}
	}
	?>
                    
					<!--<input id="getdata" type="button"  value="Send X GET"/>
					<input id="postdata" type="button" value="Send X POST" />
					 
					<script>
					$(document).ready(function()
					{
						var contentType ="application/x-www-form-urlencoded; charset=utf-8";
					 
						if(window.XDomainRequest)
							contentType = "text/plain";
					 
						$("#postdata").click(function()
						{
							$.ajax({
							 url:"http://qithy.com/schools/api/terima_semua_data",
							 data:'data=<?=$data;?>',
							 type:"POST",
							 dataType:"json",   
							 contentType:contentType,    
							 success:function(data)
							 {
								alert(JSON.stringify(data));
							 },
							 error:function(jqXHR,textStatus,errorThrown)
							 {
								alert("You can not send Cross Domain AJAX requests: "+errorThrown);
							 }
							});
					 
						});
					 
						$("#getdata").click(function()
						{
							$.ajax(
							{
							 url:"http://qithy.com/schools/api/terima_semua_data?name=Ravi&age=32",
							 dataType:"json",
							 contentType:contentType,
							 success:function(data)
							 {
								alert(JSON.stringify(data));
							 },
							 error:function(jqXHR,textStatus,errorThrown)
							 {
								alert("You can not send Cross Domain AJAX requests : "+errorThrown);
							 }
							});
					 
						});
					 
					});
					</script>
						   -->
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
