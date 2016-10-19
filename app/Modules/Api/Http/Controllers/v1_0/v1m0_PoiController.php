<?php

namespace App\Modules\Api\Http\Controllers\v1_0;

use App\Modules\Api\Http\Controllers\ApiController;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class v1m0_PoiController extends ApiController
{

    protected $poi = [];
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->getPois();
    }

    public function getPoisById ($id)
    {
        $registry = $this->getPoiModel()->getPoiById($id);
        if (empty($registry)) {
            $this->return->setSuccess(false);
            $this->return->addErrorMessage('REQUESTED_POI_DOES_NOT_EXIST');
            $this->return->setResultData([]);
            return $this->return->prepareResponse();
        }

        $this->addPoi($registry);

        $this->return->setSuccess(true);
        $this->return->addSuccessMessage('POI_REQUEST_SUCCESS');
        $this->return->setResultData($this->poi);

        return $this->return->prepareResponse();
    }

    public function getPois()
    {
        $pois = $this->getPoiModel()->getPois();
        if (empty($pois)) {
            $this->return->addErrorMessage('NO_POIS_AVAILABLE');
            $this->return->setResultData([]);
            return $this->return->prepareResponse();
        }

        foreach ($pois as $poi) {
            $this->addPoi($poi);
        }

        $this->return->setSuccess(true);
        $this->return->addSuccessMessage('POI_REQUEST_SUCCESS');
        $this->return->setResultData($this->poi);

        return $this->return->prepareResponse();
    }

    protected function addPoi($registry)
    {
        if (empty($registry)) {
            return [];
        }

        $this->poi[] = [
            'id' => $registry->id_poi,
            'item_url' => $this->getPoiModel()->getItemUrl($registry->id_poi),
            'title' => $registry->title,
            'description' => $this->getHtmlHelper()->stripHtmlTags($registry->description),
            'poi_url' => $registry->url
        ];
    }
}
