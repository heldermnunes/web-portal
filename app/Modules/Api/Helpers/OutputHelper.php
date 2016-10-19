<?php

namespace App\Modules\Api;

use Illuminate\Http\Request;


class OutputHelper
{

    /** @var array */
    protected $header = [];

    /** @var array */
    protected $data = [];


    public function getHeader()
    {
        if (empty($this->header)) {
            $this->header = [
                'XSRF-TOKEN' => $_COOKIE['XSRF-TOKEN'],
                'laravel_session' => $_COOKIE['laravel_session'],
                'request_url' =>  'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'],
                'request_method' => $_SERVER['REQUEST_METHOD']
            ];
        }

        return $this->header;
    }

    public function setData(array $data)
    {
        $this->data = $data;
    }

    public function prepareResponse()
    {
        $response = [
            $this->getHeader(),
            $this->data
        ];
        return json_encode($this);
    }
}

