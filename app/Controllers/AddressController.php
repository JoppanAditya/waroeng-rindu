<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AddressModel;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

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
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
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
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
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
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function editForm()
    {
        if ($this->request->isAJAX()) {
            $addressId = $this->request->getPost('addressId');
            $address = $this->addressModel->where('id', $addressId)->first();
            $provincesData = $this->_getProvinces();
            $provinces = $provincesData['rajaongkir']['results'];
            $citiesData = $this->_getCities($address['province']);
            $cities = $citiesData['rajaongkir']['results'];

            $data = [
                'address' => $address,
                'provinces' => $provinces,
                'cities' => $cities,
            ];

            return $this->response->setJSON([
                'data' => view('address/modal/edit', $data),
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
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function update()
    {
        if ($this->request->isAJAX()) {
            $addressId = $this->request->getPost('address_id');

            $validationResult = $this->_validate();

            if ($validationResult['error']) {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => $validationResult['message'],
                    'errors' => $validationResult['errors'],
                ]);
            }

            $data = [
                'name' => $this->request->getPost('fullname'),
                'phone' => $this->request->getPost('phone'),
                'label' => $this->request->getPost('label'),
                'province' => $this->request->getPost('province'),
                'city' => $this->request->getPost('city'),
                'postal_code' => $this->request->getPost('postal_code'),
                'full_address' => $this->request->getPost('address'),
                'notes' => $this->request->getPost('notes')
            ];

            if ($this->addressModel->update($addressId, $data)) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Address updated successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Failed to update address.'
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
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function updateSelected()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $userId = $this->request->getPost('user_id');
            $this->addressModel->resetSelected($userId);

            $selected = $this->addressModel->setSelected($id, $userId);
            if ($selected) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Address selected successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Failed to select address.'
                ]);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function updatePrimary()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $userId = $this->request->getPost('user_id');
            $this->addressModel->resetSelected($userId);
            $this->addressModel->setSelected($id, $userId);
            $this->addressModel->resetPrimary($userId);

            $selected = $this->addressModel->setPrimary($id, $userId);
            if ($selected) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Selected address has been set to primary address successfully.'
                ]);
            } else {
                return $this->response->setJSON([
                    'error' => true,
                    'message' => 'Failed to set selected address to primary address.'
                ]);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
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

    private function _getProvinces()
    {
        try {
            $client = service('curlrequest');
            $response = $client->request('GET', 'https://api.rajaongkir.com/starter/province', [
                'headers' => [
                    'key' => getenv('RAJAONGKIR_API_KEY'),
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $parts = explode(': ', $message, 2);
            $errorText = isset($parts[1]) ? trim($parts[1]) : '';

            $errorText = preg_replace('/\s*:\s*\d+/', '', $errorText);
            throw new PageNotFoundException($errorText);
        }
    }

    private function _getCities($provinceId)
    {
        try {
            $client = service('curlrequest');
            $response = $client->request('GET', 'https://api.rajaongkir.com/starter/city', [
                'headers' => [
                    'key' => getenv('RAJAONGKIR_API_KEY'),
                ],
                'query' => [
                    'province' => $provinceId,
                ],
            ]);

            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $parts = explode(': ', $message, 2);
            $errorText = isset($parts[1]) ? trim($parts[1]) : '';

            $errorText = preg_replace('/\s*:\s*\d+/', '', $errorText);
            throw new PageNotFoundException($errorText);
        }
    }
}
