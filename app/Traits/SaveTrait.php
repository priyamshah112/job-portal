<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;

trait SaveTrait
{

    public function save_job_fair_banner($file)
    {      
        $image = [];
        $image['img_name'] = uniqid() . time() . '.' . $file->getClientOriginalExtension();
        $filePath = 'public/job_fair';

        $path = $file->storeAs($filePath, $image['img_name']);
        $image['img_path'] = Storage::url($path);

        return $image;
    }

}