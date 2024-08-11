<!DOCTYPE html>
<html>
	<head>
		<title>Print Account</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
        <style type="text/css" media="print">
		@page {
			size: auto;   /* auto is the initial value */
			margin: 0;  /* this affects the margin in the printer settings */
		}
		div,body{margin:0px;padding:0px;}
		th,td{text-align:center; font-size:12px;}
		</style>
	</head>
	<body style="padding-left:5px;">
                <?php 
				$line=$this->input->get("line");
				$where["tabungan_id"]=$this->input->get("tabungan_id");
				$print=$this->db->get_where("tabungan",$where);
				//echo $this->db->last_query();
				foreach($print->result() as $print){?>
				<table><?php for($x=1;$x<=$line;$x++){?>
				<?php if($x==1){?>				
				<?php if($x!=$line){?>
				<tr style="height:20px;">
					<th style="width:25px; text-align:center;">&nbsp;</th> 
					<th style="width:60px;">&nbsp;</th>
					<th style="width:150px;">&nbsp;</th>
					<th style="width:75px;">&nbsp;</th>   
					<th style="width:40px;">&nbsp;</th>
					<th style="width:75px;">&nbsp;</th>  
				</tr>
				<?php }else{?>				
				<tr style="height:20px;">
					<th style="width:25px; text-align:center;">No.</th> 
					<th style="width:60px;">Date</th>
					<th style="width:150px;">Remarks</th>
					<th style="width:75px;">Amount</th>   
					<th style="width:40px;">Type</th>
					<th style="width:75px;">Saldo</th>  
				</tr>
				<?php }?>
				<?php }?>
				<tr style="height:20px;">
				<?php if($x==$line){?> 
				<td style="width:25px; text-align:center;"><?=$line;?></td> 
				<td style="width:60px; text-align:left;"><?=date("d-m-Y",strtotime($print->tabungan_datetime));?></td>
				<td style="width:150px; text-align:left;"><?=$print->tabungan_remarks;?></td>
				<td style="width:75px; text-align:right;"><?=number_format($print->tabungan_amount,0,",",".");?></td>   
				<td style="width:40px; text-align:center;"><?=$print->tabungan_type;?></td> 
				<td style="width:75px; text-align:right;">
				<?php
				//user
				$whereuser["user_nisn"]=$print->user_nisn;
				$user=$this->db->get_where("user",$whereuser)->row();
				//echo $this->db->last_query();
				
				//kredit
				$kredit=$this->db
				->select("SUM(tabungan_amount)AS kredit")
				->where("tabungan_type","kredit")	
				->where("user_nisn",$user->user_nisn)
				->where("sekolah_id",$user->sekolah_id)
				->group_by("user_nisn")
				->get("tabungan");
				//echo $this->db->last_query();
				if($kredit->num_rows()>0){$kredit=$kredit->row()->kredit;}else{$kredit=0;}
				//echo $kredit;
				//debet
				$debet=$this->db
				->select("SUM(tabungan_amount)AS debet")
				->where("tabungan_type","debet")	
				->where("user_nisn",$user->user_nisn)
				->where("sekolah_id",$user->sekolah_id)
				->group_by("user_nisn")
				->get("tabungan");
				//echo $this->db->last_query();
				if($debet->num_rows()>0){$debet=$debet->row()->debet;}else{$debet=0;}
				//echo $debet;
				$saldo=$debet-$kredit;
				
				echo number_format($saldo,0,",",".");
				?></td>
				<?php }else{?>				
				<td style="width:25px; text-align:center;">&nbsp;</td> 
				<td style="width:60px;">&nbsp;</td>
				<td style="width:150px;">&nbsp;</td>
				<td style="width:75px;">&nbsp;</td>   
				<td style="width:40px;">&nbsp;</td>
				<td style="width:75px;">&nbsp;</td>  
				<?php }?>
				</tr>
				<?php }?>
				</table>   
				<?php }?>	
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>