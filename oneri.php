<?php
include 'baglanti2.php';


// Formdan gelen değerleri kontrol et
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $istasyonEskiDegeri = $_POST["istasyon_eski_deger"];
    $mudahaleEskiDegeri = $_POST["mudahale_eski_deger"];

    // Veritabanı bağlantısı
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "itfaiye";

    $con = new mysqli($servername, $username, $password, $dbname);
    $con->set_charset("utf8");

    // Bağlantı kontrolü
    if ($con->connect_error) {
        die("Veritabanına bağlanılamadı: " . $con->connect_error);
    }

    // İlçe, istasyon sayısı ve müdahale sayısını içeren bir sorgu
    $sql = "SELECT
    ilce.ilce_ad,
    ilce_mud_sayi_vw.mudahale2_sayisi as mudahale_sayisi,
    ist_sayisi_vw.istasyon_sayisi as istasyon_sayisi
FROM
    ilce
LEFT JOIN
    ilce_mud_sayi_vw ON ilce.ilce_ad= ilce_mud_sayi_vw.ilce_ad
LEFT JOIN
    ist_sayisi_vw ON ilce.ilce_ad = ist_sayisi_vw.ilce_ad
GROUP BY
    ilce.ilce_ad, ilce_mud_sayi_vw.mudahale2_sayisi, ist_sayisi_vw.istasyon_sayisi
    ORDER BY istasyon_sayisi asc ,mudahale_sayisi desc ";

    $result = $con->query($sql);

    $oneriBulundu = false;

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ilce = $row["ilce_ad"];
            $istasyonSayisi = $row["istasyon_sayisi"];
            $mudahaleSayisi = $row["mudahale_sayisi"];

            if ($istasyonSayisi <= $istasyonEskiDegeri && $mudahaleSayisi >= $mudahaleEskiDegeri) {
                echo '<div class="container">';
                echo "<p>İstasyon sayısının az olması ve müdahale sayısısının fazla olması yüzünden $ilce'da istasyon açılması önerilir.</p>";
                echo '</div>';
                $oneriBulundu = true;
                break; // Tek bir öneri göstermek için döngüyü sonlandır
            }
        }
    }

    if (!$oneriBulundu) {
        echo '<div class="container">';
        echo "<p>Girilen Verilerle İlgili Öneri Bulunamadı.</p>";
        echo '</div>';
    }

    // Veritabanı bağlantısını kapatma
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İzmir Belediyesi İtfaiye Konumlandırma Sistemi</title>
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="stylesheet" href="">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .w3-container {
            padding: 16px;
        }

        .container {
            border-radius: 10px;
            background-color: #f2f2f2;
            padding-left: 20px;
            padding-right: 20px;
            margin: auto;
            width: 50%;
            border: 3px solid white;
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            margin-top: 50px;
            text-align: center;
            color: #fff;
        }
        .container1 {
            border-radius: 10px;
            background-color: #f2f2f2;
            padding-left: 20px;
            padding-right: 20px;
            margin: auto;
            width: 50%;
            border: 3px solid white;
            padding: 20px;
            background: rgba(128, 128, 128, 0.8);
            margin-top: 50px;
            text-align: center;
            color: #2F4F4F;
        }
    </style>
</head>
<body>

<div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:160px;">
    <div class="logo">
        <img src="izmir.png" width="160px" height="auto"></img>
    </div>
    <br>
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
    <h1>--------- İzmir Belediyesi İtfaiye İstasyonu Konumlandırma Sistemi</h1>
</div>

<div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="istasyon_eski_deger">İstasyon Çok Değeri:</label>
        <input type="text" name="istasyon_eski_deger" required>
        <br>
        <label for="mudahale_eski_deger">Müdahale Az Değeri:</label>
        <input type="text" name="mudahale_eski_deger" required>
        <br>
        <input type="submit" value="Değerleri Kontrol Et">
    </form>
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
                include "baglanti.php";
                $ist=$vt->query('SELECT * from ist_sayisi_vw ')->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="container1">
            <table class="table">
                <tr>
                    <th>İlçe Adı</th>
                    <th>İstasyon Sayisi</th>

                </tr>
            <?php
            foreach ($ist as $ist_sayi) { ?>
                <tr>
                    <td><?=$ist_sayi['ilce_ad']?></td>
                    <td><?=$ist_sayi['istasyon_sayisi']?></td>

                </tr>
        <?php   }
                ?>
                <?php
                include "baglanti.php";
                $mud=$vt->query('SELECT * from ilce_mud_sayi_vw ')->fetchAll(PDO::FETCH_ASSOC);
            ?>

            <div class="container2">
            <table class="table">
                <tr>
                    <th>İlçe Adı</th>
                    <th>Müdahale Sayisi</th>

                </tr>
            <?php
            foreach ($mud as $mud_sayi) { ?>
                <tr>
                    <td><?=$mud_sayi['ilce_ad']?></td>
                    <td><?=$mud_sayi['mudahale2_sayisi']?></td>

                </tr>
        <?php   }
                ?>

</body>
</html>