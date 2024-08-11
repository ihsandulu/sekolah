<!DOCTYPE html>
<html>
	<head>
		<title>Print PO</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>	</head>
	<body>
	<div class="container">
	<div class="row">
		<div style="margin-bottom:30px; border-bottom:black solid 3px; padding-bottom:30px;">
	<img src="<?=base_url("assets/images/icon/ptpsi.png");?>" style="width:90px; height:90px; float:left; margin-right:50px;"/><div style="float:left;"><h3><?=$identity_company;?></h3><span><?=$identity_slogan;?></span></div><div style="float:right; line-height: 70%;"><?=$identity_services;?></div>
	<div style="clear:both;"></div>
	</div>
	
		<div class="col-md-12"><h1 style="text-decoration:underline;">Purchase Order</h1></div>
		<div class="col-md-6 col-sm-6 col-xs-6" style=" padding:15px; border-radius:5px; height:120px;">
			
			
			<div class="col-md-2 col-sm-2 col-xs-2">Supplier</div>
			<div class="col-md-1 col-sm-1 col-xs-1">:</div>
			<div class="col-md-9 col-sm-9 col-xs-9"><?=$supplier_name;?>&nbsp;</div>
			<div class="col-md-2 col-sm-2 col-xs-2">Attention</div>
			<div class="col-md-1 col-sm-1 col-xs-1">:</div>
			<div class="col-md-9 col-sm-9 col-xs-9"><?=$attention;?>&nbsp;</div>
			<div class="col-md-2 col-sm-2 col-xs-2">Address</div>
			<div class="col-md-1 col-sm-1 col-xs-1">:</div>
			<div class="col-md-9 col-sm-9 col-xs-9"><?=$supplier_address;?>&nbsp;</div>
			<div class="col-md-2 col-sm-2 col-xs-2">Fax</div>
			<div class="col-md-1 col-sm-1 col-xs-1">:</div>
			<div class="col-md-9 col-sm-9 col-xs-9"><?=$supplier_fax;?>&nbsp;</div>
			<div class="col-md-2 col-sm-2 col-xs-2">Email</div>
			<div class="col-md-1 col-sm-1 col-xs-1">:</div>
			<div class="col-md-9 col-sm-9 col-xs-9"><?=$supplier_email;?>&nbsp;</div>
		</div>
		<div class="col-md-1 col-sm-1 col-xs-1"></div>
		<div class="col-md-5 col-sm-5 col-xs-5" style="border:grey solid 1px; padding:15px; border-radius:5px; height:120px;">
			<div class="col-md-3 col-sm-3 col-xs-4">PO No.</div>
			<div class="col-md-1 col-sm-1 col-xs-1">:</div>
			<div class="col-md-8 col-sm-8 col-xs-7"><?=$po_no;?>&nbsp;</div>
			<div class="col-md-3 col-sm-3 col-xs-4">Date</div>
			<div class="col-md-1 col-sm-1 col-xs-1">:</div>
			<div class="col-md-8 col-sm-8 col-xs-7"><?=date("d F Y",strtotime($po_date));?>&nbsp;</div>
		</div>
		<div style="">&nbsp;<br/><br/><br/><br/></div>
		<?php $loo=$this->db
		->where("po_no",$this->input->get("po_no"))
		->where("po_title NOT LIKE","%attention%")
		->where("po_title NOT LIKE","%supplier_id%")
		->get("po");
		foreach($loo->result() as $po){?>
		
		<?php if(stripos($po->po_title,"product")!==false){?>
			<div class="col-md-12" style="padding:0px; ">		
			  <table class="col-md-12 col-sm-12 col-xs-12" border="1">
				<tr>
				  <th style="text-align:center;">No</th>
				  <th style="text-align:center;">Description</th>
				  <th style="text-align:center;">Qty</th>
				  <th style="text-align:center;">Unit Price </th>
				  <th style="text-align:center;">Total (IDR) </th>
				</tr>
				<?php 
				$no=1;$to=0;
				$prod=$this->db
				->join("product","product.product_id=poproduct.product_id","left")
				->where("po_no",$this->input->get("po_no"))
				->get("poproduct");
				foreach($prod->result() as $product){?>
				<tr>
				  <td style="text-align:center;"><?=$no++;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->product_name;?>&nbsp;</td>
				  <td style="text-align:center;"><?=$product->poproduct_qty;?>&nbsp;</td>
				  <td style="text-align:center;"><?=number_format($product->poproduct_price,0,",",".");?>&nbsp;</td>
				  <td style="text-align:center;"><?=number_format($to=+$product->poproduct_qty*$product->poproduct_price,0,",",".");?>&nbsp;</td>
				</tr>
				<?php }?>
				 <tr>
				  <td colspan="4">&nbsp;</td>
				  <td class="col-md-3 col-sm-3 col-xs-3">
				  <div class="col-md-6 col-sm-6 col-xs-6">Total</div><div class="col-md-6 col-sm-6 col-xs-6">: <?=number_format($to,0,",",".");?></div>
				  <?php
				  $pro=$this->db
					->join("supplier","supplier.supplier_id=po.po_content","left")
					->where("po_customize","3")
					->where("po_content","1")
					->where("po_no",$po->po_no)
					->get("po");
					if($pro->num_rows()>0){?>
				  <div class="col-md-6 col-sm-6 col-xs-6">PPN</div><div class="col-md-6 col-sm-6 col-xs-6">: <?=number_format($potong=$to*10/100,0,",",".");?></div>
				  <?php }else{?>
				  <div class="col-md-6 col-sm-6 col-xs-6">PPN</div><div class="col-md-6 col-sm-6 col-xs-6">: <?=number_format($potong=0*10/100,0,",",".");?></div>
				  <?php }?>
				  <div class="col-md-6 col-sm-6 col-xs-6">Grand Total</div><div class="col-md-6 col-sm-6 col-xs-6">: <?=number_format($to+$potong,0,",",".");?></div>			  </td>
				</tr>				
			  </table>
			</div>
			<div class="col-md-12">&nbsp;</div>
		<?php }elseif(stripos($po->po_title,"approve")!==false){?>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center">Approved by :</div>
				<div align="center"><h4><strong><?=$identity_company;?></strong></h4></div>
				<div  style="height:100px;">&nbsp;</div>
				<div align="center"><?=$po_content;?>&nbsp;</div>
			</div>
		<?php }elseif(stripos($po->po_title,"confirm")!==false){?>
			<div class="col-md-2 col-sm-2 col-xs-2">&nbsp;</div>
			<div class="col-md-5 col-sm-5 col-xs-5" style="font-size:12px; padding:20px;">
				<div align="center">Confirmed by :</div>
				<div align="center"><h4><strong><?=$supplier_name;?></strong></h4></div>
				<div  style="height:100px;">&nbsp;</div>
				<div align="center"><?=$po_content;?>&nbsp;</div>
			</div>
		<?php }else{?>
			<div class="col-md-12" style="padding:0px; ">	
			<h5><strong><?=ucwords(str_replace("_"," ",$po->po_title));?></strong></h5>
			<?=$po->po_content;?>
			</div>
			<div class="col-md-12">&nbsp;</div>
		<?php }?>
		
		<?php }?>
		
				
		
	</div>
	</div>
	</body>
</html>
<script>
window.print();
setTimeout(function(){ this.close(); }, 500);
</script>