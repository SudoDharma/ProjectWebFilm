<!DOCTYPE html>
<?php
				include "koneksi.php";
				$id	= $_GET['id'];
				$sql = mysqli_query($mysqli, "SELECT * FROM movies where id='$id'");
				$data = mysqli_fetch_assoc($sql);
		?>
<html>
<head>
    <title>Movie</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>
    <?php 
        session_start();
        $login = "";
        if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            $login = true;
        } else {
            $login =  false;
        }

        $id = $_GET['id'];

        $action = isset($_GET['action']) ? $_GET['action'] : "";

        if($action=='delete'){ //if user click delete run this query
            $query = "delete from movies where id = ".$mysqli->real_escape_string($id)."";

            //execute query
            if($mysqli->query($query)){
                //if success delete
                echo "Data deleted";
                header("Location: index.php");
            }
            else{
                //if there is error in deleting record
                echo "Database error: Unable to delete record";
            }
        }
    
    ?>
    <div class="container">
       <nav>
            <ul>
                <li><a href="index.php">Beranda</a></li>
            </ul>
        </nav>
		<div>
		<article>
            <div class="isi">
            <div class="judul">
                <?php echo $data['judul']; ?>
            </div>
            <div class="rating">
            <?php echo "&#11088;" . $data['rating']; ?><br>
            </div>
                <div class="trailer">
                    <iframe width="790" height="336" src="https://www.youtube.com/embed/<?php echo $data['link'];?>?rel=0" title="YouTube video" allowfullscreen></iframe>
                </div>
                <img width="200" src="foto/<?php echo $data['cover'];?>" > 
                <br>
                <div class="genre">
				<?php echo $data['genre']; ?><br>
                </div>
                <div class="desc">
				<p><?php echo $data['deskripsi']; ?></p>
                </div>
                <a href='#' onclick='status(<?php echo $id .",".$login; ?>);'>Edit</a>
                <a href='#' onclick='delete_data(<?php echo $id .",".$login; ?>);'>Hapus</a>
            </div>    
        </article>
		</div>
       <footer>
            Copyright 2021
       </footer>
    </div>

    <script type="text/javascript">
        function delete_data(id, login){
            if(login){
               //prompt the user
                var answer = confirm("Are you sure?");

                if(answer){  //user clicked ok
                    //redirect to url with action as delete and id of the record to be deleted
                    window.location = "tampilan.php?action=delete&id=" + id;
                } 
            }
            else{
                alert("Anda belum login"); 
            }
            
        }
        function status(id, login){
            if(login){
                window.location = "edit.php?id=" + id;
            }
            else{
                alert("Anda belum login")
            }
        }
    </script>
</body>
</html>