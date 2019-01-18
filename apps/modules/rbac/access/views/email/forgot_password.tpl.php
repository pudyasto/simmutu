<html>
<body>
    <p>Klik link dibawah untuk mereset password</p>
    <p>
        <?php echo anchor('access/reset?token='.$forgotten_password_code, 'Reset Password Disini');?>
    </p>
    <p>Atau copy url dibawah ke alamat di browser</p>
    <p><?=anchor('access/reset?token='.$forgotten_password_code);?></p>
    <p> 
        <strong>Reset password hanya berlaku 5 menit</strong> 
    </p>
    <hr>
    <p> Abaikan pesan ini jika bukan anda yang melakukan reset password. </p>
    <p> Jika ada masalah lain, silahkan hubungi IT Administrator anda. </p>
    <hr>
    <p><?php echo $this->apps->companyname;?></p>
    <p><?php echo $this->apps->companyaddr;?></p>
    <p><?php echo $this->apps->companyinfo;?></p>
    <br><br><br><br>
    <p> Terima Kasih </p>
</body>
</html>