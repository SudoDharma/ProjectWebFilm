<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="edit.css">
</head>
<body>
<?php
        $message = "";
        //include database connection
        include 'koneksi.php';

        //If there is any user action
        $action = isset($_POST['action']) ? $_POST['action'] : "";

        if($action == 'update'){  //the user submitted the form
            
            if($_FILES['cover']['size'] == 0){
                $query =    "update movies set 
                        judul = '".$mysqli->real_escape_string($_POST['judul'])."',
                        deskripsi = '".$mysqli->real_escape_string($_POST['deskripsi'])."',
                        rating = '".$mysqli->real_escape_string($_POST['rating'])."',
                        genre = '".$mysqli->real_escape_string($_POST['genre'])."',
                        link = '".$mysqli->real_escape_string($_POST['link'])."'
                        where id ='".$mysqli->real_escape_string($_REQUEST['id'])."'";

                //execute the query
                if($mysqli->query($query)){
                    //if edit success
                    $message = "Data berhasil diubah";
                }
                else{
                    //if failed
                    $message = "Data gagal diubah";
                }
            }
            else{
                $folder = "./foto/";
                $name = $_FILES['cover']['name'];
                $rename = date('Hs').$name;
                $sumber = $_FILES['cover']['tmp_name'];
                move_uploaded_file($sumber, $folder.$rename);
                //our update query
                $query =    "update movies set 
                judul = '".$mysqli->real_escape_string($_POST['judul'])."',
                cover = '".$mysqli->real_escape_string($rename)."',
                deskripsi = '".$mysqli->real_escape_string($_POST['deskripsi'])."',
                rating = '".$mysqli->real_escape_string($_POST['rating'])."',
                genre = '".$mysqli->real_escape_string($_POST['genre'])."',
                link = '".$mysqli->real_escape_string($_POST['link'])."'
                where id ='".$mysqli->real_escape_string($_REQUEST['id'])."'";

                //execute the query
                if($mysqli->query($query)){
                    //if edit success
                    $message = "Data berhasil diubah";
                }
                else{
                    //if failed
                    $message = "Data gagal diubah";
                }
            }  
        }

        //Select the specific database record to update
        $query = "select id, judul, cover, deskripsi, rating, genre, link
                    from movies
                    where id ='".$mysqli->real_escape_string($_REQUEST['id'])."'
                    limit 0,1";

        //execute the query
        $result = $mysqli->query($query);

        //get the result 
        $row = $result->fetch_assoc();

        //assign the result to certain variable so our html form will be filled up with values
        $id = $row['id'];
        $judul = $row['judul'];
        $cover = $row['cover'];
        $deskripsi = $row['deskripsi'];
        $rating = $row['rating'];
        $genre = $row['genre'];
        $link = $row['link'];
        
?>

<!--html form here-->
<div class="container">
        <form action="#" method="POST" enctype="multipart/form-data" class="tambah">
        <div class="input-field-border-bottom box">
            <div class="gambar">
                <img src="foto/<?php echo $cover;?>" width="200" border="2">
            </div>
            
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" value="<?php echo $judul;?>" />
            <br>
            <label for="cover">Cover</label>
            <input type="file" id="cover" class="upload" name="cover"/>
            <br><br>
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" cols="30" rows="5"><?php echo htmlspecialchars($deskripsi); ?></textarea>
            <br>
            <label for="rating">Rating</label>
            <input type="text" id="rating" name="rating" value="<?php echo $rating;?>.." /> 
            <br>
            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" value="<?php echo $genre;?>" />
            <br>
            <label for="link">Link</label>
            <input type="text" id="link" name="link" value="<?php echo $link;?>" />
            <br>

            <span class="message"><?php echo $message; ?></span>

            <br>
            <div class="btn1">
                <input type="hidden" name="id" value="<?php echo $id;?>" />

                <input type="hidden" name="action" value="update" />
                <input type="submit" class="button" value="Edit" />
                <a href="index.php" class="button1">Back to index</a>
            </div>
        </div>                
        
    </div>
</body>
</html>