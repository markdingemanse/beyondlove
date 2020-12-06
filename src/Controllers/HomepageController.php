<?php

namespace MarkDingemanse\Beyondlove\Controllers;

use App\Http\Controllers\Controller;
use MarkDingemanse\Beyondlove\Jobs\Homepage\RssCheckJob;
use MarkDingemanse\Beyondlove\Services\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class HomepageController extends Controller
{
    protected $image;

    public function __construct()
    {
        $this->image = new Image;
    }

    /**
    * Handles the pre launch tasks
    */
    public function launch()
    {
        $this->dispatch((new RssCheckJob)->onQueue('homepage'));

        return view('index');
    }

    /** Return view to upload file */
    public function uploadFileview(Request $request)
    {
        $pw = env("UPLOAD_PW");
        $submitted = (string) $request->input('waifu');

        return ($submitted === $pw)?
            view('upload.file_upload'):
            view('index');
    }


    /** Example of File Upload */
    public function uploadFile(Request $request){
        $pw = env("UPLOAD_PW");
        $submitted = (string) $request->input('waifu');

        if ($submitted === $pw) {
            $request->validate([
                'file' => 'required|file',
            ]);

            $fileName = "bgn".time().'.'.request()->file->getClientOriginalExtension();

            $request->file->storeAs('img', $fileName, 'img');

            return redirect()->route('upload_background_view',['waifu' => $submitted]);
        }

        return view('index');
    }

    public function getRandomFile()
    {
        $path  = $this->image->getPublicPath();
        $files = $this->image->blacklistFiles(collect(scandir($path)));
        $file  = $this->image->recursiveRadomSelection($files);

        return $file;
    }
}
