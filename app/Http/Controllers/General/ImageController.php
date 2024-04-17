<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class ImageController extends Controller
{
    private string $uploadedPath;
    private string $mimeType;


    private function path($name): array
    {
        $year = date('Y');
        $month = date('m');

        if (!file_exists(storage_path('app/public/' . $year))) {
            mkdir(storage_path('app/public/' . $year), 0777, true);
        }

        if (!file_exists(storage_path('app/public/' . $year . '/' . $month))) {
            mkdir(storage_path('app/public/' . $year . '/' . $month), 0777, true);
        }

        return [
            'uploadTo' => storage_path('app/public/' . $year . '/' . $month . '/' . $name),
            'path' => asset('storage/' . $year . '/' . $month . '/' . $name),
        ];
    }

    public function upload(UploadedFile $image): self
    {

        $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '.webp';
        $path = self::path($name);

        $i = 2;
        while (file_exists($path['uploadTo'])) {
            $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME) . '-' . $i . '.webp';
            $path = self::path($name);
            $i++;
        }

        $encodedImage = Image::read($image->getRealPath())->toWebp();
        $encodedImage->save($path['uploadTo']);

        $this->uploadedPath = $path['path'];
        $this->mimeType = $encodedImage->mimetype();

        return $this;
    }

    public function uploadedPath(): string
    {
        return $this->uploadedPath;
    }

    public function mimeType(): string
    {
        return $this->mimeType;
    }
}
