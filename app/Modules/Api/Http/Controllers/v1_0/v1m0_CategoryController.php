<?php

namespace App\Modules\Api\Http\Controllers\v1_0;

use App\Modules\Api\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;

class v1m0_CategoryController extends ApiController
{
    protected $category = [];
    protected $items = [];

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ('here!! - category 1.0');
    }

    public function getCategories()
    {
        $categories = $this->getCategoryModel()->getCategories();
        if (empty($categories)) {
            $this->return->addErrorMessage('NO_CATEGORIES_AVAILABLE');
            $this->return->setResultData([]);
            return $this->return->prepareResponse();
        }

        foreach ($categories as $category) {
            $this->addCategory($category);
        }

        $this->return->setSuccess(true);
        $this->return->addSuccessMessage('POI_REQUEST_SUCCESS');
        $this->return->setResultData($this->category);

        return $this->return->prepareResponse();
    }

    public function getCategoryById ($id)
    {
        $registry = $this->getCategoryModel()->getCategoryById($id);
        if (empty($registry)) {
            $this->return->setSuccess(false);
            $this->return->addErrorMessage('REQUESTED_CATEGORY_DOES_NOT_EXIST');
            $this->return->setResultData([]);
            return $this->return->prepareResponse();
        }

        $this->addCategory($registry);

        $this->return->setSuccess(true);
        $this->return->addSuccessMessage('CATEGORY_REQUEST_SUCCESS');
        $this->return->setResultData($this->category);

        return $this->return->prepareResponse();
    }

    protected function addCategory($registry)
    {
        if (empty($registry)) {
            return [];
        }

        $poiCategoryRow = $this->getPoiCategoryModel()->getPoiCategoriesByCategory($registry->description);

        $this->category[] = [
            'id' => $registry->id_categories,
            'item_url' => $this->getCategoryModel()->getItemUrl($registry->id_categories),
            'items' => [
                'redirect' => $this->addCategoryPois($poiCategoryRow)
            ],
            'description' => $registry->description
        ];
    }

    protected function addCategoryPois($poiCategoryRow)
    {
        $poiModel = $this->getPoiModel();

        foreach($poiCategoryRow as $poiCat) {
            try {
                $poi = $poiModel->getPoiById((int) $poiCat['fk_poi']);

                $poi = json_decode(json_encode($poi), true);

                $this->items[] = [
                    'id' => $poi['id_poi'],
                    'item_url' => $poiModel->getItemUrl($poi['id_poi'])
                ];
            } catch (Exception $e) {
                continue;
            }

        }

        return $this->items;
    }

}
