<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php 

    include "koneksi.php";
    session_start();             
    $login = "";
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
         $login = true;
    } else {
        $login =  false;
    }

?>
<div class="container">
       <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
                <li><a href='Login.php'>Login</a></li>
                <li><a href="#" onclick="logout()">Logout</a></li>
            </ul>
        </nav>
		<article>
            <div class="tambah">
                <a href='#' onclick="status(<?php echo $login; ?>)">Tambah data baru</a>
            </div>
         </article>

       <article class="loop">
		    <?php
				$sql = mysqli_query($mysqli, "SELECT * FROM movies");
				while ($data = mysqli_fetch_assoc($sql)) {
				?>
                <div class="konten">
                    <a href="tampilan.php?id=<?php echo $data['id']; ?>"><img src="foto/<?php echo $data['cover'];?>" ></a>
                    <div class="judul">
                        <a href="tampilan.php?id=<?php echo $data['id']; ?>"><?php echo $data['judul']; ?></a>
                    </div>
                    <p class="pclass">
                        <?php echo "rating :", $data['rating']; ?><br>
                        <?php echo "genre :", $data['genre']; ?>
                    </p>
				
				    <p class="btn1"><button style="color:white;" class="button2"> <a href="tampilan.php?id=<?php echo $data['id']; ?>">Tampilkan</button></p>
                </div>

			<?php } ?>
        </article>
  
       <footer>
             Copyright 2021
       </footer>
    </div>
    <script type="text/javascript">
        function status(login){
            if(login){
                window.location = "tambah.php";
            }
            else{
                alert("Anda belum login")
            }
        }

        //prompt the user
        function logout(){
            var answer = confirm("Are you sure want to logout?");

            if(answer){  //user clicked ok
                //redirect to url with action as delete and id of the record to be deleted
                window.location = "end.php";
            }
        } 
    </script>

</body>
</html>