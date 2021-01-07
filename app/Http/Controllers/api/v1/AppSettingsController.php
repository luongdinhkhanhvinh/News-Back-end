<?php

namespace App\Http\Controllers\api\v1;

use App\Models\AppSettings;

class AppSettingsController extends BaseAPIController
{
    public static $APP_SETTINGS_DEFAULT_RECORD_ID = 1;

    public function index()
    {
        return $this->responseJSON(
            AppSettings::where('id', AppSettingsController::$APP_SETTINGS_DEFAULT_RECORD_ID)->first()
        );
    }
}
