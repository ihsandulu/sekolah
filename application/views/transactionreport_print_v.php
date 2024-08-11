<!DOCTYPE html>
<html>
	<head>
		<?php if(isset($_POST['from'])&&$_POST['from']!=""){$dari="From ".date("d-m-Y",strtotime($_POST['from']));}else{$dari="";}?>
		<?php if(isset($_POST['to'])&&$_POST['to']!=""){$ke="To ".date("d-m-Y",strtotime($_POST['to']));}else{$ke="";}?>
		<title>Print Transaction Report : <?=$dari;?> <?=$ke;?></title>
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
				<div style="font-size:18px; font-weight:bold;"><?=$this->input->post("type");?> Transaction Report : <?=$dari;?> <?=$ke;?></div>
               <table id="dataTable" class="table table-condensed table-hover" border="1">
				<thead>
					<tr>
					  <th>Date</th>
					  <th>School</th>
						<th>User</th>
						<th>NISN/NIK</th>
						<th>Transaction Name</th>
						<th>Amount</th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody> 
					<?php  
					if(isset($_POST['from'])&&$_POST['from']!=""){
						$this->db->where("SUBSTR(transaction_datetime,1,10) >=",$this->input->post("from"));
					} 
					if(isset($_POST['to'])&&$_POST['to']!=""){
						$this->db->where("SUBSTR(transaction_datetime,1,10) <=",$this->input->post("to"));
					}
					if(isset($_POST['type'])&&$_POST['type']!=""){
						$this->db->where("transaction_type",$this->input->post("type"));
					}
					if(isset($_POST['kelas'])&&$_POST['kelas']!=""&&isset($_POST['type'])&&$_POST['type']!="Debet"){
						$this->db->where("transaction.kelas_id",$this->input->post("kelas"));
					}
					if($this->session->userdata("sekolah_id")>0){
						$this->db->where("transaction.sekolah_id",$this->session->userdata("sekolah_id"));
					}
					$usr=$this->db
					->join("sekolah","sekolah.sekolah_id=transaction.sekolah_id","left")
					->join("user","user.user_nik=transaction.`user_nik` AND user.user_nisn=transaction.user_nisn","left")                                                ->order_by("transaction_datetime","desc")
					->get("transaction");
					//echo $this->db->last_query();
					$total=0;
					foreach($usr->result() as $transaction){
					if($transaction->user_nisn==""){$back="background-color:#FEDCC5";}else{$back="";}?>
					<tr style="<?=$back;?>">
					  <td><?=$transaction->transaction_datetime;?></td>											
						<td><?=$transaction->sekolah_name;?></td>
						<td><?=$transaction->user_name;?></td>
						<td><?=$transaction->user_nisn;?></td>
					  <td><?=$transaction->transaction_name;?></td>	
					  <td align="right"><?=number_format($transaction->transaction_amount,0,",",".");$total+=$transaction->transaction_amount;?></td>
					  <td><?=$transaction->transaction_type;?></td>	
					</tr>
					<?php }?>
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