<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\ModelUsers;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\Response;
use CodeIgniter\Validation\Validation;
use Config\Services;

class Users extends BaseController
{
    use ResponseTrait;

    private ModelUsers $model;
    private Validation $validation;

    function __construct()
    {
        $this->model = new ModelUsers();
        $this->validation = Services::validation();
    }

    public function index(): Response
    {
        $data = $this->model->get_user_list();
        $count = count($data);

        if ($count <= 0) {
            $data = [
                'status' => 201,
                'error' => null,
                'message' => [
                    'success' => 'Tidak ada data daftar pegawai'
                ],
            ];

        }
        return $this->respond($data, 200);

    }

    public function show($_id)
    {
        //$data = $this->model->get_user($_id);

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

    public function create(): Response
    {

        $name = $this->request->getVar('name');
        $email = $this->request->getVar('email');
        $status = $this->request->getVar('status');
        $password = $this->request->getVar('password');
        $confirm = $this->request->getVar('confirm');

        $data = [
            'name' => $name,
            'email' => $email,
            'status' => $status,
            'password' => $password,
            'confirm' => $confirm,
        ];

        //return $this->respond($data);

        if (!$this->validation->run($data, 'users_create')) {

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

        $data1 = [
            'name' => $name,
            'email' => $email,
            'status' => $status,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ];

        if (!$this->model->create_user($data1)){
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'error' => 'Data user tidak berhasil dimasukkan'
                ],
            ];

            return $this->respond($response, 200);
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil memasukkan data user'
            ],
        ];

        return $this->respond($response, 200);
    }

    public function update($_id): Response
    {

        $data1 = $this->request->getRawInput();

        if (!$this->validation->run($data1, 'users_update')) {

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

        $data1['_id'] = $_id;

        if (!$this->model->update_user($data1)){
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'error' => 'Data user tidak berhasil diubah'
                ],
            ];

            return $this->respond($response, 200);
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil mengubah data user'
            ],
        ];

        return $this->respond($response, 200);
    }

    public function delete($_id): Response
    {

        $data1 = $this->request->getRawInput();

        if (!$this->validation->run($data1, 'status')) {
        //if (!$this->validation->run($data1, 'password')) {

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

        $data1['_id'] = $_id;

        //return $this->respond($data1);

        if (!$this->model->delete_user($data1)){
            $response = [
                'status' => 201,
                'error' => null,
                'messages' => [
                    'error' => 'Data user tidak berhasil di nonaktifkan'
                ],
            ];

            return $this->respond($response, 200);
        }

        $response = [
            'status' => 201,
            'error' => null,
            'messages' => [
                'success' => 'Berhasil menonaktifkan data user'
            ],
        ];

        return $this->respond($response, 200);
    }
}