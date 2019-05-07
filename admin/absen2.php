
<?php
	require("../config/config.default.php");
	require("../config/config.function.php");
	require("../config/functions.crud.php");
	(isset($_SESSION['id_pengawas'])) ? $id_pengawas = $_SESSION['id_pengawas'] : $id_pengawas = 0;
	($id_pengawas==0) ? header('location:index.php'):null;
	echo "<link rel='stylesheet' href='../dist/bootstrap/css/bootstrap.min.css'/>";
	$BatasAwal = 50;
	$sesi = @$_GET['id_sesi'];
	$mapel =@$_GET['id_mapel'];
	$ruang =@$_GET['id_ruang'];
	$kelas =@$_GET['id_kelas'];
	$querytanggal=mysql_query("SELECT * FROM ujian WHERE id_mapel='$mapel'");
	$cektanggal=mysql_fetch_array($querytanggal);
	$mapelx=mysql_fetch_array(mysql_query("select * from mapel where id_mapel='$mapel'"));					
	$namamapel=	mysql_fetch_array(mysql_query("select * from mata_pelajaran where kode_mapel='$mapelx[nama]'"));					
	if(date('m')>=7 AND date('m')<=12) {
		$ajaran = date('Y')."/".(date('Y')+1);
	}
	elseif(date('m')>=1 AND date('m')<=6) {
		$ajaran = (date('Y')-1)."/".date('Y');
	}
	$query=mysql_query("SELECT * FROM siswa ");
	
	$querysetting=mysql_query("SELECT * FROM setting WHERE id_setting='1'");
	$setting=mysql_fetch_array($querysetting);
	$jumlahData = mysql_num_rows($query);
	$jumlahn = $jumlahData;
	$n = ceil($jumlahData/$jumlahn);
	$nomer = 1;
	$date=date_create($cektanggal['tgl_ujian']);

	echo'
	<table border="0" width="100%">
	<tr>
	<td  width="70" align="left"><img src="../'.$setting['logo'].'"  height=80></td>
    <td>
	<b><center><font size="+1">DAFTAR PESERTA '.$ruang.' </font> 
    <br><font size="+1">PENILAIAN AKHIR TAHUN BERBASIS ANDROID </font>
    <br><font size="+1"><b>TAHUN PELAJARAN : '. $ajaran.'</b></font>
	</b>
	</center>
	</td> 
	<td  width="70" align="left">&nbsp;</td>
    </table>
	<hr>
	
	
	
	
	';
	for($i=1;$i<=$n;$i++){
	echo '
	  <table class="table table-bordered" width="100%">
	<tr height="40">
	<th width="5%" style="text-align: center;">No.</th>
	<th width="13%" style="text-align: center;">No. Ujian</th>
	<th width="50%" style="text-align: center;">Nama Siswa</th>
	<th width="20%" style="text-align: center;">Kelas</th>
	</tr>';
	$mulai = $i-1;
	$batas = ($mulai*$jumlahn);
	$startawal = $batas;
	$batasakhir = $batas+$jumlahn;
	if(!$sesi=='' and !$ruang=='' and !$kelas==''){
	$ckck=mysql_query("SELECT * FROM siswa WHERE sesi='$sesi' and ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");
	}elseif($sesi=='' and !$ruang=='' and !$kelas==''){
	$ckck=mysql_query("SELECT * FROM siswa WHERE  ruang='$ruang' and id_kelas='$kelas' limit $batas,$jumlahn");	
	}elseif($sesi=='' and $ruang=='' and !$kelas==''){
	$ckck=mysql_query("SELECT * FROM siswa WHERE  id_kelas='$kelas' limit $batas,$jumlahn");	
	}elseif(!$sesi=='' and $ruang=='' and $kelas==''){
	$ckck=mysql_query("SELECT * FROM siswa WHERE  sesi='$sesi' limit $batas,$jumlahn");	
	}elseif(!$sesi=='' and !$ruang=='' and $kelas==''){
	$ckck=mysql_query("SELECT * FROM siswa WHERE  sesi='$sesi' and ruang='$ruang' limit $batas,$jumlahn");	
	}elseif($sesi=='' and !$ruang=='' and $kelas==''){
	$ckck=mysql_query("SELECT * FROM siswa WHERE   ruang='$ruang' limit $batas,$jumlahn");	
	}else{
	$ckck=mysql_query("SELECT * FROM siswa  limit $batas,$jumlahn");	
	}
	$s = $i-1;
	while($f= mysql_fetch_array($ckck)){
	if ($nomer % 2 == 0) {
	  echo "
	  <tr height=30px>
	  <td align='center'>&nbsp;$nomer.</td>
	  <td align='center'>$f[nis]</td>
	  <td>&nbsp;$f[nama]</td>
	  <td align='center'>&nbsp;$f[id_kelas]</td>
	  </tr>";
	  } else {
	  echo "<tr height=30px>
	  <td align='center'>&nbsp;$nomer.</td>
	  <td align='center'>$f[nis]</td></center>
	  <td>&nbsp;$f[nama]</td>
	  <td align='center'>&nbsp;$f[id_kelas]</td>
	  </tr>";
	  }
	  $nomer++;
	  
	}	
	echo '
	</table>
	';
	}
	echo '
	
	
	
	
	 
	
	';
?>
