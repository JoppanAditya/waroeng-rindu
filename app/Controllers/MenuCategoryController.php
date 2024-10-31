<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\CategoryModel;

class MenuCategoryController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        if (auth()->loggedIn()) {
            $user = auth()->user();
            $user->role = $user->getGroups()[0];
        }

        $data = [
            'title' => 'Category',
            'menuTitle' => 'Menu',
            'user'  => $user,
        ];

        return view('dashboard/category/index', $data);
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $category = $this->categoryModel->get();

            return $this->response->setJSON([
                'data' => view('dashboard/category/data', ['category' => $category]),
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function addForm()
    {
        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'data' => view('dashboard/category/modal/add'),
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function editForm()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $category = $this->categoryModel->find($id);

            return $this->response->setJSON([
                'success' => view('dashboard/category/modal/edit',  ['category' => $category]),
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
                $data = [
                    'name' => $this->request->getPost('name'),
                ];

                if ($this->categoryModel->insert($data)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'New category successfully added.']);
                } else {
                    return $this->response->setJSON(['error' => true, 'message' => 'Failed to add category.']);
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
                ];

                if ($this->categoryModel->update(['id' => $id], $data)) {
                    return $this->response->setJSON(['success' => true, 'message' => 'Category updated successfully.']);
                } else {
                    return $this->response->setJSON(['error' => true, 'message' => 'Failed to update category.']);
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

            if ($this->categoryModel->delete($id)) {
                return $this->response->setJSON(['success' => true, 'message' => 'Category deleted successfully.']);
            } else {
                return $this->response->setJSON(['error' => true, 'message' => 'Failed to delete category.']);
            }
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    private function _validate()
    {
        $validationRules = [
            'name'        => [
                'label' => 'category name',
                'rules' => 'required|min_length[3]|max_length[255]'
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
