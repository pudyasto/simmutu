<html>
<body>
    <p>Selamat, Password anda berhasil di ubah</p>
    <p>Silahkan gunakan password dibawah untuk login : </p>
    <p>
        User Name : <?php echo $identity;?>
    </p>
    <p>
        Password : <?php echo $new_password;?>
    </p>    
    
    <p> Jika ada masalah lain, silahkan hubungi IT Administrator anda. </p>
    <hr>
    <p><?php echo $this->apps->companyname;?></p>
    <p><?php echo $this->apps->companyaddr;?></p>
    <p><?php echo $this->apps->companyinfo;?></p>
    <br><br><br><br>
</body>
</html>