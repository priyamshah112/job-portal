<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
 */

trait PhotoSave
{

    public function savePhoto($request, $folder, $fileLocation)
    {
        $input['image_name'] = $strFileName = uniqid() . time() .'.' . $request->image_name->getClientOriginalExtension();
    

        $filePath = $folder;
        $path = $request->image_name->storeAs($filePath, $strFileName);
        Storage::url($path);
        $input['img_path'] = $request->getSchemeAndHttpHost() . $fileLocation . $strFileName;

        return $input;
    }

}