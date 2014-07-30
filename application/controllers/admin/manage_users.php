<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Manage_users extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if(!in_array($this->session->userdata('role'), $this->config->item('manage_users'))) {
            redirect('/display_errors/authenticate_error', 'location');
        }
        $this->load->library('pagination');
        $this->load->model('model_manage_users');
    }

    public function index() {
        $this->view_users();
    }

    public function view_users($offset=0) {
        //display all users
        //config the pagination
        $config['base_url'] = base_url() . 'admin/manage_users/view_users/';
        //only "lbn" role can see the "lbn" users
        if ($this->session->userdata('role') === 'lbn') {
            $config['total_rows'] = $this->db->get_where('users', array('Status !='=>'D'))->num_rows();
        }else{
            $config['total_rows'] = $this->db->get_where('users',array('Role !='=>'lbn','Status !='=>'D'))->num_rows();
        }
        $config['uri_segment'] = 4;
        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        $data['pagination'] = output_pagination($config);

        $data['clients_list'] = $this->model_manage_users->find_all_users($offset, $config['per_page']); //return an array contains all clients' info

        output_views('admin/manage_users/view_manage_users', $data, 'dashboard');
    }

    public function create_user() {
        if (isset($_POST['create'])) {
            $this->load->library('form_validation');

            //rules of creating
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[100]|valid_email|is_unique[users.Email]|xss_clean');
            $this->form_validation->set_rules('nickname', 'lang:display_name', 'trim|required|max_length[16]|no_special_character|is_unique[user_meta.Nickname]|xss_clean');
            $this->form_validation->set_rules('name', 'lang:name', 'trim|max_length[40]|xss_clean');
            $this->form_validation->set_rules('password', 'lang:password', 'trim|required|min_length[6]|matches[passconf]|max_length[30]|xss_clean');
            $this->form_validation->set_rules('passconf', 'lang:passconf', 'trim|required|');
            $this->form_validation->set_rules('role', 'lang:role', 'trim|required|');
            $this->form_validation->set_rules('status', 'lang:status', 'trim|required|');

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to creation form and show errors
                output_views('admin/manage_users/view_create_user','', 'dashboard');
            } else {
                //inserted successful
                //return TRUE OR FALSE
                $result = $this->model_manage_users->create_new_user();
                if ($result) {
                    //updating succesfful
                    $this->session->set_flashdata('msg', '新用户创建成功！');
                    redirect('/admin/manage_users', 'location');
                } else {
                    $data['error'] = "创建失败";
                    output_views('admin/manage_users/view_create_user', $data, 'dashboard');
                }
            }
        } else {
            output_views('admin/manage_users/view_create_user','', 'dashboard');
        }
    }

    public function edit_user($user_id = '') {
        $client_info = $this->model_manage_users->find_user_by_id($user_id); //return an array contains all clients' info

        if (isset($_POST['update'])) {
            $this->load->library('form_validation');

            //rules of updating
            $this->form_validation->set_rules('email', 'lang:email', 'trim|required|max_length[100]|valid_email|is_existed[users.Email.'.$user_id .']|xss_clean');
            $this->form_validation->set_rules('nickname', 'lang:display_name', 'trim|required|max_length[16]|no_special_character|is_existed[user_meta.Nickname.'.$user_id .']|xss_clean');
            $this->form_validation->set_rules('name', 'lang:name', 'trim|max_length[40]|xss_clean');
            $this->form_validation->set_rules('role', 'lang:role', 'trim|required');
            $this->form_validation->set_rules('status', 'lang:status', 'trim|required');
            $this->form_validation->set_rules('city', 'lang:city', 'trim|max_length[20]|xss_clean');
            $this->form_validation->set_rules('phone', 'lang:phone', 'trim|max_length[20]|xss_clean');

            if ($this->form_validation->run() == FALSE) {
                //user didn't validate, send back to edit form and show errors
                output_views('admin/manage_users/view_edit_client', $client_info, 'dashboard');
            } else {
                //successful updated        
                $result = $this->model_manage_users->update_user();
                if ($result) {
                    switch ($result) {
                        case 'success':
                            $this->session->set_flashdata('msg', '信息更新成功！');
                            redirect('/admin/manage_users/edit_user/'.$user_id, 'refresh');
                            break;
                        case 'user_history_error':
                            $this->session->set_flashdata('error', '历史记录插入失败！');
                            redirect('/admin/manage_users/edit_user/'.$user_id, 'location');
                            break;
                        case 'user_meta_error':
                            $this->session->set_flashdata('error', 'UserMeta表插入失败！');
                            redirect('/admin/manage_users/edit_user/'.$user_id, 'location');
                            break;
                        default:
                            redirect('/admin/manage_users/edit_user/'.$user_id, 'location');
                            break;
                    }
                        
                } else {
                    $this->session->set_flashdata('error', '对不起，更新失败！！');
                    redirect('/admin/manage_users/edit_user/' . $user_id, 'location');
                }
            }// end of updating
        } else {
            output_views('admin/manage_users/view_edit_client', $client_info, 'dashboard');
        }
    }

    public function delete_user($user_id) {
        //result will return TRUE OR FALSE
        $result = $this->model_manage_users->delete_user($user_id);
        if ($result) {
            $this->session->set_flashdata('msg', 'Deleted!');
            redirect('/admin/manage_users', 'location');
        } else {
            $this->session->set_flashdata('msg', 'Deleted failed!');
            redirect('/admin/manage_users', 'location');
        }
    }
    
    public function deleted_users() {
        $data['clients_list'] = $this->model_manage_users->find_all_deleted_users(); //return an array contains all clients' info
        output_views('admin/manage_users/view_deleted_users', $data, 'dashboard');
    }
    
    public function restore_user($user_id) {
        $result = $this->model_manage_users->restore_user($user_id);
        if ($result) {
            $this->session->set_flashdata('msg', '还原成功！');
            redirect('/admin/manage_users/deleted_users', 'location');
        } else {
            $this->session->set_flashdata('error', '还原失败！');
            redirect('/admin/manage_users/deleted_users', 'location');
        }
    }
    
    public function perm_delete_user($user_id){
        $result = $this->model_manage_users->perm_delete_user($user_id);
        if ($result) {
            $this->session->set_flashdata('msg', '删除成功！');
            redirect('/admin/manage_users/deleted_users', 'location');
        } else {
            $this->session->set_flashdata('error', '删除失败！');
            redirect('/admin/manage_users/deleted_users', 'location');
        }
    }

    public function reset_password($user_id = NULL) {
        $check_user_id = $this->model_manage_users->check_user_id($user_id);
        if (isset($user_id) && !empty($user_id) && $check_user_id) {
            $this->load->helper('string'); //load the string helper to use the random_string method
            $new_pwd = random_string('alnum', 8); //generate a random string
            //save the new password into database,it will return 
            $client_email = $this->model_manage_users->update_password($user_id, $new_pwd);
            if ($client_email) {
                //updated successful
                $data['client_email'] = $client_email;
                $data['client_password'] = $new_pwd;
                output_views('admin/manage_users/view_reset_password', $data, 'dashboard');
            } else {
                //updated failed
                $this->session->set_flashdata('error', '密码更新失败！请重试！');
                redirect('/admin/manage_users/edit_user/' . $user_id, 'location');
//                output_views('admin/manage_users/view_reset_password', array('error' => '密码更新失败！请重试'), 'dashboard');
            }
        } else {
            //there is no valid user id 
            $this->session->set_flashdata('error', '用户不存在！');
            redirect('/admin/manage_users/edit_user/' . $user_id, 'location');
        }
    }

    public function search_users() {
        if (isset($_POST['search'])) {
            //search users then return the results
            $users_list = $this->model_manage_users->retrieve_users();
            $data['users_list'] = $users_list;
            if ($users_list) {
                output_views('admin/manage_users/view_search_users', $data, 'dashboard');
            } else {
                output_views('admin/manage_users/view_search_users', array('message' => 'There is no result.'), 'dashboard');
            }
        }
    }
    
    /*
     * 4.13 wei fang
     * Manage verifying users
     */

    public function show_verify_users($status = NULL, $offset = 0) {
        $config['base_url'] = base_url() . 'admin/manage_users/show_verify_users/';
        if ($status) {
            $config['total_rows'] = $this->db->get_where('verify', array('VerifyStatus' => $status))->num_rows();
        } else {
            $config['total_rows'] = $this->db->get_where('verify')->num_rows();
        }
        $config['uri_segment'] = 4;
        $config['per_page'] = 10;
        $this->pagination->initialize($config);
        $data['pagination'] = output_pagination($config);
        $data['clients_list'] = $this->model_manage_users->find_verify_users_by_status($status, $offset, $config['per_page']);
        output_views('admin/manage_users/view_show_verify_users', $data, 'dashboard');
    }

    public function verify_user($user_id) {
        $verify_info = $this->model_manage_users->find_verify_user_by_id($user_id);
        if ($verify_info[0]['VerifyStatus'] === 'N') {
            $this->model_manage_users->process_verify($user_id);
        }
//        var_dump($verify_info[0]);
        if (isset($_POST['verify'])) {
                $result = $this->model_manage_users->verify_user();
                if ($result) {
                    $this->session->set_flashdata('msg', '用户验证官方帐户成功！');
                    redirect('/admin/manage_users/verify_user/' . $user_id, 'refresh');
                } else {
                    $this->session->set_flashdata('error', '用户验证官方帐户未成功！！请联系管理员');
                    redirect('/admin/manage_users/verify_user/' . $user_id, 'refresh');
            }
        } else if (isset($_POST['reject'])) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('feedback', '申请', 'trim|max_length[500]|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                output_views('admin/manage_users/view_verify_user', $verify_info[0], 'my_account');
            } else {
                $result = $this->model_manage_users->reject_user();
                if ($result) {
                    $this->session->set_flashdata('msg', '用户验证官方帐户不成功，反馈已经发出！');
                    redirect('/admin/manage_users/verify_user/' . $user_id, 'refresh');
                } else {
                    $this->session->set_flashdata('error', '系统错误，请联系管理员');
                    redirect('/admin/manage_users/verify_user/' . $user_id, 'refresh');
                }
            }
        } else {
            output_views('admin/manage_users/view_verify_user', $verify_info[0], 'dashboard');
        }
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */