<?php
$link_update='?hal=nilai_kriteria_produk';

$q="select * from kriteria_produk order by kode_kriteria_produk";
$q=mysqli_query($connect,$q);
while($h=mysqli_fetch_array($q)){
	$kriteria_produk[]=array($h['id_kriteria_produk'],$h['kode_kriteria_produk'],$h['nama_kriteria_produk']);
}

if(isset($_POST['save'])){
	mysqli_query($connect,"truncate table nilai_kriteria_produk"); /* kosongkan tabel nilai_kriteria_produk */
	for($i=0;$i<count($kriteria_produk);$i++){
		for($ii=0;$ii<count($kriteria_produk);$ii++){
			if($i < $ii){
				mysqli_query($connect,"insert into nilai_kriteria_produk(id_kriteria_produk_1,id_kriteria_produk_2,nilai) values('".$kriteria_produk[$i][0]."','".$kriteria_produk[$ii][0]."','".$_POST['nilai_'.$kriteria_produk[$i][0].'_'.$kriteria_produk[$ii][0]]."')");
			}
		}
	}
	$success='Nilai perbandingan kriteria produk berhasil disimpan.';
}
if(isset($_POST['check'])){
	require_once ( 'ahp2.php' );
	//print_r($_POST);
	for($i=0;$i<count($kriteria_produk);$i++){
		$id_kriteria_produk[]=$kriteria_produk[$i][0];
	}
	
	$matrik_kriteria_produk = ahp2_get_matrik_kriteria_produk($id_kriteria_produk,$connect);
	$jumlah_kolom = ahp2_get_jumlah_kolom($matrik_kriteria_produk);
	$matrik_normalisasi = ahp2_get_normalisasi($matrik_kriteria_produk, $jumlah_kolom);
	$eigen = ahp2_get_eigen($matrik_normalisasi);
	
	if(ahp2_uji_konsistensi($matrik_kriteria_produk, $eigen)){
		$success='Nilai perbandingan : KONSISTEN';
	}else{
		$error='Nilai perbandingan : TIDAK KONSISTEN';
	}
	
	
	
}
if(isset($_POST['reset'])){
	mysqli_query($connect,"truncate table nilai_kriteria_produk"); /* kosongkan tabel nilai_kriteria */
}

for($i=0;$i<count($kriteria_produk);$i++){
	for($ii=0;$ii<count($kriteria_produk);$ii++){
		if($i < $ii){
			$q=mysqli_query($connect,"select nilai from nilai_kriteria_produk where id_kriteria_produk_1='".$kriteria_produk[$i][0]."' and id_kriteria_produk_2='".$kriteria_produk[$ii][0]."'");
			if(mysqli_num_rows($q)>0){
				$h=mysqli_fetch_array($q);
				$nilai=$h['nilai'];
			}else{
				mysqli_query($connect,"insert into nilai_kriteria_produk(id_kriteria_produk_1,id_kriteria_produk_2,nilai) values('".$kriteria_produk[$i][0]."','".$kriteria_produk[$ii][0]."','1')");
				$nilai=1;
			}
			$row=count($kriteria_produk)-1;
			$selected[$nilai]=' selected';
			$val_sementara="";
			if(isset($_POST['check'])){
				$val_sementara=$_POST['nilai_'.$kriteria_produk[$i][0].'_'.$kriteria_produk[$ii][0]];
				//echo 'nilai_'.$kriteria_produk[$i][0].'_'.$kriteria_produk[$ii][0];
			}else{
				$val_sementara=$nilai;
			}
			$daftar.='
			  <tr>
				<td align="right">'.$kriteria_produk[$i][1].' - '.$kriteria_produk[$i][2].'</td>
				<td align="center">
				<input type="text" min="0.111" max="9" step="0.001" name="nilai_'.$kriteria_produk[$i][0].'_'.$kriteria_produk[$ii][0].'" value='.$val_sementara.'>
				
				</td>
				<td>'.$kriteria_produk[$ii][1].' - '.$kriteria_produk[$ii][2].'</td>
				</td>
				

				
			</tr>
			';
			$selected[$nilai]='';
		}
	}
}


?>
<script language="javascript">
function ResetConfirm(){
	if (confirm("Anda yakin akan mengatur ulang semua nilai perbandingan kriteria ini ?")){
		return true;
	}else{
		return false;
	}
}
</script>

<h3 class="p2">Nilai Perbandingan Kriteria siswa</h3>

<form action="<?php echo $link_update;?>" name="" method="post" enctype="multipart/form-data">
<?php
if(!empty($error)){
	echo '
	   <div class="alert alert-error ">
		  '.$error.'
	   </div>
	';
}
if(!empty($success)){
	echo '
	   <div class="alert alert-success ">
		  '.$success.'
	   </div>
	';
}
?>

<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th>Nama Kriteria </th>
			<th>Nilai Perbandingan</th>
			<th>Nama Kriteria</th>
			
		</tr>
	</thead>
	<tbody>
		<?php echo $daftar;?> 
	  <tr>
		<td align="center" colspan="3"><button type="submit" name="save" class="btn blue"><i class="icon-ok"></i> Simpan</button>
		<button type="submit" name="check" class="btn">Cek Konsistensi</button>
		<button type="submit" name="reset" class="btn" onclick="return(ResetConfirm());">Reset Nilai</button></td>
	  </tr>
	</tbody>
</table>
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			
			<th>Pembobotan Normal</th>
			<th>Nilai Pembobotan Normal</th>
			<th></th>
			<th>Pembobotan Kebalikan</th>
			<th>Nilai Pembobotan Kebalikan</th>
			
			
		</tr>
	</thead>
	<tbody><tr>
	<td>Sama penting dengan</td><td>1</td><td></td><td>Mendekati sedikit kurang penting dari</td><td>0.5</td>
	</tr>
	<tr>
	
<td>Mendekati sedikit lebih penting dari</td><td>2</td><td></td><td>Sedikit kurang penting dari</td><td> 0.333</td>
</tr>
	<tr>
<td>Sedikit lebih penting dari</td><td>3</td><td></td><td> Mendekati kurang penting dari </td><td> 0.25</td>
</tr>
	<tr>
	<td>Mendekati lebih penting dari</td><td>4</td><td></td><td>Kurang penting dari </td><td> 0.2</td>
</tr>
	<tr>
	<td>Lebih penting dari</td><td>5</td><td></td><td>Mendekati sangat tidak penting dari </td><td> 0.167</td>
</tr>
	<tr>
	<td>Mendekati sangat penting dari</td><td>6</td><td></td><td>Sangat tidak penting dari </td><td> 0.143</td>
</tr>
	<tr>
	<td>Sangat penting dari</td><td>7</td><td></td><td> Mendekati mutlak tidak penting dari</td><td>0.125</td>
</tr>
	<tr>
	<td>Mendekati mutlak dari</td><td>8</td><td></td><td>Mutlak sangat tidak penting dari</td><td>0.111</td>
</tr>
	<tr>
	<td>Mutlak sangat penting dari<</td><td>9</td><td></td><td></td><td></td>
	</tr>

	</tbody>
	</table>

</form>
