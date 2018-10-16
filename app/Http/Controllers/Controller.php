<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function success() {
        return response()->json(['success' => true]);
    }

    /**
     * Check if json correct or throw exception
     */
    protected function checkJson($string) {
        if($string == null) return;
        try {
            json_decode($string);
        } catch (\Exception $e) {
            throw new InvalidJsonException();
        }

        if(json_last_error() != JSON_ERROR_NONE) {
            throw new InvalidJsonException();
        }
    }
}
