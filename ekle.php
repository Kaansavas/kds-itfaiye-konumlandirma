<?php
@session_start();
include 'baglanti.php';
?>

<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İzmir Belediyesi İtfaiye Konumlandırma Sistemi</title>
    <link href="ekle.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
        <link rel="preconnect" href="https://fonts.gstatic.com">
    <!-- Eğer bir stil dosyanız varsa, aşağıdaki satırda uygun bir dosya yolunu belirtmelisiniz. -->
    <link rel="stylesheet" href="ekle.css">
</head>

<body>

    <div class="w3-sidebar w3-bar-block w3-light-grey w3-card" style="width:160px;">
        <div class="logo">
            <img src="izmir.png" width="160px" height="auto">
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
        <h1>--------- İzmir Belediyesi İtfaiye İstasyonu Konumlandırma Sistemi</h1>
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
    include('baglanti2.php');
    if (isset($_POST["submit"])) {
        $ist = $_POST['ad'];
        $mahalle = $_POST['mahalle'];
        $query = mysqli_query($con, "INSERT INTO istasyon (ad, mahalle_id) VALUES ('$ist', '$mahalle')");
        if ($query) {
            echo "<script>alert('done')</script>";
        } else {
            echo "<script>alert('error')</script>";
        }
    }
    ?>
</body>

</html>

<?php
@session_start();
include 'baglanti2.php';
?>

<!DOCTYPE html>
<html lang="tr">

<head lang="tr">
    <meta charset="UTF8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-widt, initial-scale=1.0">
    <title>İstasyon Ekleme</title>
    <link href="ekle.css" rel="stylesheet" type="text/css">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        input[type=text],
        select,
        textarea {
            width: 50%;
            padding: 10px;
            border: 10px solid #ccc;
            border-radius: 10px;
            box-sizing: border-box;
            margin-top: 6px;
            margin-bottom: 50px;
            resize: vertical;
        }

        input[type=submit] {
            background-color: red;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: red;
            color: black;
        }

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
            margin-top: 200px;
        }
    </style>
</head>

<body>
    <div class="container">
        <form method="POST">
            <font color="red">İstasyon Adı:</font>
            <input type="text" name="ad" /><br /><br />
            <font color="red">Mahalle Adı:</font>
            <select name="mahalle">
                <?php
                $mahalle = mysqli_query($con, "SELECT * FROM mahalle");

                while ($mah = mysqli_fetch_array($mahalle)) {
                ?>
                <option value="<?php echo $mah['mahalle_id'] ?>"><?php echo $mah['mahalle_ad'] ?></option>
                <?php } ?>
            </select> <br /><br />

            <input type="submit" name="submit" value="EKLE..">
        </form>
    </div>
</body>

</html>