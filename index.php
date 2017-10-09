<?php error_reporting(E_ERROR | E_PARSE); ?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="Miftah Afina">

    <title>Mencari Laba Maksimum - Miftah Afina</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="css/font-awesome.min.css" rel="stylesheet">


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/navbar-fixed-top.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="js/ie-emulation-modes-warning.js"></script>

    <!-- Plotly -->
    <script src="js/plotly-latest.min.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <!-- Fixed navbar -->
    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><i class="fa fa-rebel"></i> Mencari Laba Maksimum</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="#"><i class="fa fa-user"></i> Miftah Afina</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>

<div class="container">

<div class="row">
  <div class="col-md-6">    
    <form action="" method="post">
    <h3><i class="fa fa-pencil-square-o"></i> Form Pengisian</h3>
    <table class="table table-bordered table-condensed">
      <thead>
        <tr>
          <th rowspan="2">Jenis Pekerjaan</th>
          <th colspan="2">Nama Barang</th>
          <th rowspan="2">Batas Jam Maks.</th>
        </tr>
        <tr>
          <th>Celana</th>
          <th>Baju</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Pemotongan</th>
          <td><input type="number" name="pemotongan_celana" value="<?php echo $_POST['pemotongan_celana']; ?>" class="form-control" required></td>
          <td><input type="number" name="pemotongan_baju" value="<?php echo $_POST['pemotongan_baju']; ?>" class="form-control" required></td>
          <td><input type="number" name="batas_jam_pemotongan" value="<?php echo $_POST['batas_jam_pemotongan']; ?>" class="form-control" required></td>
        </tr>
        <tr>
          <th>Penjahitan</th>
          <td><input type="number" name="penjahitan_celana" value="<?php echo $_POST['penjahitan_celana']; ?>" class="form-control" required></td>
          <td><input type="number" name="penjahitan_baju" value="<?php echo $_POST['penjahitan_baju']; ?>" class="form-control" required></td>
          <td><input type="number" name="batas_jam_penjahitan" value="<?php echo $_POST['batas_jam_penjahitan']; ?>" class="form-control" required></td>
        </tr>
        <tr>
          <th>Laba / Unit</th>
          <td><input type="number" name="laba_celana" value="<?php echo $_POST['laba_celana']; ?>" class="form-control" required></td>
          <td><input type="number" name="laba_baju" value="<?php echo $_POST['laba_baju']; ?>" class="form-control" required></td>
          <td></td>
        </tr>
        <tr>
          <td colspan="4" align="center" class="center">
            <div class="form-group">
            </div>

            <div class="form-group">
              <a href="index.php" class="btn btn-default"><i class="fa fa-refresh"></i> Reset</a>
              &nbsp;&nbsp;&nbsp;
              <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Hitung</button>
            </div>
          </td>
        </tr>
      </tbody>
    </table>
    <input type="hidden" name="hitung" value="1">
    </form>
  </div>

  <div class="col-md-6">
    <?php if ($_POST['hitung'] == '1'): ?>
    <div class="well">
      <div id="chartDiv">
      </div>
    </div>
    <?php endif ?>
  </div>
</div>


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
  $titik1 = 'check';
  $titik1_laba = ($laba_celana * $titik1_x) + ($laba_baju * $titik1_y);
} else {
  $titik1 = 'close';
  $titik1_laba = 0;
}

// Titik 2
$titik2_x = $batas_jam_pemotongan / $pemotongan_celana;
$titik2_y = 0;

if ((($titik2_x * $pemotongan_celana) + ($titik2_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik2_x * $penjahitan_celana) + ($titik2_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik2 = 'check';
  $titik2_laba = ($laba_celana * $titik2_x) + ($laba_baju * $titik2_y);
} else {
  $titik2 = 'close';
  $titik2_laba = 0;
}

// Titik 3
$titik3_x = 0;
$titik3_y = $batas_jam_penjahitan / $penjahitan_baju;

if ((($titik3_x * $pemotongan_celana) + ($titik3_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik3_x * $penjahitan_celana) + ($titik3_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik3 = 'check';
  $titik3_laba = ($laba_celana * $titik3_x) + ($laba_baju * $titik3_y);
} else {
  $titik3 = 'close';
  $titik3_laba = 0;
}

// Titik 4
$titik4_x = $batas_jam_penjahitan / $penjahitan_celana;
$titik4_y = 0;

if ((($titik4_x * $pemotongan_celana) + ($titik4_y * $pemotongan_baju) <= $batas_jam_pemotongan) and (($titik4_x * $penjahitan_celana) + ($titik4_y * $penjahitan_baju) <= $batas_jam_penjahitan)) {
  $titik4 = 'check';
  $titik4_laba = ($laba_celana * $titik4_x) + ($laba_baju * $titik4_y);
} else {
  $titik4 = 'close';
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
  $titik5 = 'check';
  $titik5_laba = ($laba_celana * $titik5_x) + ($laba_baju * $titik5_y);
} else {
  $titik5 = 'close';
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

<div class="row">
  <div class="col-md-7">
    <h3><i class="fa fa-calculator"></i> Pencarian Titik</h3>
    <table class="table table-condensed table-striped table-bordered">
      <thead>
        <tr>
          <th>Nama Titik</th>
          <th>Nilai X <span class="text-muted">(Celana)</span></th>
          <th>Nilai Y <span class="text-muted">(Baju)</span></th>
          <th>Sesuai batasan?</th>
          <th>Laba <span class="text-muted">(Rp)</span></th>
          <th>Maksimum?</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <th>Titik 1</th>
          <td class="center"><?php echo $titik1_x ?></td>
          <td class="center"><?php echo $titik1_y ?></td>
          <td class="center"><i class="fa fa-<?php echo $titik1 ?>"></i></td>
          <td class="right"><?php echo number_format($titik1_laba, 0, ',', '.') ?></td>
          <td class="center"><i class="fa fa-<?php echo $arr_name == '1' ? 'check' : 'close' ?>"></i></td>
        </tr>
        <tr>
          <th>Titik 2</th>
          <td class="center"><?php echo $titik2_x ?></td>
          <td class="center"><?php echo $titik2_y ?></td>
          <td class="center"><i class="fa fa-<?php echo $titik2 ?>"></i></td>
          <td class="right"><?php echo number_format($titik2_laba, 0, ',', '.') ?></td>
          <td class="center"><i class="fa fa-<?php echo $arr_name == '2' ? 'check' : 'close' ?>"></i></td>
        </tr>
        <tr>
          <th>Titik 3</th>
          <td class="center"><?php echo $titik3_x ?></td>
          <td class="center"><?php echo $titik3_y ?></td>
          <td class="center"><i class="fa fa-<?php echo $titik3 ?>"></i></td>
          <td class="right"><?php echo number_format($titik3_laba, 0, ',', '.') ?></td>
          <td class="center"><i class="fa fa-<?php echo $arr_name == '3' ? 'check' : 'close' ?>"></i></td>
        </tr>
        <tr>
          <th>Titik 4</th>
          <td class="center"><?php echo $titik4_x ?></td>
          <td class="center"><?php echo $titik4_y ?></td>
          <td class="center"><i class="fa fa-<?php echo $titik4 ?>"></i></td>
          <td class="right"><?php echo number_format($titik4_laba, 0, ',', '.') ?></td>
          <td class="center"><i class="fa fa-<?php echo $arr_name == '4' ? 'check' : 'close' ?>"></i></td>
        </tr>
        <tr>
          <th>Titik 5</th>
          <td class="center"><?php echo $titik5_x ?></td>
          <td class="center"><?php echo $titik5_y ?></td>
          <td class="center"><i class="fa fa-<?php echo $titik5 ?>"></i></td>
          <td class="right"><?php echo number_format($titik5_laba, 0, ',', '.') ?></td>
          <td class="center"><i class="fa fa-<?php echo $arr_name == '5' ? 'check' : 'close' ?>"></i></td>
        </tr>
      </tbody>
    </table>
  </div>

  <div class="col-md-5">
    <h3><i class="fa fa-tasks"></i> Kesimpulan</h3>
    <table class="table table-condensed table-striped table-bordered">
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
          <td class="center"><?php echo $jumlah_celana_maks; ?></td>
          <td class="right">Rp <?php echo number_format($laba_celana_maks, 0, ',', '.'); ?>,-</td>
        </tr>
        <tr>
          <th>Baju</th>
          <td class="center"><?php echo $jumlah_baju_maks; ?></td>
          <td class="right">Rp <?php echo number_format($laba_baju_maks, 0, ',', '.'); ?>,-</td>
        </tr>
        <tr>
          <th colspan="2">Total Laba</th>
          <td class="right"><strong>Rp <?php echo number_format($laba_maks, 0, ',', '.'); ?>,-</strong></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?php
}
?>

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
  title: 'Diagram',
  xaxis: {title: 'Celana (x)'},
  yaxis: {title: 'Baju (y)'}
};
Plotly.newPlot('chartDiv', data, layout, {displayModeBar: false});
</script>

</div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="js/jquery.min.js"><\/script>')</script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
  </body>
</html>