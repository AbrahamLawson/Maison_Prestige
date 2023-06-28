
    <div class="navbar">
            <nav class="navbar navbar-light bg-light">
            <a class="navbar-brand" href="../">
                <img src="../../medias/images/Logo (2).svg" width="100" height="80" alt="">
            </a>
            <ul>
                <li><a class="active" href="../">Home</a></li>
                <li><a href="../../index.php#news">News</a></li>
                <li><a href="../../index.php#A-propos">About</a></li>
                <li><a href="../../contact/contact.php">Contact</a></li>
            </ul>
            <?php
            if (isset($_SESSION['individu_connecte']['role'])){
            ?>
            <div class="lien">
            <a id="ax" href="../dashboard.php"> <img id="compte" src="../../medias/images/compte.png" alt="">Profil</a>
            <a id="ay" href="../login.php">  <img id="log" src="../../medias/images/log.png" alt=""> Log out</a>
        </div>
        <?php
            } else {
                ?>
            <div class="lien">
                <a id="ax" href="../register.php"> <img id="compte" src="../../medias/images/compte.png" alt=""> Sign In</a>
                <a id="ay" href="../login.php">  <img id="log" src="../../medias/images/log.png" alt=""> Log In</a>
        </div>
                <?php
            }
        ?>
            </nav>
    </div>





