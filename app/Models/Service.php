<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    private static $service, $image, $imageName, $directory, $imageUrl;

    public static function imageUpload($request){

        if($request->hasFile('serviceImage')){
            self::$image = $request->serviceImage;
            self::$imageName = time() . '_' . uniqid() . '_' . self::$image->getClientOriginalName();
            self::$directory = 'uploads/backend/service-images/';
            self::$image->move(self::$directory, self::$imageName);
            return self::$directory . self::$imageName;
        }else{
            return 'uploads/backend/service-images/default_service_image.jpg';
        }
        
    }

    public static function addService($request){
        self::$service = new Service();
        self::$service->serviceName = $request->serviceName;
        self::$service->serviceImage = self::imageUpload($request);
        self::$service->serviceDetails = $request->serviceDetails;
        self::$service->save();
    }

    public static function updateService($request, $id){
        self::$service = Service::find($id);
        self::$service->serviceName = $request->serviceName;
        if($request->hasFile('serviceImage')){
            if(self::$service->serviceImage !=='uploads/backend/service-images/default_service_image.jpg' && file_exists(self::$service->serviceImage)){
                unlink(self::$service->serviceImage);
            }
            self::$service->serviceImage = self::imageUpload($request);
        }
        self::$service->serviceDetails = $request->serviceDetails;
        self::$service->save();
    }

    public static function deleteService($id){
        self::$service = Service::find($id);
        if(self::$service->serviceImage !== 'uploads/backend/service-images/default_service_image.jpg' && file_exists(self::$service->serviceImage)){
            unlink(self::$service->serviceImage);
        }
        self::$service->delete();
    }

    // one to many relationship with Plan 
    public function plans(){
        return $this->hasMany(Plan::class);
    }
}
