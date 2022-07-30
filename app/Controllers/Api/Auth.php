<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelUsers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Validation\Validation;
use Config\Services;

class Auth extends BaseController
{
    use ResponseTrait;

    private ModelUsers $model;
    private Validation $validation;

    function __construct()
    {
        $this->model = new ModelUsers();
        $this->validation = Services::validation();
    }

    public function index()
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        $data1 = [
            'email' => $email,
            'password' => $password
        ];

        if (!$this->validation->run($data1, 'login')) {

            $errors = $this->validation->getErrors();

            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'errors' => [
                        $errors
                    ]
                ],
            ];

            return $this->respond($response);
        }

        $data1 = $this->model->get_email($email);
        //return $this->respond($data1, 200);

        if (!$data1) {
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'error' => 'Data user atau password tidak ada1'
                ],
            ];

            return $this->respond($response, 200);
        }

        $password_user = $data1->password;

        if (password_verify($password_hash, $password_user) != 0){
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'error' => 'Data user atau password tidak ada2'
                ],
            ];

            return $this->respond($response, 200);
        }

        helper('jwt');
        $response = [
            'message' => 'Auth berhasil dilakukan',
            'data' => $data1,
            'access_token' => createJWT($email)
        ];

        return $this->respond($response, 200);
    }

    public function show($_id)
    {
        if (!$data = $this->model->get_user($_id)) {
            $data = [
                'status' => 201,
                'error' => null,
                'message' => [
                    'success' => 'Tidak ada data pegawai'
                ],
            ];

        }

        return $this->respond($data, 200);
    }
}
