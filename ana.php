<?php
include 'baglanti2.php';

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "itfaiye";

$con = new mysqli($servername, $username, $password, $dbname);

if ($con->connect_error) {
    die("Veritabanına bağlanılamadı: " . $con->connect_error);
}
$con->set_charset("utf8");

if(isset($_GET['silme_id'])){
    $silme_id = $_GET['silme_id'];

    $silme_sorgusu = "DELETE FROM istasyon WHERE id = $silme_id";

    if ($con->query($silme_sorgusu) === TRUE) {
        echo "Veri başarıyla silindi";
    } else {
        echo "Error: " . $silme_sorgusu . "<br>" . $con->error;
    }
}

$sql = "SELECT istasyon.id, istasyon.ad, mahalle.mahalle_ad, ilce.ilce_ad
        FROM istasyon
        JOIN mahalle ON istasyon.mahalle_id = mahalle.mahalle_id
        JOIN ilce ON mahalle.ilce_id = ilce.ilce_id";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <title>İzmir Belediyesi İtfaiye Konumlandırma Sistemi</title>
    <meta name="viewport" content="width=device-width, initial-scale=2">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
</head>
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

<div class="container p-8 my-6 bg-grey text-white">
    <table class="table table-striped table-grey table-hover table-sm">
        <tr>
            <th>İstasyon ID</th>
            <th>İstasyon Adı</th>
            <th>Mahalle Adı</th>
            <th>İlçe Adı</th>
            <th>Sil</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?=$row['id']?></td>
                    <td><?=$row['ad']?></td>
                    <td><?=$row['mahalle_ad']?></td>
                    <td><?=$row['ilce_ad']?></td>
                    <td><button onclick='silmeFonksiyonu(<?=$row["id"]?>)'>Sil</button></td>
                </tr>
            <?php }
        } else {
            echo "Tabloda veri bulunamadı";
        }
        ?>
    </table>
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

    function silmeFonksiyonu(silme_id) {
        if (confirm('Bu istasyonu silmek istediğinizden emin misiniz?')) {
            window.location.href = '?silme_id=' + silme_id;
        }
    }
</script>


</body>
</html>