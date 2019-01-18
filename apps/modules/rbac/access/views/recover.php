<div class="login-box">
    <div class="logo">
        <a href="<?=site_url();?>" style="padding-bottom: 30px;">
            <img src="<?= base_url('assets/img/logo.png'); ?>" style="height: 100px;">
        </a>
        <a href="<?=site_url();?>"><?= $this->apps->logintitle; ?></a>
        <small><?= $this->apps->logindesc; ?></small>
    </div>
    <div class="card">
        <div class="body">
                <?php
                    $attributes = array(
                        'id' => 'form_recover'
                        , 'name' => 'form_recover'
                        , 'class' => 'm-login__form m-form');
                    echo form_open('access/recover', $attributes);
                ?> 
                <div class="msg">Sign in to start your session</div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <?=form_input($form['username']);?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-xs-12">
                        <button id="submit-recover-password" class="btn btn-block bg-blue waves-effect" type="submit">RESET PASSWORD</button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-12 align-center">
                        <a href="#" class="btn-login">Kembali Login</a>
                    </div>
                </div>
                <?php
                    echo form_close();
                ?>
        </div>
    </div>
</div>
