<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use CodeIgniter\HTTP\ResponseInterface;

class AddressController extends BaseController
{
    protected $addressModel;

    public function __construct()
    {
        $this->addressModel = new AddressModel();
    }

    public function get()
    {
        if ($this->request->isAJAX()) {
            $address = $this->addressModel->getAddressDetail(user_id());

            return $this->response->setJSON([
                'data' => view('address/data', ['address' => $address,]),
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function dataModal()
    {
        if ($this->request->isAJAX()) {
            $address = $this->addressModel->getAddressDetail(user_id());

            return $this->response->setJSON([
                'data' => view('address/modal/dataModal', ['address' => $address])
            ]);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function addForm()
    {
        if ($this->request->isAJAX()) {
            $address = $this->addressModel->get(user_id());
            $user = auth()->user();

            $data = [
                'address' => $address,
                'user' => $user,
            ];

            return $this->response->setJSON([
                'data' => view('address/modal/add', $data)
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
            }

            $userId = $this->request->getPost('user_id');

            $userHasAddress = $this->addressModel->where('user_id', $userId)->countAllResults() > 0;

            $isDefault = $isSelected = $userHasAddress ? 0 : 1;

            $data = [
                'user_id' => $userId,
                'name' => $this->request->getPost('fullname'),
                'phone' => $this->request->getPost('phone'),
                'label' => $this->request->getPost('label'),
                'province' => $this->request->getPost('province'),
                'city' => $this->request->getPost('city'),
                'postal_code' => $this->request->getPost('postal_code'),
                'full_address' => $this->request->getPost('address'),
                'notes' => $this->request->getPost('notes'),
                'is_default' => $isDefault,
                'is_selected' => $isSelected
            ];

            if ($this->addressModel->insert($data)) {
                // return redirect()->back()->with('success', 'Address added successfully.');
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Address added successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Failed to add address.'
                ]);
            }
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function delete()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $deleted = $this->addressModel->delete($id);

            if ($deleted) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Address has been deleted successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Failed to delete address.'
                ]);
            }
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    private function _validate()
    {
        $validationRules = [
            'fullname' => 'required',
            'phone' => 'required',
            'label' => 'required',
            'province' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'address' => 'required',
            'notes' => 'permit_empty|max_length[45]',
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
