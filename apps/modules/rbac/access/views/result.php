<div class="m-login__container">
    <div class="m-login__logo">
        <a href="#" style="padding-bottom: 30px;">
            <img src="<?= base_url('assets/img/logo.png'); ?>" style="height: 100px;">
        </a>
    </div>
    <div class="m-login__signin">      
        <div class="m-login__head">
            <h3 class="m-login__title">
                <?=$this->apps->logintitle;?>
            </h3>
            <div class="m-login__desc">
                <?=$this->apps->logintag;?>
            </div>
        </div>
        <?php
            if(empty($data)){
                redirect('access');
                exit;
            }
            $attaccessform = array(
                'class' => 'm-t'
                , 'id' => 'access_form'
                , 'name' => 'access_form'
                , 'method' => 'post');
            echo form_open(site_url('access'),$attaccessform); 
        ?>   
        <br><br>
        <div class="form-group m-form__group">
            <?=$data;?>
        </div>

        <div class="m-login__form-action">
            <button type="button" class="btn btn-outline-success m-btn m-btn--pill btn-sm m-btn--custom m-login__btn btn-login">
                Halaman Login
            </button>
        </div>
        <?php
        echo form_close();
        ?>
    </div>
    <div class="m-login__account">
        <?php echo $this->apps->copyright . " - " . $this->apps->kd_cabang; ?> &copy; <?=(date('Y')<='2018') ? '2018' : '2018 - ' . date('Y');?>
        <br>
        <small>
            <?php echo $this->apps->dept . ' | Engine Ver : ' . CI_VERSION . ' | Server Ver : ' . phpversion(); ?>
        </small>
        <br>
        <small>
            Tampilan Terbaik Gunakan 
            <a style="color:#536c79;text-decoration: underline;" href="https://www.google.com/chrome/browser/desktop/" target="blank">Google Chrome</a> 
            Terbaru
        </small>
    </div>
</div>