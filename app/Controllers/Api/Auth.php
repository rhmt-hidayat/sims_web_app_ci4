<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\UserModel;
use Codeigniter\API\ResponseTrait;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends BaseController
{
    use ResponseTrait;
    public function index()
    {
        //
    }

    public function login_1() //cara 1
    {
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $UserModel = new UserModel();
        $User = $UserModel->where('email', $email)->first();
        if (!$User) {
            return $this->respond([
                'status' => false,
                'message' => 'Email tidak ditemukan',
            ], 401);
        }

        if (!password_verify($password, $User['password'])) {
            return $this->respond([
                'status' => false,
                'message' => 'Password salah',
            ], 401);
        }

        //setting JWT
        $key = getenv('JWT_KEY');
        $iat = time(); //issu at
        $exp = $iat + (60 * 60); //expired token 1 jam
        $payload = [
            'iss' => 'sims_web_app_ci4',
            'sub' => 'logintoken',
            'iat' => $iat,
            'exp' => $exp,
            'uid' => $User['id'],
            'email' => $User['email'],
        ];

        $token = JWT::encode($payload, $key, 'HS256');
        $response = [
            'status' => true,
            'message' => 'Login Berhasil',
            'token' => $token,
        ];

        return $this->respond($response, 200);
    }

    public function login() //cara 2
    {
        $model = new UserModel();
        $email = $this->request->getVar('email');
        $password = $this->request->getVar('password');
        $data = $model->where('email', $email)->first();
        if ($data) {
            if (password_verify($password, $data['password'])) {
                // $dotenv = \Dotenv\Dotenv::createImmutable(ROOTPATH);
                // $dotenv->load();
                $key = getenv('JWT_KEY');
                $iat = time(); //issu at
                $exp = $iat + (60 * 60); //expired token 1 jam
                $payload = [
                    'iss' => 'sims_web_app_ci4',
                    'sub' => 'logintoken',
                    'iat' => $iat,
                    'exp' => $exp,
                    "id" => $data['id'],
                    "nama" => $data['nama'],
                    "email" => $data['email'],
                    "posisi" => $data['posisi'],
                    "isLoggedIn" => true,
                ];
                $token = JWT::encode($payload, $key, 'HS256');
                $response = [
                    'status' => 200,
                    'message' => 'Login Berhasil',
                    'token' => $token,
                ];
                return $this->respond($response, ResponseInterface::HTTP_OK);
            } else {
                $response = [
                    'status' => 401,
                    'error' => 'Wrong Password',
                    'data' => null,
                ];
                return $this->respond($response, ResponseInterface::HTTP_UNAUTHORIZED);
            }
        } else {
            $response = [
                'status' => 401,
                'error' => 'Email not found',
                'data' => null,
            ];
            return $this->respond($response, ResponseInterface::HTTP_UNAUTHORIZED);
        }
    }

    public function register()
    {
        $rules = [
            'email' => [
                'rules' => 'required|valid_email|is_unique[user.email]',
            ],
            'password' => [
                'rules' => 'required|min_length[6]',
            ],
            'confirm_password' => [
                'rules' => 'required|matches[password]',
            ],
            'posisi' => [
                'rules' => 'required',
            ],
        ];

        if ($this->validate($rules)) {
            $model = new UserModel();
            $data = [
                'nama' => $this->request->getVar('nama'),
                'email' => $this->request->getVar('email'),
                'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
                'posisi' => $this->request->getVar('posisi'),
            ];
            $model->save($data);
            $response = [
                'status' => 200,
                'message' => 'Register Berhasil',
                'data' => $data,
            ];
            return $this->respond($response, ResponseInterface::HTTP_OK);
        } else {
            $response = [
                'status' => false,
                'error' => $this->validator->getErrors(),
                'message' => 'Register Gagal'
            ];
            // return $this->respond($response, ResponseInterface::HTTP_BAD_REQUEST);
            return $this->respond($response, 422);
        }
    }
}
