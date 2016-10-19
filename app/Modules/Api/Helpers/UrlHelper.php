<?php

namespace App\Modules\Api;

use Illuminate\Http\Request;


class UrlHelper
{
    public function mapRequest(Request $request)
    {
        $uri = $request->segments();
        unset($uri[0]);

        if (!empty($uri[1])) {
            $versionFolder = str_replace('.', '_', $uri[1]);

            $versionArray = [
                'encoded' => $uri[1],
                'versionFolder' => $versionFolder
            ];
            session()->set('version', $versionArray);

        }

    }
}

