<?php namespace App\Services;
use File;
use Storage;
use Crypt;
use Illuminate\Http\Response;
use Illuminate\Contracts\Routing\ResponseFactory;
class FileService{
	static $paths = [
		'default' => 'files/',
		'user'=>'users/',
        'assets'=>'assets/'
	];

	const CIPHER = MCRYPT_RIJNDAEL_128; // Rijndael-128 is AES
    const MODE   = MCRYPT_MODE_CBC;
    /**
     * save file
     * @param  [type] $filename [description]
     * @param  [type] $contents [description]
     * @param  string $keyPath  [description]
     * @return [type]           [description]
     */
	public static function save($filename, $contents, $crypt = false, $folder = 'default', $keyPath = 'default'){
		if($crypt){
			$contents = Crypt::encrypt($contents);
		}
         $status = Storage::put(self::$paths[$keyPath].$folder.$filename, $contents);
		return $status;

	}
	/**
	 * get content of file
	 * @param  [type] $filename [description]
	 * @param  [type] $keyPath  [description]
	 * @return [type]           [description]
	 */
	public static function get($filename, $folder, $keyPath){
		$contents = Storage::get(self::$paths[$keyPath].$folder.$filename);
		return $contents;
	}

	/**
	 * delete file
	 * @param  [type] $filename [description]
	 * @param  [type] $keyPath  [description]
	 * @return [type]           [description]
	 */
	public static function delete($filename, $folder, $keyPath){
		 Storage::delete(self::$paths[$keyPath].$folder.$filename);
	}
	/**
	 * render file from url
	 * @param  [type] $filename [description]
	 * @param  [type] $keyPath  [description]
	 * @return [type]           [description]
	 */
	public static function view($filename, $crypt, $folder, $keyPath){
		$contents = self::get($filename, $folder, $keyPath);
         $payload = json_decode(base64_decode($contents), true);
		if($crypt && $payload){
			$contents = Crypt::decrypt($contents);
		}
		return (new Response($contents, 200))
              ->header('Content-Type', self::mime_content_type($filename));

	}
    /**
     * [mime_content_type description]
     * @param  [type] $filename [description]
     * @return [type]           [description]
     */
    public function download($filename, $crypt, $folder, $keyPath){
        $contents = self::get($filename, $folder, $keyPath);
        $payload = json_decode(base64_decode($contents), true);
        if($payload){
            $contents = Crypt::decrypt($contents);
            Storage::put(self::$paths[$keyPath].$folder.$filename, $contents);
        }
        return response()->download(storage_path().'/app/'.self::$paths[$keyPath].$folder.$filename);
    }
	 public static function mime_content_type($filename) {

        $mime_types = array(

            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        );
       
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        return @$mime_types[$ext];
    }
    /**
     * save avatar
     * @param  [type] $content content of file
     * @param  [int] $userId  [description]
     * @return [string]        file name or message error
     */
    public static function saveAvatar($content, $userId){
        $disk = Storage::disk('local_avatar');
        $time = time();
        $fileName = substr(Crypt::encrypt( uniqid(). $time.'-avatar-'.$userId), 6, 16).'.png';
        try{
            // Storage::disk('local_avatar')->put($fileName, $content);
            Storage::disk('local_avatar')->put($fileName, $content);
                
                    $image = \Image::make(public_path().'/avatars/'.$fileName);
                    $image->crop($image->width(), $image->width(), 0)
                    ->save(public_path().'/avatars/'.$fileName);
                    $image->resize(160, 160)
                        ->save(public_path().'/avatars/160x160_'.$fileName);
                    $image->resize(100, 100)
                        ->save(public_path().'/avatars/100x100_'.$fileName);
                    $image->resize(50, 50)
                        ->save(public_path().'/avatars/50x50_'.$fileName);
                    $image->resize(30, 30)
                        ->save(public_path().'/avatars/30x30_'.$fileName);
        }catch(Exeption $e){
            return array('error'=>$e->getMessage());
        }

        return $fileName;
    }
    public static function deleteAvatar($filename){
         Storage::disk('local_avatar')->delete($filename);
    }

}