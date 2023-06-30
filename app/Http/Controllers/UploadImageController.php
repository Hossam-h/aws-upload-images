<?php

namespace App\Http\Controllers;

use App\Models\UploadImage;
use Illuminate\Http\Request;
use Aws\S3\S3Client;
use Aws\Exception\AwsException;
use Str;
class UploadImageController extends Controller
{

    public function all()
    {
        $file = UploadImage::get();
        return response()->json($file); 
    }



    public function index()
    {
        $file = UploadImage::latest()->first();

        return view('welcome',compact('file')); 
    }

    public function store(Request $request)
    {

        $file = $request->file('file');
        $fileName= $file->getClientOriginalName();
        UploadImage::create([
            'image' =>'avatar/'.$fileName
        ]);
        $file->storeAs('avatar/',$fileName,'s3');

        $lastImage = UploadImage::latest()->first();

        return view('welcome',compact('lastImage')); 
    }

   

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $uploaded =  UploadImage::find($id);
        $fileName =  $uploaded->image;
   
       // Specify your AWS credentials and region
       $credentials = [
           'key' => 'AKIAXQCVHOSRK7LIO7PV',
           'secret' => 'O8f6Oko/lOZ6VXqVrr2+VJhH25D7UIaUcrCFA2Tx',
       ];
       
       // Instantiate the S3 client
       $s3Client = new S3Client([
           'version' => 'latest',
           'region' => 'us-east-1',
           'credentials' => $credentials,
       ]);
       
       // Specify the bucket name and file key
       $bucket = 'upload-again';
       $fileKey = $fileName;
       
       try {
           // Delete the file from the S3 bucket
           $s3Client->deleteObject([
               'Bucket' => $bucket,
               'Key' => $fileKey,
           ]);
       
           echo 'File deleted successfully.';
       } catch (AwsException $e) {
           echo 'Error deleting file: ' . $e->getMessage();
       }
   
    }

    public function download($id){

        $uploaded =  UploadImage::find($id);
        $fileName =  $uploaded->image;
   
       $s3 = new S3Client([
           'version' => 'latest',
           'region' => config('filesystems.disks.s3.region'),
           'credentials' => [
               'key' => config('filesystems.disks.s3.key'),
               'secret' => config('filesystems.disks.s3.secret'),
           ],
       ]);
       
       $bucket         = 'upload-again';
       $key            = $fileName;
       $uniqueFilename = Str::uuid()->toString() . '.jpg';
       $localPath      = 'C:\Users\hossam\Downloads\\'.$uniqueFilename;
       
       try {
           $result = $s3->getObject([
               'Bucket' => $bucket,
               'Key' => $key,
               'SaveAs' => $localPath,
           ]);
           return 'image downloaded sucess';
   
           // Image downloaded successfully
       } catch (AwsException $e) {
           // Handle the exception if something goes wrong
           $error = $e->getMessage();
       }
    }
}
