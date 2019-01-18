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
                <?=$this->apps->logindesc;?>
            </div>
        </div>
        <?php
        $attributes = array(
            'id' => 'form_reset'
            , 'name' => 'form_reset'
            , 'class' => 'm-login__form m-form');
        echo form_open('access/reset', $attributes);
        ?>  
        <div class="form-group m-form__group">
            <?php 
                $form['forgotten_password_code']['value'] = $forgotten_password_code;
                echo form_input($form['forgotten_password_code']);
                echo form_input($form['password']);
                echo form_error('password','<div class="note">','</div>'); 
            ?>
        </div>
        <div class="form-group m-form__group">
            <?php 
                echo form_input($form['confirm_password']);
                echo form_error('confirm_password','<div class="note">','</div>'); 
            ?>
        </div>
        <div class="m-login__form-action">
            <button type="submit" value="reset-password" name="submit" id="submit" class="btn btn-success m-btn m-btn--pill btn-sm m-btn--custom m-btn--air m-login__btn m-login__btn--primary">
                Simpan
            </button>
                &nbsp;&nbsp;
                <button type="button" class="btn btn-outline-secondary m-btn m-btn--pill btn-sm m-btn--custom m-login__btn btn-login">
                    Cancel
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