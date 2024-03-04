<?php
include 'baglanti.php';?>
<!DOCTYPE html>
<html>
<title>İzmir Belediyesi İtfaiye Konumlandırma Sistemi</title>
<meta name="viewport" content="width=device-width, initial-scale=2">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.gstatic.com">

	    
<link rel="stylesheet" href="ekle.css">
<body>

<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:160px;">
<div class="logo">
                    <img src="izmir.png" width="160px" height="auto"></img>
                </div>
                <br> </br>
  <a href="ana.php" class="w3-bar-item w3-red w3-button">Anasayfa</a>
  <a href="oneri.php" class="w3-bar-item w3-red w3-button">Öneri</a>
  
  <button class="w3-button w3-block w3-red w3-left-align" onclick="myAccFunc()"> İstasyonlar <i class="fa fa-caret-down"></i>
  </button>
  <div id="demoAcc" class="w3-hide w3-grey w3-card">
    <a href="konum.php" class="w3-bar-item w3-button">İstasyon Grafiği ve Konumları</a>
    <a href="ekle.php" class="w3-bar-item w3-button">İstasyon Ekle</a>
  </div>

  <div class="w3-dropdown-click">
    <button class="w3-button w3-red" onclick="myDropFunc()">
      Müdahale <i class="fa fa-caret-down"></i>
    </button>
    <div id="demoDrop" class="w3-dropdown-content w3-bar-block w3-grey w3-card">
      <a href="mud_bil.php" class="w3-bar-item w3-button">Müdahale Bilgileri</a>
      <a href="mud_gra.php" class="w3-bar-item w3-button">Müdahale Grafikleri</a>
      <a href="mud_ekle.php" class="w3-bar-item w3-button">Müdahale Ekle</a>
    </div>
    <a href="giris3.php" class="w3-bar-item w3-red w3-button">Çıkış</a>
  </div>
</div>
<div class="w3-container w3-red">
  <h1>---------     İzmir Belediyesi İtfaiye İstasyonu Konumlandırma Sistemi</h1>
</div>


<script>
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-green";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-green", "");
  }
}

function myDropFunc() {
  var x = document.getElementById("demoDrop");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
    x.previousElementSibling.className += " w3-green";
  } else { 
    x.className = x.className.replace(" w3-show", "");
    x.previousElementSibling.className = 
    x.previousElementSibling.className.replace(" w3-green", "");
  }
}
</script>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Google Charts Sütun Grafiği</title>
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
  <style>
    .container {
            border-radius: 10px;
            background-color: #f2f2f2;
            padding-left: 10px;
            border-left-width: 10%;
            margin: auto;
            width: 30%;
            border: 3px white;
            padding: 20px;
            background: rgba(10, 1, 0, 0.8);
            margin-top: 50px;
        }
    .row {
            margin: auto;
            width: 30%;
            padding: 20px;
            margin-top: 700px;
    }
  </style>
</head>
<body>
  <div id="googleBarchart" class="container" style="position:absolute;
  top: 100px;
  left: 200px;
  right: 50px;
  width: 1300px;
  height: 500px;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <div class="row" style="position:absolute; 
  top: 100px;
  left: 380px;
  right: 50px;
  width: 1300px;
  height: 500px";>
                <div class="col-2">
                <iframe src="https://www.google.com/maps/d/embed?mid=1PKUusdzFsYb-HogoarPg-EkrwzErruU&ehbc=2E312F&noprof=1" width="1000" height="480"; ></iframe>
                </div>
            </div>


  <?php
  // Veritabanı bağlantısı
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "itfaiye";

  $conn = new mysqli($servername, $username, $password, $dbname);
  $conn->set_charset("utf8");

  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  // SQL sorgusu
  $sql = "SELECT ilce_ad, istasyon_sayisi FROM ist_sayisi_vw";

  $result = $conn->query($sql);

  // Verileri alın
  $data = array();
  while ($row = $result->fetch_assoc()) {
    $data[] = $row;
  }

  // Veritabanı bağlantısını kapat
  $conn->close();
  ?>

  <script>
    // Google Charts ile sütun grafiği oluşturun
    google.charts.load('current', {'packages':['corechart']});
    google.charts.setOnLoadCallback(drawGoogleChart);

    function drawGoogleChart() {
      var googleData = new google.visualization.DataTable();
      googleData.addColumn('string', 'Ilce');
      googleData.addColumn('number', 'Istasyon Sayisi');

      // Veritabanından gelen verileri Google Chart için ekleyin
      <?php
      foreach ($data as $row) {
        echo "googleData.addRow(['{$row['ilce_ad']}', {$row['istasyon_sayisi']}]);";
      }
      ?>

      var googleOptions = {
        title: 'İlçelere Göre İStasyon Sayısı',
        legend: { position: 'none' },
        colors: ['#4285F4'],
        bar: { groupWidth: '80%' },
        animation: { duration: 1000, easing: 'out', startup: true },
        hAxis: {
          title: 'Ilce',
          textStyle: {
            fontSize: 12,
            color: '#5e5e5e'
          },
        },
        vAxis: {
          title: 'Istasyon Sayisi',
          baselineColor: '#ddd',
          gridlineColor: '#ddd',
          textStyle: {
            fontSize: 12,
            color: '#5e5e5e'
          },
        },
      };

      var googleChart = new google.visualization.ColumnChart(document.getElementById('googleBarchart'));
      googleChart.draw(googleData, googleOptions);
    }
  </script>
</body>
</html>
</html>                              

  