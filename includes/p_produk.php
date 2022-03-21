<?php

$link_list='?hal=data_produk';
$link_update='?hal=update_produk';

$q="select * from produk order by nama_produk";
$q=mysqli_query($connect, $q);
if(mysqli_num_rows($q) > 0){
	while($h=mysqli_fetch_array($q)){
		$no++;
		$id=$h['id_produk'];
		$allow_del=true;
		if(mysqli_num_rows(mysqli_query($connect,"select * from nilai_produk where id_produk_1='".$h['id_produk']."' limit 0,1"))>0){$allow_del=false;}
		if(mysqli_num_rows(mysqli_query($connect,"select * from nilai_produk where id_produk_2='".$h['id_produk']."' limit 0,1"))>0){$allow_del=false;}
		if($allow_del){$disabled='';}else{$disabled='disabled';}
		$daftar.='
		  <tr>
			<td valign="top">'.$no.'</td>
			<td valign="top">'.$h['kode_produk'].'</td>
			<td valign="top">'.$h['nama_produk'].'</td>
			<td align="center" valign="top"><a href="'.$link_update.'&amp;id='.$id.'&amp;action=edit&&kode='.$h['kode_produk'].'&&nama='.$h['nama_produk'].'" class="btn"><i class="icon-edit"></i></a> <a href="#" onclick="DeleteConfirm(\''.$link_update.'&amp;id='.$id.'&amp;action=delete\');return(false);" class="btn '.$disabled.'"><i class="icon-trash"></i></a></td>
		  </tr>
		';
	}
}


?>
<script language="javascript">
function DeleteConfirm(url){
	if (confirm("Anda yakin akan menghapus data ini ?")){
		window.location.href=url;
	}
}
</script>

<h3 class="p2">Siswa </h3>
<a href="<?php echo $link_update;?>" class="btn blue" style="float:right"><i class="icon-plus"></i> Tambah nama siswa </a><br /><br />
<table class="table table-striped table-hover table-bordered">
	<thead>
		<tr>
			<th width="40">No</th>
			<th width="160">Kode</th>
			<th>Nama Siswa </th>
			<th width="90" align="right">&nbsp;</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $daftar;?>
	</tbody>
</table>
