<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class RajaOngkir extends BaseController
{
    private $api_key;
    protected $client;
    protected $url;
    protected $options;

    public function __construct()
    {
        $api_key = getenv('RAJAONGKIR_API_KEY');
        $this->client = service('curlrequest');
        $this->url = 'https://api.rajaongkir.com/starter/';
        $this->options = [
            'headers' => [
                'key' => $api_key
            ],
            'verify' => false,
            'query' => []
        ];
    }

    public function province()
    {
        if ($this->request->isAJAX()) {
            $url = $this->url . 'province';
            $response = $this->client->request('GET', $url, $this->options);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $result = json_decode($response->getBody(), true);
                return $this->response->setJSON(['data' => $result['rajaongkir']['results']]);
            }

            return $this->response->setJSON(['data' => [], 'error' => 'Unable to fetch provinces'], ResponseInterface::HTTP_BAD_REQUEST);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function city()
    {
        if ($this->request->isAJAX()) {
            $provinceId = $this->request->getGet('province_id');

            $url = $this->url . 'city';
            if ($provinceId) {
                $this->options['query']['province'] = $provinceId;
            }

            $response = $this->client->request('GET', $url, $this->options);

            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                $result = json_decode($response->getBody(), true);
                return $this->response->setJSON(['data' => $result['rajaongkir']['results']]);
            }

            return $this->response->setJSON(['data' => [], 'error' => 'Unable to fetch cities'], ResponseInterface::HTTP_BAD_REQUEST);
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Sorry, we cannot access the requested page.');
        }
    }

    public function getProvinceName($provinceId)
    {
        $url = $this->url . 'province';
        $this->options['query']['id'] = $provinceId;
        $response = $this->client->request('GET', $url, $this->options);

        $result = json_decode($response->getBody(), true);
        return $result['rajaongkir']['results']['province'] ?? 'Unknown Province';
    }

    public function getCityName($cityId, $provinceId)
    {
        $url = $this->url . 'city';
        $this->options['query'] = ['id' => $cityId, 'province' => $provinceId];
        $response = $this->client->request('GET', $url, $this->options);

        $result = json_decode($response->getBody(), true);
        return $result['rajaongkir']['results']['city_name'] ?? 'Unknown City';
    }
}
