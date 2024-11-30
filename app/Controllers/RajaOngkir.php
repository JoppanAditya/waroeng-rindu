<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Exceptions\PageNotFoundException;

class RajaOngkir extends BaseController
{
    protected $api_key;
    protected $client;
    protected $options;

    public function __construct()
    {
        $this->api_key = getenv('RAJAONGKIR_API_KEY');
        $this->client = service('curlrequest');
        $this->options = [
            'headers' => [
                'key' => getenv('RAJAONGKIR_API_KEY')
            ],
            'verify' => false,
        ];
    }

    public function province()
    {
        if ($this->request->isAJAX()) {
            try {
                $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/province', $this->options);

                $statusCode = $response->getStatusCode();
                if ($statusCode === 200) {
                    $result = json_decode($response->getBody(), true);
                    return $this->response->setJSON(['data' => $result['rajaongkir']['results']]);
                }

                return $this->response->setJSON(['data' => [], 'error' => 'Unable to fetch provinces'], ResponseInterface::HTTP_BAD_REQUEST);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $parts = explode(': ', $message, 2);
                $errorText = isset($parts[1]) ? trim($parts[1]) : '';

                $errorText = preg_replace('/\s*:\s*\d+/', '', $errorText);
                throw new \Exception($errorText);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function city()
    {
        if ($this->request->isAJAX()) {
            try {
                $provinceId = $this->request->getGet('province_id');

                if ($provinceId) {
                    $this->options['query']['province'] = $provinceId;
                }

                $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/city', $this->options);

                $statusCode = $response->getStatusCode();
                if ($statusCode === 200) {
                    $result = json_decode($response->getBody(), true);
                    return $this->response->setJSON(['data' => $result['rajaongkir']['results']]);
                }

                return $this->response->setJSON(['data' => [], 'error' => 'Unable to fetch cities'], ResponseInterface::HTTP_BAD_REQUEST);
            } catch (\Exception $e) {
                $message = $e->getMessage();
                $parts = explode(': ', $message, 2);
                $errorText = isset($parts[1]) ? trim($parts[1]) : '';

                $errorText = preg_replace('/\s*:\s*\d+/', '', $errorText);
                throw new \Exception($errorText);
            }
        } else {
            throw new PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function cost()
    {
        $origin = 152;
        $destination = $this->request->getPost('destination');
        $weight = $this->request->getPost('weight');
        $courier = $this->request->getPost('courier');

        $this->options['headers'] = [
            'key' => $this->api_key,
            'content-type' => 'application/x-www-form-urlencoded'
        ];
        $this->options['form_params'] = [
            'origin' => $origin,
            'destination' => $destination,
            'weight' => $weight,
            'courier' => $courier
        ];

        $response = $this->client->request('POST', 'https://api.rajaongkir.com/starter/cost', $this->options);
        $result = json_decode($response->getBody(), true);
        $services = $result['rajaongkir']['results'][0]['costs'];

        if ($result && isset($services)) {
            return $this->response->setJSON([
                'success' => true,
                'services' => $services
            ]);
        } else {
            return $this->response->setJSON([
                'error' => true,
                'message' => 'Unable to fetch service.'
            ]);
        }
    }

    public function getProvinceName($provinceId)
    {
        try {
            $this->options['query']['id'] = $provinceId;
            $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/province', $this->options);

            $result = json_decode($response->getBody(), true);
            return $result['rajaongkir']['results']['province'] ?? 'Unknown Province';
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $parts = explode(': ', $message, 2);
            $errorText = isset($parts[1]) ? trim($parts[1]) : '';

            $errorText = preg_replace('/\s*:\s*\d+/', '', $errorText);
            throw new \Exception($errorText);
        }
    }

    public function getCityName($cityId, $provinceId)
    {
        try {
            $this->options['query'] = ['id' => $cityId, 'province' => $provinceId];
            $response = $this->client->request('GET', 'https://api.rajaongkir.com/starter/city', $this->options);

            $result = json_decode($response->getBody(), true);
            $cityName = $result['rajaongkir']['results']['city_name'] ?? 'Unknown City';
            $cityType = $result['rajaongkir']['results']['type'] ?? '';

            return trim("$cityType $cityName");
        } catch (\Exception $e) {
            $message = $e->getMessage();
            $parts = explode(': ', $message, 2);
            $errorText = isset($parts[1]) ? trim($parts[1]) : '';

            $errorText = preg_replace('/\s*:\s*\d+/', '', $errorText);
            throw new \Exception($errorText);
        }
    }
}
