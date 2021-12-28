<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah</title>
    <link rel="stylesheet" href="tambah.css">
</head>
<body>
    <?php
    $message = "";
    //If there is any user action
    $action = isset($_POST['action']) ? $_POST['action'] : "";
    
    if($action == 'create'){  //the user submitted the form
    
        //include database connection
        include 'koneksi.php';
    
        $folder = "./foto/";
        $name = $_FILES['cover']['name'];
        $rename = date('Hs').$name;
        $sumber = $_FILES['cover']['tmp_name'];
        move_uploaded_file($sumber, $folder.$rename);
    
        //our insert query
        $query =    "insert into movies set 
                    judul = '".$mysqli->real_escape_string($_POST['judul'])."',
                    cover = '".$mysqli->real_escape_string($rename)."',
                    deskripsi = '".$mysqli->real_escape_string($_POST['deskripsi'])."',
                    rating = '".$mysqli->real_escape_string($_POST['rating'])."',
                    genre = '".$mysqli->real_escape_string($_POST['genre'])."',
                    link = '".$mysqli->real_escape_string($_POST['link'])."'";
    
        //execute the query
        if($mysqli->query($query)){
            //if saving success
            $message = "Berhasil menambahkan data";
        }
        else{
            //if unable to create record
            $message = "Gagal menambahkan data";
        }
    
        //close database connection
        $mysqli->close();
    }
    
    ?>
    
    <div class="container">
        <form action="#" method="POST" enctype="multipart/form-data" class="tambah">
        <div class="input-field-border-bottom box">
            <label for="judul">Judul</label>
            <input type="text" id="judul" name="judul" placeholder="Masukan judul.." />
            <br>
            <label for="cover">Cover</label>
            <input type="file" id="cover" class="upload" name="cover"/>
            <br><br>
            <label for="deskripsi">Deskripsi</label>
            <textarea id="deskripsi" name="deskripsi" placeholder="deskripsi.." cols="30" rows="5"></textarea>
            <br>
            <label for="rating">Rating</label>
            <input type="text" id="rating" name="rating" placeholder="Rating.." /> 
            <br>
            <label for="genre">Genre</label>
            <input type="text" id="genre" name="genre" placeholder="Masukan genre.." />
            <br>
            <label for="link">Link</label>
            <input type="text" id="link" name="link" placeholder="Masukan id video.." />
            <br>

            <span class="message"><?php echo $message; ?></span>

            <br>
            <div class="btn1">
            <input type="hidden" name="action" value="create" />
            <input type="submit" class="button" value="Save" />
            <a href="index.php" class="button1">Back to index</a>
            </div>
        </div>                
        
    </div>
    
</body>
</html>