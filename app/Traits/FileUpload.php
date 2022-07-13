<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Image;
use Illuminate\Support\Facades\DB;


trait FileUpload{

    public function saveImage($files, $filePath, $prefix, $model)
    {
        if(is_array($files))
        {
            foreach ($files as $key => $file)
            {
                $fileName       =   $prefix.Carbon::now()->timestamp.'-'.$key.'.'.$file->extension();
                $this->storeImage($model, $filePath, $fileName);
                $file->storeAs($filePath, $fileName, 'public');
            }
            return true;
        }
        $fileName   =   $prefix.Carbon::now()->timestamp.'.'.$files->extension();
        $this->storeImage($model, $filePath, $fileName);
        $files->storeAs($filePath, $fileName, 'public');
    }

    public function storeImage($model, $filePath, $fileName)
    {
        $image          = new Image;
        $image->file    = 'storage/'.$filePath.'/'.$fileName;
        $model->images()->save($image);
    }
}
