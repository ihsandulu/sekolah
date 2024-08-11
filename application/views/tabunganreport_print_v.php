<!DOCTYPE html>
<html>
	<head>
		<?php if(isset($_POST['from'])&&$_POST['from']!=""){$dari="From ".date("d-m-Y",strtotime($_POST['from']));}else{$dari="";}?>
		<?php if(isset($_POST['to'])&&$_POST['to']!=""){$ke="To ".date("d-m-Y",strtotime($_POST['to']));}else{$ke="";}?>
		<title>Print Account Report : <?=$dari;?> <?=$ke;?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	
        <style>
		th,td{text-align:center;}
		</style>
	</head>
	<body>
        <div class="container">
            <div class="row">
				<div style="font-size:18px; font-weight:bold;"><?=$this->input->post("type");?> Account Report : <?=$dari;?> <?=$ke;?></div>
               <table id="dataTable" class="table table-condensed table-hover" border="1">
				<thead>
					<tr>
					  <th>Date</th>
					  <th>School</th>
						<th>User</th>
						<th>NISN/NIK</th>
						<th>Remarks</th>
						<th>Amount</th>
						<th>Type</th>						
					</tr>
				</thead>
				<tbody> 
					<?php  
					if(isset($_POST['from'])&&$_POST['from']!=""){
						$this->db->where("SUBSTR(tabungan_datetime,1,10) >=",$this->input->post("from"));
					} 
					if(isset($_POST['to'])&&$_POST['to']!=""){
						$this->db->where("SUBSTR(tabungan_datetime,1,10) <=",$this->input->post("to"));
					}
					if(isset($_POST['type'])&&$_POST['type']!=""){
						$this->db->where("tabungan_type",$this->input->post("type"));
					}
					if($this->session->userdata("sekolah_id")>0){
						$this->db->where("tabungan.sekolah_id",$this->session->userdata("sekolah_id"));
					}
					$usr=$this->db
					->join("sekolah","sekolah.sekolah_id=tabungan.sekolah_id","left")
					->join("user","user.user_nisn=tabungan.user_nisn","left")                                                
					->order_by("tabungan_datetime","desc")
					->get("tabungan");
					//echo $this->db->last_query();
					$debet=0;
					$kredit=0;
					foreach($usr->result() as $tabungan){
					if($tabungan->tabungan_type=="Debet"){$debet+=$tabungan->tabungan_amount;}
					if($tabungan->tabungan_type=="Kredit"){$kredit+=$tabungan->tabungan_amount;}
					if($tabungan->user_nisn==""){$back="background-color:#FEDCC5";}else{$back="";}?>
					<tr style="<?=$back;?>">
					  <td><?=$tabungan->tabungan_datetime;?></td>											
						<td><?=$tabungan->sekolah_name;?></td>
						<td><?=$tabungan->user_name;?></td>
						<td><?=$tabungan->user_nisn;?></td>
					  <td><?=$tabungan->tabungan_remarks;?></td>	
					  <td align="right"><?=number_format($tabungan->tabungan_amount,0,",",".");?></td>
					  <td><?=$tabungan->tabungan_type;?></td>
					</tr>
					<?php }
					$total=$debet-$kredit;
					?>
					<tr style="font-weight:bold; font-size:18px;">
					  <td colspan="5">TOTAL</td>
					  <td colspan="2" align="right">Rp <?=number_format($total,0,",",".");?></td>
				  </tr>
				</tbody>
			</table>
        	</div>
        </div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>