<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
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
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {

            $id = $this->request->getPost('id');

            $validationResult = $this->_validate();

            if ($validationResult['error']) {
                return $this->response->setJSON([
                    'error' => true,
                    'errors' => $validationResult['errors'],
                ]);
            } else {
                $data = [
                    'name' => $this->request->getPost('name'),
                    'category_id' => $this->request->getPost('category'),
                    'description' => $this->request->getPost('description'),
                    'price' => $this->request->getPost('price'),
                ];

                $image = $this->request->getFile('image');

                $existingMenu = $this->menuModel->find($id);
                $existingImage = $existingMenu['image'];

                if ($image->getError() == 4) {
                    $data['image'] = $existingImage;
                } else {
                    $newName = $image->getRandomName();

                    $image->move('assets/img/menu', $newName);

                    if ($existingImage && $existingImage !== 'default.jpeg' && file_exists('assets/img/menu/' . $existingImage)) {
                        unlink('assets/img/menu/' . $existingImage);
                    }

                    $data['image'] = $newName;
                }

                if ($this->menuModel->update(['id' => $id], $data)) {
                    redirect('admin/menu')->with('success', 'Menu successfully updated.');
                    return $this->response->setJSON(['success' => true]);
                } else {
                    redirect('admin/menu')->with('error', 'Failed tp update Menu.');
                    return $this->response->setJSON(['error' => true]);
                }
            }
            echo json_encode($response);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
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
                throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
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
