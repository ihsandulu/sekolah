<?php
//Soal 1
		echo "<h3>Soal 1</h3><br/>";
		$input=$_GET["input"];
		for($x=0;$x<=$input;$x++){
			for($y=0;$y<$x;$y++){
				echo "*";
			}
			echo "<br/>";
		}
		
		echo "<br/><br/><hr/><br/><br/>";
		
		
		//Soal 2
		echo "<h3>Soal 2</h3><br/>";
		$string=$_GET["string"];
		$cari=$_GET["cari"];
		$no=0;
		foreach(str_split($string) as $char){if($cari==$char){$no++;}}
		echo 'Ditemukan karakter '.$cari.' sebanyak : '.$no;
		echo "<br/><br/><br/>";
		//bisa juga dengan cara
		$len=strlen($string);
		$nom=0;
		for($x=0;$x<$len;$x++){
			if($string[$x]==$cari){$nom++;}
		}
		echo 'Ditemukan karakter '.$cari.' sebanyak : '.$nom;
		
		echo "<br/><br/><hr/><br/><br/>";
		
		
		//Soal 3
		echo "<h3>Soal 3</h3><br/>";
		$bilangan=$_GET['bilangan'];
		echo "Bilagan ".$bilangan." akan habis dibagi oleh bilangan : ";
		for($x=1;$x<=$bilangan;$x++){
			if($bilangan % $x == 0){echo $x." ";}
		}
		
		//Dapat di test dengan url berikut: 
		//http://localhost/test.php?input=3&string=Coba cari lagi ada berapa?&cari=a&bilangan=51
		
?>