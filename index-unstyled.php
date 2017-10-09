<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tugas SPK 1</title>
  <style>
    table tr td, table tr td input{
      text-align: right;
    }
    .center {
      text-align: center;
    }
    #chartDiv {
      width: 700px;
    }
  </style>
  <script src="js/plotly-latest.min.js"></script>
</head>
<body>

<form action="" method="post">

<table border="1">
  <thead>
    <tr>
      <th colspan="3">Tempat Input Data</th>
      <th rowspan="2">Batas Jam Maks</th>
    </tr>
    <tr>
      <th>Jenis Pekerjaan</th>
      <th>Celana</th>
      <th>Baju</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Pemotongan</th>
      <td><input type="number" name="pemotongan_celana" placeholder="pemotongan_celana" value="2"></td>
      <td><input type="number" name="pemotongan_baju" placeholder="pemotongan_baju" value="1"></td>
      <td><input type="number" name="batas_jam_pemotongan" placeholder="batas_jam_pemotongan" value="30"></td>
    </tr>
    <tr>
      <th>Penjahitan</th>
      <td><input type="number" name="penjahitan_celana" placeholder="penjahitan_celana" value="1"></td>
      <td><input type="number" name="penjahitan_baju" placeholder="penjahitan_baju" value="2"></td>
      <td><input type="number" name="batas_jam_penjahitan" placeholder="batas_jam_penjahitan" value="24"></td>
    </tr>
    <tr>
      <th>Keuntungan / Unit</th>
      <td><input type="number" name="laba_celana" placeholder="laba_celana" value="8000"></td>
      <td><input type="number" name="laba_baju" placeholder="laba_baju" value="6000"></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="4" align="center" class="center">
        <button type="submit">Hitung</button>
      </td>
    </tr>
  </tbody>
</table>
<input type="hidden" name="hitung" value="1">
</form>

<hr>

<?php
// Ambil isian
$hitung = $_POST['hitung'];

$pemotongan_celana    = $_POST['pemotongan_celana'];
$pemotongan_baju      = $_POST['pemotongan_baju'];
$batas_jam_pemotongan = $_POST['batas_jam_pemotongan'];

$penjahitan_celana    = $_POST['penjahitan_celana'];
$penjahitan_baju      = $_POST['penjahitan_baju'];
$batas_jam_penjahitan = $_POST['batas_jam_penjahitan'];

$laba_celana = $_POST['laba_celana'];
$laba_baju   = $_POST['laba_baju'];

if ($hitung == '1') {

// mencari model matematika
$model_mat_1 = $pemotongan_celana."x + ".$penjahitan_celana."y = ".$batas_jam_pemotongan;
$model_mat_2 = $pemotongan_baju."x + ".$penjahitan_baju."y = ".$batas_jam_penjahitan;
$maksimalkan = "z = ".$laba_celana."x + ".$laba_baju."y";

// mencari titik koordinat
// Titik 1
$titik1_x = 0;
$titik1_y = $batas_jam_pemotongan / $pemotongan_baju; // 30

if ((($titik1_x * $pemotongan_celana) + ($titik1_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik1_x * $penjahitan_celana) + ($titik1_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik1 = 'Ya';
  $titik1_laba = ($laba_celana * $titik1_x) + ($laba_baju * $titik1_y);
} else {
  $titik1 = 'Tidak';
  $titik1_laba = 0;
}

// Titik 2
$titik2_x = $batas_jam_pemotongan / $pemotongan_celana;
$titik2_y = 0;

if ((($titik2_x * $pemotongan_celana) + ($titik2_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik2_x * $penjahitan_celana) + ($titik2_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik2 = 'Ya';
  $titik2_laba = ($laba_celana * $titik2_x) + ($laba_baju * $titik2_y);
} else {
  $titik2 = 'Tidak';
  $titik2_laba = 0;
}

// Titik 3
$titik3_x = 0;
$titik3_y = $batas_jam_penjahitan / $penjahitan_baju;

if ((($titik3_x * $pemotongan_celana) + ($titik3_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik3_x * $penjahitan_celana) + ($titik3_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik3 = 'Ya';
  $titik3_laba = ($laba_celana * $titik3_x) + ($laba_baju * $titik3_y);
} else {
  $titik3 = 'Tidak';
  $titik3_laba = 0;
}

// Titik 4
$titik4_x = $batas_jam_penjahitan / $penjahitan_celana;
$titik4_y = 0;

if ((($titik4_x * $pemotongan_celana) + ($titik4_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik4_x * $penjahitan_celana) + ($titik4_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik4 = 'Ya';
  $titik4_laba = ($laba_celana * $titik4_x) + ($laba_baju * $titik4_y);
} else {
  $titik4 = 'Tidak';
  $titik4_laba = 0;
}

// Titik 5
// Eliminasi x (mencari y)
$pemotongan_celana_el_1    = $pemotongan_celana * $penjahitan_celana;
$pemotongan_baju_el_1      = $pemotongan_baju * $penjahitan_celana;
$batas_jam_pemotongan_el_1 = $batas_jam_pemotongan * $penjahitan_celana;

$penjahitan_celana_el_1    = $penjahitan_celana * $pemotongan_celana;
$penjahitan_baju_el_1      = $penjahitan_baju * $pemotongan_celana;
$batas_jam_penjahitan_el_1 = $batas_jam_penjahitan * $pemotongan_celana;

$selisih_pemotongan_baju_dan_penjahitan_baju_el_1 = $pemotongan_baju_el_1 - $penjahitan_baju_el_1;
$selisih_batas_jam_pemotongan_dan_penjahitan_el_1 = $batas_jam_pemotongan_el_1 - $batas_jam_penjahitan_el_1;
$titik5_y = $selisih_batas_jam_pemotongan_dan_penjahitan_el_1  / $selisih_pemotongan_baju_dan_penjahitan_baju_el_1;

// Subtitusi y (mencari x)
$pemotongan_baju_sub_1 = $pemotongan_baju * $titik5_y;
$titik5_x = ($batas_jam_pemotongan - $pemotongan_baju_sub_1) / $pemotongan_celana;

// laba titik 5
if ((($titik5_x * $pemotongan_celana) + ($titik5_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik5_x * $penjahitan_celana) + ($titik5_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik5 = 'Ya';
  $titik5_laba = ($laba_celana * $titik5_x) + ($laba_baju * $titik5_y);
} else {
  $titik5 = 'Tidak';
  $titik5_laba = 0;
}

// Menentukan nilai maksimal
$arr = [
  '1' => $titik1_laba,
  '2' => $titik2_laba,
  '3' => $titik3_laba,
  '4' => $titik4_laba,
  '5' => $titik5_laba
];

$arr_max = max($arr);
$arr_name = array_search($arr_max, $arr);

$solusi_titik_x = ${'titik'.$arr_name.'_x'};
$solusi_titik_y = ${'titik'.$arr_name.'_y'};

// Brrr...
$jumlah_celana_maks = $solusi_titik_x;
$laba_celana_maks   = $jumlah_celana_maks * $laba_celana;

$jumlah_baju_maks = $solusi_titik_y;
$laba_baju_maks   = $jumlah_baju_maks * $laba_baju;

$laba_maks = $laba_celana_maks + $laba_baju_maks;
?>

<table border="1">
  <thead>
    <tr>
      <th>Nama Titik</th>
      <th>Nilai X (Celana)</th>
      <th>Nilai Y (Baju)</th>
      <th>Sesuai batasan?</th>
      <th>Laba</th>
      <th>Maksimum?</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Titik 1</td>
      <td><?php echo $titik1_x ?></td>
      <td><?php echo $titik1_y ?></td>
      <td class="center"><?php echo $titik1 ?></td>
      <td><?php echo $titik1_laba ?></td>
      <td class="center"><?php echo $arr_name == '1' ? 'Ya' : 'Tidak' ?></td>
    </tr>
    <tr>
      <td>Titik 2</td>
      <td><?php echo $titik2_x ?></td>
      <td><?php echo $titik2_y ?></td>
      <td class="center"><?php echo $titik2 ?></td>
      <td><?php echo $titik2_laba ?></td>
      <td class="center"><?php echo $arr_name == '2' ? 'Ya' : 'Tidak' ?></td>
    </tr>
    <tr>
      <td>Titik 3</td>
      <td><?php echo $titik3_x ?></td>
      <td><?php echo $titik3_y ?></td>
      <td class="center"><?php echo $titik3 ?></td>
      <td><?php echo $titik3_laba ?></td>
      <td class="center"><?php echo $arr_name == '3' ? 'Ya' : 'Tidak' ?></td>
    </tr>
    <tr>
      <td>Titik 4</td>
      <td><?php echo $titik4_x ?></td>
      <td><?php echo $titik4_y ?></td>
      <td class="center"><?php echo $titik4 ?></td>
      <td><?php echo $titik4_laba ?></td>
      <td class="center"><?php echo $arr_name == '4' ? 'Ya' : 'Tidak' ?></td>
    </tr>
    <tr>
      <td>Titik 5</td>
      <td><?php echo $titik5_x ?></td>
      <td><?php echo $titik5_y ?></td>
      <td class="center"><?php echo $titik5 ?></td>
      <td><?php echo $titik5_laba ?></td>
      <td class="center"><?php echo $arr_name == '5' ? 'Ya' : 'Tidak' ?></td>
    </tr>
  </tbody>
</table>

<hr>

<h3>Eliminasi</h3>
<?php
echo $pemotongan_celana_el_1.'x + '.$pemotongan_baju_el_1.'y = '.$batas_jam_pemotongan_el_1;
echo '<br>';
echo $penjahitan_celana_el_1.'x + '.$penjahitan_baju_el_1.'y = '.$batas_jam_penjahitan_el_1;
echo '<br>';
echo $selisih_pemotongan_baju_dan_penjahitan_baju_el_1.'y = '.$selisih_batas_jam_pemotongan_dan_penjahitan_el_1;
echo '<br>';
echo 'y = '.$titik5_y;
?>

<h3>Subtitusi</h3>
<?php
echo $pemotongan_celana.'x +'.$pemotongan_baju_sub_1.' = '.$batas_jam_pemotongan;
echo '<br>';
echo 'x = '.$titik5_x;
?>
<hr>

<h2>Penyelesaian </h2>
<table border="1">
  <thead>
    <tr>
      <th>Laba maksimal</th>
      <td><?php echo $arr_max; ?></td>
    </tr>
    <tr>
      <th>Nama Titik</th>
      <td><?php echo $arr_name; ?></td>
    </tr>
    <tr>
      <th>Nilai X (Celana)</th>
      <td><?php echo $solusi_titik_x; ?></td>
    </tr>
    <tr>
      <th>Nilai Y (Baju)</th>
      <td><?php echo $solusi_titik_y; ?></td>
    </tr>
  </thead>
</table>

<hr>

Model Matematika
<ul>
  <li><?php echo $model_mat_1; ?></li>
  <li><?php echo $model_mat_2; ?></li>
  <li><?php echo $maksimalkan; ?></li>
</ul>

<hr>

<table border="1">
  <thead>
    <tr>
      <th>Nama Produk</th>
      <th>Jumlah Produk</th>
      <th>Laba Maks</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th>Celana</th>
      <td><input type="number" name="jumlah_celana_maks" placeholder="jumlah_celana_maks" value="<?php echo $jumlah_celana_maks; ?>"></td>
      <td>Rp <input type="laba_celana_maks" placeholder="laba_celana_maks" value="<?php echo $laba_celana_maks; ?>"></td>
    </tr>
    <tr>
      <th>Baju</th>
      <td><input type="number" name="jumlah_baju_maks" placeholder="jumlah_baju_maks" value="<?php echo $jumlah_baju_maks; ?>"></td>
      <td>Rp <input type="laba_baju_maks" placeholder="laba_baju_maks" value="<?php echo $laba_baju_maks; ?>"></td>
    </tr>
    <tr>
      <th colspan="2">Total Laba</th>
      <td>Rp <input type="laba_maks" placeholder="laba_maks" value="<?php echo $laba_maks; ?>"></td>
    </tr>
  </tbody>
</table>

<?php
}
?>

<div id="chartDiv">
  
</div>

<script>
var trace1 = {
  x: [<?php echo $titik1_x;?>, <?php echo $titik2_x;?>], 
  y: [<?php echo $titik1_y;?>, <?php echo $titik2_y;?>], 
  type: 'scatter',
  name: '<?php echo $model_mat_1; ?>',
  showlegend: true
};
var trace2 = {
  x: [<?php echo $titik3_x;?>, <?php echo $titik4_x;?>], 
  y: [<?php echo $titik3_y;?>, <?php echo $titik4_y;?>], 
  type: 'scatter',
  name: '<?php echo $model_mat_2; ?>',
  showlegend: true
};
var trace3 = {
  x: [<?php echo $titik5_x;?>], 
  y: [<?php echo $titik5_y;?>], 
  type: 'scatter',
  name: 'Titik Potong',
  showlegend: false
};
var data = [trace1, trace2, trace3];
var layout = {
  xaxis: {title: 'Celana (x)'},
  yaxis: {title: 'Baju (y)'},
  scaleratio: 0,
  size: 40
};
Plotly.newPlot('chartDiv', data, layout);
</script>

</body>
</html>