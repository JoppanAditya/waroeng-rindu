<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminAdminController extends BaseController
{
    protected $validation;
    public function __construct()
    {
        $this->validation = \Config\Services::validation();
    }

    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title'         => 'Admin',
            'menuTitle'     => 'User',
            'user'          => $user,
        ];

        return view('dashboard/admin/index', $data);
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $allUsers = auth()->getProvider()->findAll();

            $users = array_filter($allUsers, function ($user) {
                return in_array('superadmin', $user->getGroups()) || in_array('admin', $user->getGroups()) || in_array('developer', $user->getGroups());
            });

            return $this->response->setJSON([
                'data' => view('dashboard/admin/data',  ['users' => $users]),
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $user = auth()->getProvider()->findById($id);

            return $this->response->setJSON([
                'success' => view('dashboard/admin/modal/detail',  ['user' => $user]),
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function addForm()
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'data' => view('dashboard/admin/modal/add'),
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function editForm()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $user = auth()->getProvider()->findById($id);

            return $this->response->setJSON([
                'success' => view('dashboard/admin/modal/edit',  ['user' => $user]),
            ]);
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function add()
    {
        if ($this->request->isAJAX()) {
            $validationResult = $this->_validate();

            if ($validationResult['error']) {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => $validationResult['message'],
                    'errors' => $validationResult['errors'],
                ]);
            } else {
                $fullname = $this->request->getPost('fullname');
                $username = $this->request->getPost('username');
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $mobile_number = $this->request->getPost('mobile_number');
                $gender = $this->request->getPost('gender');
                $file = $this->request->getFile('image');
                $imageName = null;
                if ($file && $file->isValid() && !$file->hasMoved()) {
                    $imageName = $file->getRandomName();
                    $file->move('assets/img/user', $imageName);
                } else {
                    $imageName = 'default.jpg';
                }

                $user = new User([
                    'fullname'      => $fullname,
                    'username'      => $username,
                    'email'         => $email,
                    'password'      => $password,
                    'mobile_number' => $mobile_number,
                    'gender'        => $gender,
                    'image'         => $imageName,
                ]);

                $users = auth()->getProvider();

                if ($users->save($user)) {
                    $userId = $users->getInsertID();
                    $newUser = $users->findById($userId);
                    $newUser->addGroup('admin');

                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Admin has been added successfully.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => true,
                        'message' => 'Failed to add admin.'
                    ]);
                }
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $users = auth()->getProvider();
            $user = $users->findById($id);

            $validationRules = [
                'id' => [
                    'rules' => 'required',
                ],
                'fullname' => [
                    'label' => 'Full Name',
                    'rules' => [
                        'required',
                        'max_length[50]',
                        'min_length[3]',
                    ],
                ],
                'username' => [
                    'label' => 'Auth.username',
                    'rules' => [
                        'required',
                        'max_length[30]',
                        'min_length[3]',
                        'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
                        'is_unique[users.username,id,{id}]',
                    ],
                ],
                'email' => [
                    'label' => 'Auth.email',
                    'rules' => [
                        'required',
                        'max_length[254]',
                        'valid_email',
                        'is_unique[auth_identities.secret,user_id,{id}]',
                    ],
                ],
                'mobile_number' => [
                    'label' => 'Mobile Number',
                    'rules' => [
                        'max_length[15]',
                        'min_length[10]',
                        'regex_match[/\A[0-9]+\z/]',
                        'is_unique[users.mobile_number,id,{id}]',
                    ],
                ],
                'gender' => [
                    'label' => 'Gender',
                    'rules' => [
                        'required',
                        'in_list[Male, Female]',
                    ],
                ],
                'password' => [
                    'label' => 'Auth.password',
                    'rules' => [
                        'permit_empty',
                        'max_byte[72]',
                        'strong_password[]',
                    ],
                    'errors' => [
                        'max_byte' => 'Auth.errorPasswordTooLongBytes'
                    ]
                ]
            ];

            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Please correct the errors in the form.',
                    'errors' => $this->validator->getErrors(),
                ]);
            } else {
                $fullname = $this->request->getPost('fullname');
                $username = $this->request->getPost('username');
                $email = $this->request->getPost('email');
                $password = $this->request->getPost('password');
                $mobile_number = $this->request->getPost('mobile_number');
                $gender = $this->request->getPost('gender');
                $image = $this->request->getFile('image');
                $existingImage = $user->image;

                if ($image->getError() == 4) {
                    $imageName = $existingImage;
                } else {
                    $newName = $image->getRandomName();
                    $image->move('assets/img/user', $newName);

                    if ($existingImage && $existingImage !== 'default.jpg' && file_exists('assets/img/user/' . $existingImage)) {
                        unlink('assets/img/user/' . $existingImage);
                    }

                    $imageName = $newName;
                }

                $user->fill([
                    'fullname'      => $fullname,
                    'username'      => $username,
                    'email'         => $email,
                    'password'      => $password,
                    'mobile_number' => $mobile_number,
                    'gender'        => $gender,
                    'image'         => $imageName,
                ]);

                if ($users->save($user)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'Admin has been updated successfully.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => true,
                        'message' => 'Failed to update admin.'
                    ]);
                }
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function updatePassword()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $users = auth()->getProvider();
            $user = $users->findById($id);
            $password = $this->request->getPost('password');

            $result = auth()->check([
                'email'    => auth()->user()->email,
                'password' => $password,
            ]);

            if (!$result->isOK()) {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'The current password is incorrect.',
                ]);
            }

            $validationRules = [
                'password' => [
                    'label' => 'Password',
                    'rules' => 'required'
                ],
                'newPassword' => [
                    'label' => 'New Password',
                    'rules' => [
                        'required',
                        'max_byte[72]',
                    ],
                    'errors' => [
                        'max_byte' => 'Auth.errorPasswordTooLongBytes'
                    ]
                ],
                'renewPassword' => [
                    'label' => 'New Password',
                    'rules' => [
                        'required',
                        'matches[newPassword]',
                    ],
                    'errors' => [
                        'matches' => 'This field does not match the New Password field.'
                    ]
                ]
            ];

            if (!$this->validate($validationRules)) {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Please correct the errors in the form.',
                    'errors' => $this->validator->getErrors(),
                ]);
            }
            $newPassword = $this->request->getPost('newPassword');

            $user->fill([
                'password'      => $newPassword,
            ]);

            if ($users->save($user)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Admin has been updated successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Failed to update admin.'
                ]);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $users = auth()->getProvider();
            $user = $users->findById($id);

            if ($user) {
                $imagePath = $user->image;

                if ($imagePath && $imagePath !== 'default.jpg' && file_exists('assets/img/user/' . $imagePath)) {
                    unlink('assets/img/user/' . $imagePath);
                }

                if ($users->delete($id, true)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Admin has been deleted successfully.']);
                } else {
                    return $this->response->setJSON(['error' => true, 'message' => 'Failed to delete admin.']);
                }
            } else {
                throw new PageNotFoundException('Sorry, we cannot access the requested page.');
            }
        } else {
            return $this->response->setJSON(['error' => true, 'message' => 'Failed to get user.']);
        }
    }

    private function _validate()
    {
        $this->validation->setRules(config('Validation')->registration);

        if (!$this->validation->withRequest($this->request)->run()) {
            return [
                'error' => true,
                'message' => 'Please correct the errors in the form.',
                'errors' => $this->validation->getErrors(),
            ];
        }

        return ['error' => false];
    }
}
