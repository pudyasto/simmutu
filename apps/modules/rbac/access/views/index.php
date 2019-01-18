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
                        'id' => 'form_login'
                        , 'name' => 'form_login'
                        , 'class' => 'm-login__form m-form');
                    echo form_open('access/login', $attributes);
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
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <?=form_input($form['password']);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-8 p-t-5">
                        <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-green">
                        <label for="rememberme">Remember Me</label>
                    </div>
                    <div class="col-xs-4">
                        <button id="submit" name="submit" class="btn btn-block bg-green waves-effect" type="submit">SIGN IN</button>
                    </div>
                </div>
                <div class="row m-t-15 m-b--20">
                    <div class="col-xs-6">
                        &nbsp;
                    </div>
                    <div class="col-xs-6 align-right">
                        <a href="#" class="btn-reset-password">Forgot Password?</a>
                    </div>
                </div>
                <?php
                    echo form_close();
                ?>
        </div>
        <div class="footer">
            
        </div>
    </div>
</div>
