<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\MenuModel;
use App\Models\CategoryModel;

class MenuController extends BaseController
{
    protected $menuModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->menuModel = new MenuModel();
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {

        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title'         => 'Menu',
            'menuTitle'     => 'Menu',
            'categories'    => $this->categoryModel->get(),
            'user'          => $user,
        ];

        return view('dashboard/menu/index', $data);
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $data = [
                'menus'         => $this->menuModel->get(false, 0, true),
                'categories'    => $this->categoryModel->get(),
            ];

            return $this->response->setJSON([
                'data' => view('dashboard/menu/data', $data)
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function addForm()
    {
        if ($this->request->isAJAX()) {
            $categories = $this->categoryModel->get();

            return $this->response->setJSON([
                'data' => view('dashboard/menu/modal/add', ['categories' => $categories])
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function editForm()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $menu = $this->menuModel->find($id);
            $categories = $this->categoryModel->get();
            $data = [
                'menu'          => $menu,
                'categories'    => $categories,
            ];

            return $this->response->setJSON([
                'success' => view('dashboard/menu/modal/edit', $data),
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function detail()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $menu = $this->menuModel->find($id);

            return $this->response->setJSON([
                'success' => view('dashboard/menu/modal/detail', ['menu' => $menu,]),
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
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
                $name = $this->request->getPost('name');
                $slug = $this->request->getPost('slug');

                if (empty($slug)) {
                    $slug = url_title($name, '-', true);
                }

                $data = [
                    'name'        => $name,
                    'slug'        => $slug,
                    'category_id' => $this->request->getPost('category'),
                    'description' => $this->request->getPost('description'),
                    'price' => $this->request->getPost('price'),
                ];

                $image = $this->request->getFile('image');
                if ($image && $image->isValid() && !$image->hasMoved()) {
                    $newName = $image->getRandomName();
                    $image->move('assets/img/menu', $newName);
                    $data['image'] = $newName;
                } else {
                    $data['image'] = 'default.jpeg';
                }

                if ($this->menuModel->insert($data)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Menu has been added successfully.']);
                } else {
                    return $this->response->setJSON(['error' => true, 'message' => 'Failed to add Menu.']);
                }
            }
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
                    'message' => $validationResult['message'],
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
                    return $this->response->setJSON(['success' => true, 'message' => 'Menu has been updated successfully.']);
                } else {
                    return $this->response->setJSON(['error' => true, 'message' => 'Failed tp update menu.']);
                }
            }
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $menuItem = $this->menuModel->find($id);

            if ($menuItem) {
                $imagePath = $menuItem['image'];

                if ($imagePath && $imagePath !== 'default.jpeg' && file_exists('assets/img/menu/' . $imagePath)) {
                    unlink('assets/img/menu/' . $imagePath);
                }

                if ($this->menuModel->delete($id)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Menu has been deleted successfully.']);
                } else {
                    return $this->response->setJSON(['error' => true, 'message' => 'Failed to delete menu.']);
                }
            } else {
                return $this->response->setJSON(['error' => true, 'message' => 'Failed to get item.']);
            }
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
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
                'message' => 'Please correct the errors in the form.',
                'errors' => $this->validator->getErrors(),
            ];
        }

        return ['error' => false];
    }
}
