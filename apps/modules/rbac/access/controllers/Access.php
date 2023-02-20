<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Access extends CI_Controller {

    protected $data;

    public function __construct() {
        parent::__construct();
        $this->_init_form();
        $link = $this->uri->segment(2);
        if ($link !== "logout") {
            $logged_in = $this->session->userdata('logged_in');
            if ($logged_in) {
                redirect("main");
            }
        }
    }

    public function index() {
        $this->template
                ->title('Login User', $this->apps->name)
                ->set_layout('login-layout')
                ->build('index', $this->data);
    }

    public function login() {
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">'
                . ' <button type="button" class="close" data-dismiss="alert">×</button>', '</div>');

        if ($this->form_validation->run() == FALSE) {
            $this->template
                    ->title('Login User', $this->apps->name)
                    ->set_layout('login-layout')
                    ->build('index', $this->data);
        } else {
            $identity = $this->input->post('username');
            $password = $this->input->post('password');
            $remember = $this->input->post('remember');
            $user_id = $this->ion_auth->login($identity, $password, $remember);
            if ($user_id) {
                $this->_set_session($user_id);
                $res = array(
                    'state' => '1',
                    'title' => 'Login Berhasil!',
                    'msg' => 'Selamat Datang, ' . $identity,
                    'token' => $this->security->get_csrf_hash(),
                );
            } else {
                $res = array(
                    'state' => '0',
                    'title' => 'Login Gagal!',
                    'msg' => 'Username atau Password anda salah!',
                    'token' => $this->security->get_csrf_hash(),
                );
            }
            echo json_encode($res);
        }
    }

    public function recover() {
        if ($this->input->post()) {
            $this->form_validation->set_rules('username', 'Nama Pengguna', 'required');
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">'
                    . ' <button type="button" class="close" data-dismiss="alert">×</button>', '</div>');
            if ($this->form_validation->run() == false) {
                $this->template
                        ->title('Login User', $this->apps->name)
                        ->set_layout('login-layout')
                        ->build('recover', $this->data);
            } else {
                $forgotten = $this->ion_auth->forgotten_password($this->input->post('username'));
                if ($forgotten) {
                    $res = array(
                        'state' => '1',
                        'title' => 'Email Terkirim!',
                        'msg' => 'Buka email anda untuk konfirmasi reset password!',
                        'token' => $this->security->get_csrf_hash(),
                    );
                } else {
                    $res = array(
                        'state' => '0',
                        'title' => 'Email Gagal Dikirim!',
                        'msg' => $this->ion_auth->errors(),
                        'token' => $this->security->get_csrf_hash(),
                    );
                }
                echo json_encode($res);
            }
        } else {
            $this->template
                    ->title('Recovery Your Accounts', $this->apps->name)
                    ->set_layout('login-layout')
                    ->build('recover', $this->data);
        }
    }

    public function result() {
        $res['data'] = $this->session->userdata('msg');
        $this->template
                ->title('Recovery Your Accounts', $this->apps->name)
                ->set_layout('login-layout')
                ->build('result', $res);
    }

    public function reset() {
        $this->form_validation->set_rules('forgotten_password_code', 'Forgotten Password Code', 'required');
        $this->form_validation->set_rules('password', 'Password', 'max_length[50]|min_length[2]|required');
        $this->form_validation->set_rules('confirm_password', 'Ulangi Password', 'max_length[50]|min_length[2]|required|matches[password]');
        if ($this->input->post()) {
            if ($this->form_validation->run() == true) {
                $forgotten_password_code = $this->input->post('forgotten_password_code');
                $profile = $this->ion_auth->forgotten_password_check($forgotten_password_code);

                $password = $this->input->post('confirm_password');
                $data = array(
                    'password' => $password,
                    'forgotten_password_code' => '',
                );
                $stat = $this->ion_auth->update($profile->id, $data);
                if ($stat) {
                    $res = array(
                        'state' => '1',
                        'title' => 'Reset Password Berhasil!',
                        'msg' => 'Silahkan login dengan menggunakan password baru anda',
                        'token' => $this->security->get_csrf_hash(),
                    );
                } else {
                    $res = array(
                        'state' => '0',
                        'title' => 'Reset Password Gagal!',
                        'msg' => 'Silahkan ulang beberapa saat lagi!',
                        'token' => $this->security->get_csrf_hash(),
                    );
                }
                echo json_encode($res);
            } else {
                $res = array(
                    'state' => '0',
                    'title' => 'Reset Password Gagal!',
                    'msg' => validation_errors(),
                    'token' => $this->security->get_csrf_hash(),
                );
                echo json_encode($res);
            }
        } else {
            $code = $this->input->get('token');
            $profile = $this->ion_auth->forgotten_password_check($code);
            if ($profile) {
                $this->data['forgotten_password_code'] = $profile->forgotten_password_code;
                $this->template
                        ->title('Login User', $this->apps->name)
                        ->set_layout('login-layout')
                        ->build('reset_password', $this->data);
            } else {
                $msg = '<div class="alert alert-danger">'
                        . ' <strong>Kesalahan !</strong> <br>' . $this->ion_auth->errors()
                        . ' </div>';
                $this->session->set_flashdata('msg', $msg);
                redirect("access/result", 'refresh');
            }
        }
    }

    public function logout() {
        $res = $this->ion_auth->logout();
        if ($res) {
            redirect('access', 'refresh');
        } else {
            redirect('dashboard');
        }
    }

    private function _init_form() {
        $this->data['form'] = array(
            'username' => array(
                'placeholder' => 'Username',
                'autocomplete' => 'off',
                'type' => 'text',
                'name' => 'username',
                'value' => set_value('username'),
                'class' => 'form-control m-input',
                'required' => '',
            ),
            'password' => array(
                'placeholder' => 'Password',
                'type' => 'password',
                'id' => 'password',
                'name' => 'password',
                'value' => set_value('password'),
                'class' => 'form-control m-input m-login__form-input--last',
                'required' => '',
            ),
            'confirm_password' => array(
                'placeholder' => 'Ulangi Password',
                'type' => 'password',
                'id' => 'confirm_password',
                'name' => 'confirm_password',
                'value' => set_value('confirm_password'),
                'class' => 'form-control m-input',
                'required' => '',
            ),
            'forgotten_password_code' => array(
                'placeholder' => 'Forgotten Password Code',
                'type' => 'hidden',
                'id' => 'forgotten_password_code',
                'name' => 'forgotten_password_code',
                'value' => set_value('forgotten_password_code'),
                'class' => 'form-control m-input',
                'required' => '',
            ),
        );
    }

    private function _set_session($user_id) {
        $user = $this->ion_auth->user()->row();
        $user_groups = $this->ion_auth->get_users_groups($user->id)->row();
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }
        $data = array(
            'username' => $user->username,
            'name' => $user->full_name,
            'email' => $user->email,
            'groupid' => $user_groups->id,
            'unitid' => $user->unit_id,
            'group_name' => $user_groups->name,
            'userid' => $user->id,
            'platform' => $this->agent->platform(),
            'browser' => $agent,
            'logged_in' => true,
            'log_tanggal' => $user->last_login,
        );
        $this->session->set_userdata($data);
    }

}
