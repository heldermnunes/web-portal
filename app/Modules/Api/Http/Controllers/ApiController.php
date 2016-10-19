<?php

namespace App\Modules\Api\Http\Controllers;

use App\Modules\Api\Components\Service\Service_Response;
use App\Modules\Api\Models\v1_0\v1m0_categoryModel;
use App\Modules\Api\Models\v1_0\v1m0_poiCategoryModel;
use App\Modules\Api\UrlHelper;
use App\Modules\Api\Helpers\HtmlHelper;
//use App\Modules\Api\Helpers\OutputHelper;
use App\Modules\Api\Models\v1_0\v1m0_poiModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Modules\Api\Components\Service\Response;

class ApiController extends Controller
{
    /** @var Service_Response  */
    public $return = null;

    /** @var HtmlHelper  */
    public $htmlHelper = null;

    /** @var poiModel  */
    public $poiModel = null;

    /** @var categoryModel  */
    public $categoryModel = null;

    /** @var poiCategoryModel  */
    public $poiCategoryModel = null;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        (new UrlHelper())->mapRequest($request);
        $this->middleware('auth');
        $this->return = new Service_Response();
    }

    protected function getHtmlHelper ()
    {
        if (empty($this->htmlHelper)) {
            $this->htmlHelper = new HtmlHelper();
        }

        return $this->htmlHelper;
    }

    protected function getPoiModel ()
    {
        if (empty($this->poiModel)) {
            $this->poiModel = new v1m0_poiModel();
        }

        return $this->poiModel;
    }

    protected function getCategoryModel ()
    {
        if (empty($this->categoryModel)) {
            $this->categoryModel = new v1m0_categoryModel();
        }

        return $this->categoryModel;
    }

    protected function getPoiCategoryModel ()
    {
        if (empty($this->poiCategoryModel)) {
            $this->poiCategoryModel = new v1m0_poiCategoryModel();
        }

        return $this->poiCategoryModel;
    }

}
