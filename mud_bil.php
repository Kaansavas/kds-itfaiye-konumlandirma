<?php
include 'baglanti.php';?>
<!DOCTYPE html>
<html lang="tr">
<title>İzmir Belediyesi İtfaiye Konumlandırma Sistemi</title>
<meta name="viewport" content="width=device-width, initial-scale=2">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
<link rel="preconnect" href="https://fonts.gstatic.com">
	    
<link rel="stylesheet" href="">
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
            <?php
                $mud=$vt->query('SELECT mudahale.mudahale_id,kategori.kategori_ad,tip.tip_ad,mahalle.mahalle_ad,ilce.ilce_ad
                FROM mudahale,kategori,tip,mahalle,ilce
                WHERE mudahale.kategori_id=kategori.kategori_id AND mudahale.tip_id=tip.tip_id AND mahalle.mahalle_id=mudahale.mahalle_id AND ilce.ilce_id=mahalle.ilce_id
                ORDER BY mudahale.mudahale_id desc ')->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="container p-8 my-6 bg-grey text-white">
            <table class="table table-striped table-grey table-hover table-sm">
                <tr>
                    <th>Mudahale ID</th>
                    <th>Kategori Adı</th>
                    <th>Tip Adı</th>
                    <th>Mahalle Adı</th>
                    <th>İlçe Adı</th>

                </tr>
            <?php
            foreach ($mud as $mud_ad) { ?>
                <tr>
                    <td><?=$mud_ad['mudahale_id']?></td>
                    <td><?=$mud_ad['kategori_ad']?></td>
                    <td><?=$mud_ad['tip_ad']?></td>
                    <td><?=$mud_ad['mahalle_ad']?></td>
                    <td><?=$mud_ad['ilce_ad']?></td>

                </tr>
        <?php   }
                ?>

</body>
</html>