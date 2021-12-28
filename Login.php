<?php 
session_start();
$conn = mysqli_connect("localhost","root","","pallmarket");

$usernameErr = $passwordErr = $loginErr = "";

if( isset($_POST["login"]))
{
    if (empty($_POST["username"])&&empty($_POST["password"])){
        $usernameErr = "Username kosong dan";
        $passwordErr = "Password kosong";
    }
    else if (empty($_POST["username"])){
        $passwordErr = "Username kosong";
    }
    else if (empty($_POST["password"])){
        $passwordErr = "Password kosong";
    }
    else{
        $search = mysqli_query($conn, "SELECT * FROM user WHERE username ='". $_POST["username"] ."'");
        $count = mysqli_num_rows($search);

        if($count == 0)
        {
            $loginErr = "Username tak ditemukan";
        }
        else
        {
            $row = $search->fetch_assoc();
            if($_POST["password"] == $row["password"])
            {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $_POST["username"];
                header("Location: index.php");
            }
            else
            {
                $loginErr = "Maaf, password salah";
            } 
        }
    }   
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Halaman login</title>
    <link rel="stylesheet" href="Login.css">
</head>

<body>
    
    <div class="background"></div>
    <div class="content">
            <p class="header">Login</p>
            <div class="loginform">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                    
                    <label for="username">Username: </label>
                    <input type="text" name="username" id="username" style="border-radius: 5px; width:220px;">
                    <br>

                    <label for="password">Password : </label>
                    <input type="password" name="password" id="password" style="border-radius: 5px; width:220px;">
                    <br>

                    <span class="error"> <?php echo $usernameErr;?></span>
                    <span class="error"> <?php echo $passwordErr;?></span>
                    <span class="error"> <?php echo $loginErr;?></span>
                    <br>

                    <button type="submit" name="login" class="btnlogin">Login</button>
                </form>
            </div>
        </div>
</body>
</html>