<?php

namespace App\Http\Controllers;

use App\categoryModel;
use App\poiCategoryModel;
use App\poiModel;
use Illuminate\Http\Request;
use App\Http\Requests;
use \Storage;
use Ddeboer\DataImport\Reader\CsvReader;

class PoiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return 'index';
    }

    public function editPoi()
    {
        return 'editPoi';
    }

    public function uploadCsv(Request $request)
    {
        if ($request->hasFile('file')) {
            try {
                $file = $request->file('file');
                $filename = $file->getClientOriginalName();
                $destinationPath = config('app.fileDestinationPath') . '/' . $filename;
                $uploaded = Storage::put($destinationPath, file_get_contents($file->getRealPath()));

                if ($uploaded) {
                    $path = resource_path('app') . '/' . $destinationPath;

                    $file = new \SplFileObject($path);
                    $reader = new CsvReader($file, ';');

                    $headerFlag = false;
                    $header = [];
                    $poi = [];
                    $poiModel = new poiModel();
                    $poiCategoryModel = new poiCategoryModel();
                    $categoriesModel = new categoryModel();
                    $categoryId = false;
                    $poiId = false;
                    foreach ($reader as $row) {
                        if (empty($headerFlag)) {
                            $header = $row;
                            $headerFlag = true;
                            continue;
                        }

                        foreach ($row as $key => $value) {
                            if ($key == 4) {
                                $categoryId = $categoriesModel->storeCategory(['description' => $value]);
                                continue;
                            }
                            $poi[$header[$key]] = $value;
                        }
                        $poiId = $poiModel->storePoi($poi);
                    }

                    if ($categoryId && $poiId) {
                        $poiCategoryModel->storePoiCategory($poiId, $categoryId);
                    }
                    return redirect()->to('poi/successpoi');
                }
            } catch (\Exception $e) {
                return redirect()->to('poi/errorpoi');
            }
        }
        return redirect()->to('poi/errorpoi');
    }

    public function addPoi(Request $request)
    {
        return view('files.pois');
    }

}
