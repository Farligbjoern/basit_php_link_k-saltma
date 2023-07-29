<!DOCTYPE html>
<html lang="TR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=windows, initial-scale=1.0">
    <title>Kodlar</title>
    <style>
        body{
            background: black;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align:center;
            height: 100vh;
            flex-direction: column;
        }
        * {
           font-family: sans-serif;
            box-sizing: border-box;
        }
        /*Boş*/
        .link{
            background-color: gray;
            text-align: center;
            width: 50%;
            height: 50px;
            padding: 30px;
        }
        /*Boş*/
        .lnk {
        }
    </style>
     <?php $db = mysqli_connect("localhost", "root", "", "linkler")?>
</head>
<body>
    <?php
    if(!isset($_GET['id'])) {
        echo '
        <div class="lnk">
            <form method="POST">
              <input type="url" placeholder="Bir link giriniz." name="lnk" required>
              <input type="submit" value="Gönder" name="gönder_lnk" required>
            </form>
        </div>    
        ';

        if(!isset($_POST['gönder_lnk'])) {
            echo '<p style="display:none;">Url Yok</p>';
        } elseif ($_POST['gönder_lnk']) {
            $link = $_POST['lnk'];
            $ip = $_SERVER['REMOTE_ADDR'];

            if(empty($link)) {
                echo '<script language="javascript">alert("Lütfen bir link giriniz!")</script>';
            } else {
                $kayit = "INSERT INTO link (link, ip) VALUES ('$link', '$ip')";
                $kayit_query = mysqli_query($db, $kayit) or die(mysqli_error($db));

                $kayit_cek = "SELECT * FROM link WHERE link='$link'";
                $kayit_cek_query = mysqli_query($db, $kayit_cek) or die(mysqli_error($db));

                if(mysqli_num_rows($kayit_cek_query) == 0) {
                    echo 'Bir hata oluştu!';
                } elseif(mysqli_num_rows($kayit_cek_query) > 0) {
                    $row = mysqli_fetch_assoc($kayit_cek_query);

                    $id = $row['id'];
                    header("location:index.php?id=$id");
                }

            }
        }
    } elseif ($_GET['id']) {
        $id = $_GET['id'];

        $göster = "SELECT * FROM link WHERE id='$id'";
        $göster_query = mysqli_query($db, $göster) or die(mysqli_error($db));

        if(mysqli_num_rows($göster_query) > 0) {
            $row = mysqli_fetch_assoc($göster_query);

            echo '
           <div class="lnk"> 
            <h1 style="color:red;">'.$row['link'].' adresine git</h1>
            <a href="'.$row['link'].'">Linke Git</a>
           </div> 
            ';
        }
    }
    
    ?>
    
</body>
</html>
