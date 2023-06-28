<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <div class="navbar">
            <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="#">
                <img src="galerie/Logo (2).svg" width="100" height="80" alt="">
            </a>
            <ul>
                <li><a class="active" href="../">Home</a></li>
                <li><a href="#news">News</a></li>
                <li><a href="../index.php#A-propos">About</a></li>
                <li><a href="../contact/contact.php">Contact</a></li>
            </ul>
            <div class="lien">
            <a id="ax" href="./dashboard.php"> <img id="compte" src="galerie/compte.png" alt="">Profil</a>
            <a id="ay" href="./logout.php">  <img id="log" src="galerie/log.png" alt=""> Log out</a>
        </div>
            </nav>
</div>
</head>
<style>

a #compte{
    height: 20px;
    width: 20px;
}
a #log{
    height: 20px;
    width: 20px;
}
.lien #ax{
    position: absolute;
    color: black;   
    text-decoration: none;
    margin-left: 80vw;
    margin-top: -50px;
    font-weight: bold;
    font-size: 18px;
}
.lien #ay{
    position: absolute;
    font-size: 18px;
    text-decoration: none;
    color: black;
    margin-left: 90vw;
    margin-top: -50px;
    font-weight: bold;
}

    nav{
        border: solid 1px black;
        border-radius: 8px;
       
    }
    li {
  float: left;
  color: white;
}

 li a {
    position: relative;
  
  display: flex;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  margin-left: 100px;
  margin-top: -60px;
  position: absolute;
  font-weight: bold;
  font-size: 18px;
}
</style>
<body>
    
</body>
</html>





