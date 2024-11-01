<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class AdminUserController extends BaseController
{
    public function __construct() {}

    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title'         => 'User',
            'menuTitle'     => 'User',
            'user'          => $user,
        ];

        return view('dashboard/user/index', $data);
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $allUsers = auth()->getProvider()->findAll();

            $users = array_filter($allUsers, function ($user) {
                return in_array('user', $user->getGroups()) || in_array('beta', $user->getGroups());
            });

            return $this->response->setJSON([
                'data' => view('dashboard/user/data',  ['users' => $users]),
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
                'success' => view('dashboard/user/modal/edit',  ['user' => $user]),
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
                'success' => view('dashboard/user/modal/detail',  ['user' => $user]),
            ]);
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
                'date_of_birth' => [
                    'label' => 'Date of Birth',
                    'rules' => [
                        'permit_empty',
                        'valid_date',
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
                $date_of_birth = $this->request->getPost('date_of_birth');
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
                    'date_of_birth' => $date_of_birth,
                    'gender'        => $gender,
                    'image'         => $imageName,
                ]);

                if ($users->save($user)) {
                    return $this->response->setJSON([
                        'success' => true,
                        'message' => 'User has been updated successfully.'
                    ]);
                } else {
                    return $this->response->setJSON([
                        'error' => true,
                        'message' => 'Failed to update user.'
                    ]);
                }
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
                    return $this->response->setJSON(['success' => true, 'message' => 'User has been deleted successfully.']);
                } else {
                    return $this->response->setJSON(['error' => true, 'message' => 'Failed to delete user.']);
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
        $validationRules = [
            'name'        => [
                'label' => 'menu name',
                'rules' => 'required|min_length[3]|max_length[255]'
            ],
            'category'    => 'required|integer',
            'slug'        => 'is_unique[menus.slug]|max_length[255]',
            'description' => 'permit_empty|max_length[500]',
            'price'       => 'required|decimal',
            'image'       => [
                'rules' => 'is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]|max_size[image,2048]',
                'errors' => [
                    'is_image' => 'The file you selected is not an image.',
                    'mime_in' => 'Only JPG, JPEG, and PNG files are allowed.',
                    'max_size' => 'The file size exceeds the limit of 2MB.',
                ],
            ],
        ];

        if (!$this->validate($validationRules)) {
            return [
                'error' => true,
                'errors' => $this->validator->getErrors(),
            ];
        }

        return ['error' => false];
    }
}
