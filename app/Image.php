<?php

namespace App;

use Guzzle\Http\Client;
use Illuminate\Database\Eloquent\Model;
use League\Flysystem\Exception;
use Intervention\Image\Facades\Image as Img;

class Image extends Model
{
    protected $fillable = [
        'path'
    ];

    public function formAction($input)
    {
        if(isset($input['image']))
        {
            $input['image_id'] = $this->uploadFile($input['image']);
        }
        elseif(isset($input['uploaded_image_id']))
        {
            $input['image_id'] = $input['uploaded_image_id'];
        }
        else
        {
            $input['image_id'] = NULL;
        }

        return $input;
    }

    public function formActionRoute($input, $imageSize = NULL, $miniatureSize = NULL)
    {
        if(isset($input['image']))
        {
            if( $miniatureSize && is_array($miniatureSize) && $imageSize && is_array($imageSize) )
            {
                $result = $this->uploadFileWithResizeAndMiniature($input['image'], $imageSize, $miniatureSize);
                $input['image_id'] = $result['image_id'];
                $input['miniature_id'] = $result['miniature_id'];
            }
            else
            {
                $input['image_id'] = $this->uploadFile($input['image']);
            }
        }
        elseif(isset($input['uploaded_image_id']))
        {
            $input['image_id'] = $input['uploaded_image_id'];
        }
        else
        {
            $input['image_id'] = NULL;
        }

        return $input;
    }

    public function formActionPoint($input)
    {
        if(isset($input['btw_image']))
        {
            //dd('btw');
            //$input['image'] = $input['uploaded_image'];
            $input['image_id'] = $this->uploadFileWithResize($input['btw_image'], 1062);
            //dd($input);
        }
        elseif(isset($input['uploaded_btw_image_id']))
        {
            $input['image_id'] = $input['uploaded_btw_image_id'];
        }
        else
        {
            $input['image_id'] = 0;
        }

        if(isset($input['question_image']))
        {
            //dd('question');
            //$input['image'] = $input['uploaded_image'];
            $input['question_image_id'] = $this->uploadFileWithResize($input['question_image'], 1062);
        }
        elseif(isset($input['uploaded_question_image_id']))
        {
            $input['question_image_id'] = $input['uploaded_question_image_id'];
        }
        else
        {
            $input['question_image_id'] = 0 ;
        }

        return $input;
    }

    /**
     * Action for save file for landing page
     *
     * @param $input
     * @return mixed
     */
    public function formActionLanding($input)
    {
        // Logo
        if(isset($input['logo_image']))
        {
            $input['logo_image_id'] = $this->uploadFileWithResize($input['logo_image'], 1062);
        }
        elseif(isset($input['uploaded_logo_image_id']))
        {
            $input['logo_image_id'] = $input['uploaded_logo_image_id'];
        }
        else
        {
            $input['logo_image_id'] = 0;
        }

        // Main image
        if(isset($input['main_image']))
        {
            $input['main_image_id'] = $this->uploadFileWithResize($input['main_image'], 1062);
        }
        elseif(isset($input['uploaded_main_image_id']))
        {
            $input['main_image_id'] = $input['uploaded_main_image_id'];
        }
        else
        {
            $input['main_image_id'] = 0 ;
        }

        // Background image
        if(isset($input['background_image']))
        {
            $input['background_image_id'] = $this->uploadFile($input['background_image']);
        }
        elseif(isset($input['uploaded_background_image_id']))
        {
            $input['background_image_id'] = $input['uploaded_background_image_id'];
        }
        else
        {
            $input['background_image_id'] = 0 ;
        }

        return $input;
    }

    /**
     * Upload file and save to DB
     *
     * @param $file
     * @return mixed (Image ID in DB)
     */
    private function uploadFile($file)
    {
        $path = $this->_upload($file);
        $fm = new Image(['path' => $path]);
        $fm->save();
        return $fm->id;
    }

    private function uploadFileWithResizeAndMiniature($file, $imageSize, $miniatureSize)
    {
        $path = $this->_upload($file);

        // Resize Image
        $relativePath = ltrim($path, '/');
        $img = Img::make($relativePath)
            ->resize($imageSize['width'], $imageSize['height'], function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($relativePath);

        // Create Miniature
        /////
        // New file name
        $imagePath = 'images/uploads/';
        $info = pathinfo($relativePath);
        $extension = $info['extension'];
        $bodyF = basename($relativePath, '.' . $info['extension']);
        $tail = '_' . $miniatureSize['width'] . 'x' . $miniatureSize['height'];
        $newFile = $bodyF . $tail . '.' . $extension;
        $miniatureRelativePath = $imagePath . $newFile;

        // New file
        $img = Img::make($relativePath)
            ->resize($miniatureSize['width'], $miniatureSize['height'], function ($constraint) {
                $constraint->aspectRatio();
            });

        $miniatureWidth  =  $width = $img->width();
        $miniatureHeight = $height = $img->height();

        if($height < $miniatureSize['height']) {
            $miniatureHeight = $miniatureSize['height'];
            $miniatureWidth = NULL;
        }
        if($width < $miniatureSize['width']) {
            $miniatureHeight = NULL;
            $miniatureWidth = $miniatureSize['width'];
        }

        // New file again with bigger side
        $img = Img::make($relativePath)
            ->resize($miniatureWidth, $miniatureHeight, function ($constraint) {
                $constraint->aspectRatio();
            })->save($miniatureRelativePath);

        // Again with center image and right sides
        $img = Img::make($miniatureRelativePath)
            ->resizeCanvas($miniatureSize['width'], $miniatureSize['height'], 'center')
            ->save($miniatureRelativePath);

        // Save to DB
        $fm = new Image(['path' => $path]);
        $fm->save();

        $fm_miniature = new Image(['path' => '/' . $miniatureRelativePath]);
        $fm_miniature->save();

        // Output
        return [
            'image_id'      => $fm->id,
            'miniature_id'  => $fm_miniature->id
        ];
    }

    /**
     * Core function for upload file
     *
     * @param $file
     * @return string:  Path to file
     */
    private function _upload($file)
    {
        $f = $file->getClientOriginalName();
        $imagePath = '/images/uploads/';
        $f = $this->renameExistFile($imagePath, $f);
        $path = $imagePath . $f;
        $file->move(public_path($imagePath), $f);
        return $path;
    }

    /**
     * Upload, resize then save Image to DB
     *
     * @param $file
     * @param null $width
     * @param null $height
     * @return mixed (Image ID in DB)
     */
    private function uploadFileWithResize($file, $width = NULL, $height = NULL)
    {
        $path = $this->_upload($file);

        // Resize
        $relativePath = ltrim($path, '/');
        $img = Img::make($relativePath)
            ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($relativePath);

        $fm = new Image(['path' => $path]);
        $fm->save();
        return $fm->id;
    }

    /**
     * Rename existing file to file_name(1).extension
     *
     * @param $imagePath
     * @param $f
     * @return string (path to file)
     */
    private function renameExistFile($imagePath, $f)
    {
        $path = $imagePath . $f;

        $info = pathinfo($f);
        $extension = $info['extension'];
        $bodyF = basename($f, '.' . $info['extension']);

        for($i = 1 ; $i < 200 && file_exists($_SERVER['DOCUMENT_ROOT']  . $path); $i++)
        {
            $newFile = $bodyF . '(' . $i . ').' . $extension;
            $newPath = $imagePath . $newFile;
            $path = $newPath;
            $f = $newFile;
        }

        return $f;
    }

    /**
     * Return file name
     *
     * @return mixed
     */
    public function name()
    {
        $sub = explode('/', $this->path);

        return $sub[count($sub)-1];
    }

    /**
     * Server max file size
     *
     * @return int|string
     */
    public static function file_upload_max_size()
    {
        return ini_get('upload_max_filesize');

        function parse_size($size) {
            return $size;
        }
          /*  $unit = preg_replace('/[^bkmgtpezy]/i', '', $size); // Remove the non-unit characters from the size.
            $size = preg_replace('/[^0-9\.]/', '', $size); // Remove the non-numeric characters from the size.
            if ($unit) {
                // Find the position of the unit in the ordered string which is the power of magnitude to multiply a kilobyte by.
                return round($size * pow(1024, stripos('bkmgtpezy', $unit[0])));
            }
            else {
                return round($size);
            }
        }*/

        //static $max_size = -1;
        $max_size = -1;

        if ($max_size < 0) {
            // Start with post_max_size.
            $max_size = parse_size(ini_get('post_max_size'));

            // If upload_max_size is less, then reduce. Except if upload_max_size is
            // zero, which indicates no limit.
            $upload_max = parse_size(ini_get('upload_max_filesize'));
            if ($upload_max > 0 && $upload_max < $max_size) {
                $max_size = $upload_max;
            }
        }
        return $max_size;
    }


    public function getMap($coordinates, $routeID, $pointID)
    {
        if(!$coordinates)
        {
            return 0;
        }

        $map = new StaticMap(str_replace(' ', '', $coordinates));

        //dd($map->url);

        $path = 'images/uploads/static_map_'. $routeID . '_' . $pointID . '.jpg';

        try {
            $toFile = fopen($path, 'w');
        }
        catch (Exception $e) {
            return 0;
        }

        try {
            // Repeat query to Google API while error, and $i < 20
            for($i = 0; $i < 20; $i++)
            {
                $client = new Client();
                $response = $client->get($map->url)
                    ->setResponseBody($toFile)
                    ->send();

                if($response->isError())
                {
                    continue;
                }
                else {
                    $fm = new Image(['path' => '/' . $path]);
                    $fm->save();
                    return $fm->id;
                }
            }
            return 0;
        }
        catch (Exception $e) {
            return 0;
        }
    }
}
