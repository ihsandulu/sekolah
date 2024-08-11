<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type='text/javascript' src="http://cdnjs.cloudflare.com/ajax/libs/jquery-ajaxtransport-xdomainrequest/1.0.1/jquery.xdomainrequest.min.js"></script>

 
</head>
<body>
	<div id="log">test</div>
	
	<?php
	
	$identity_server=$this->db->get("identity")->row()->identity_server;
	$table = array("0"=>"absensi","grup","grup_guru","grup_siswa","jawaban","kelas_guru","kelas_sekolah","login","matpel_sekolah","sekolah","test","test_detail","user");
	$sekolah_id=$this->db->get("sekolah")->row()->sekolah_id;
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
			
				$.get("<?=$identity_server;?>/api/hapus_table",{table:'<?=$table[$x];?>',sekolah:'<?=$sekolah_id;?>'})
				.done(function(data){
					$("#log").append(data);
				});
		
				$.get("<?=$identity_server;?>/api/insert_table",{table:'<?=$table[$x];?>'<?=$input;?>})
				.done(function(data){
					$("#log").append(data);
				});
				
				</script>
				<?php	//echo $identity_server." / ".$table[$x]." / ".$sekolah_id." / ".$input;			
			}die();	
		}
		
	}
	?>
                    
					<!--<input id="getdata" type="button"  value="Send X GET"/>-->
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
					
				
</body>
</html>