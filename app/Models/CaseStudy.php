<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseStudy extends Model
{
    private static $caseStudy, $image, $imageName, $directory, $imageUrl;

    public static function imageUpload($request){

        if($request->hasFile('caseStudyImage')){
            self::$image = $request->caseStudyImage;
            self::$imageName = time() . '_' . uniqid() . '_' . self::$image->getClientOriginalName();
            self::$directory = 'uploads/backend/case-study-images/';
            self::$image->move(self::$directory, self::$imageName);
            return self::$directory . self::$imageName;
        }else{
            return 'uploads/backend/case-study-images/default_case_study_image.jpg';
        }
        
    }

    public static function addCaseStudy($request){
        self::$caseStudy = new CaseStudy();
        self::$caseStudy->caseStudyImage = self::imageUpload($request);
        self::$caseStudy->caseStudyDetails = $request->caseStudyDetails;
        self::$caseStudy->save();
    }

    public static function updateCaseStudy($request, $id){
        self::$caseStudy = CaseStudy::find($id);
        if($request->hasFile('caseStudyImage')){
            if(self::$caseStudy->caseStudyImage !=='uploads/backend/case-study-images/default_case_study_image.jpg' && file_exists(self::$caseStudy->caseStudyImage)){
                unlink(self::$caseStudy->caseStudyImage);
            }
            self::$caseStudy->caseStudyImage = self::imageUpload($request);
        }
        self::$caseStudy->caseStudyDetails = $request->caseStudyDetails;
        self::$caseStudy->save();
    }

    public static function deleteCaseStudy($id){
        self::$caseStudy = CaseStudy::find($id);
        if(self::$caseStudy->caseStudyImage !== 'uploads/backend/case-study-images/default_case_study_image.jpg' && file_exists(self::$caseStudy->caseStudyImage)){
            unlink(self::$caseStudy->caseStudyImage);
        }
        self::$caseStudy->delete();
    }
}
