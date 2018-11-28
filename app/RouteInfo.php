<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Http\Request;
use Storage;
use File;

class RouteInfo extends Model implements Auditable
{
    use \OwenIt\Auditing\Auditable;

     //Table Name
     protected $table = 'route_infos';
     //Primary Key
     public $primaryKey = 'id';

    public function docu()
    {
        return $this->belongsTo('App\Docu');
    }

    public function statuscode()
    {
        return $this->belongsTo('App\Statuscode');
    }

    public function file_store($file_to_upload)
    {
        $folder_name_with_current_date = Date('Ymd') . '_file_uploads';
        foreach($file_to_upload as $key => $upload){
        //get filename with extension
        $filenameWithExt = $upload->getClientOriginalName();
        //get just filename
        $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
        //get just extension
        $extension = $upload->getClientOriginalExtension();
        //filename to store
        $file = $filename. '_' . time(). '.' . $extension;
        //upload file
        $upload->storeAs('public/uploads/' . $folder_name_with_current_date, $file);
        $dataFile['file' . $key] = $file;
        }
        $file_info = [
            'path' => $folder_name_with_current_date,
            'dataFile' => $dataFile
        ];
        return $file_info;
    }

    public function createInfo($request, $data)
    {   
        if($data != null){
            $user_id = $data['user'];
            $docu_id = $data['docu'];
        }
        else{
            $user_id = $request->input('editedBy');
            $docu_id = $request->input('hidden_docuId');
        }

        if($request->hasFile('filename')){
            $file_to_upload = $request->file('filename');
            $file_info =  $this->file_store($file_to_upload);
        }
        else{
            $file_info = [];
        }

        $this->edited_by = $user_id;
        $this->docu_id = $docu_id;
        $this->statuscode_id = $request->input('statuscode');
        $this->remarks = $request->input('remarks');
        $this->upload_data = json_encode($file_info);
        $this->save();

        $outData = [
            'docu' => (int)$this->docu_id,
            'routeinfo' => (int)$this->id
        ];

        return $outData;
    }

    public function editInfo($request)
    {
        if($request->hasFile('filename')){
            $file_to_upload = $request->file('filename');
            $file_info =  $this->file_store($file_to_upload);
        }
        else{
            $file_info = [];
        }

        $info_to_update = $this->whereId($request->input('hidden_routeinfoID'))->first();
        $info_to_update->statuscode_id = $request->input('statuscode');
        $info_to_update->remarks = $request->input('remarks');
        $info_to_update->upload_data = json_encode($file_info);
        $info_to_update->save();
    }

    public function FileUploadToView($fileInfos)
    {
        $output = "<div class = 'row'><h4>Uploaded Files</h4>";
        $array_of_fileinfo = json_decode($fileInfos, true);
        $directory_with_date_of_file = $array_of_fileinfo['path'];
        foreach($array_of_fileinfo['dataFile'] as $filename){
            switch(substr(strrchr($filename,'.'),1)){
                case "png":
                case "jpg":
                case "jpeg":
                case "bmp":
                    $output .= "<div class ='col s4'> <a href='http://dtracking.net/storage/uploads/" . 
                    $directory_with_date_of_file .  "/" . $filename . "' target='_blank'>" .
                    "<img id='image-upload' src='http://dtracking.net/storage/uploads/" . $directory_with_date_of_file . 
                    "/" . $filename . "'>" .
                    "</a><span>". $filename ."</span></div>";
                    break;
                case "pdf":
                    $output .= "<div class ='col s4'> <a href='http://dtracking.net/storage/uploads/" . 
                    $directory_with_date_of_file . "/" . $filename . "' target='_blank'>" .
                    "<img id='image-upload' src='http://dtracking.net/images/pdf_logo.jpg'>" .
                    "</a></div>";
                    break;
                case "pptx":
                    $output .= "<div class ='col s4'> <a href='http://dtracking.net/storage/uploads/" . 
                    $directory_with_date_of_file . "/" . $filename . "' download>" .
                    "<img id='image-upload' src='http://dtracking.net/images/powerpoint_logo.png'>" .
                    "</a><span>". $filename ."</span></div>";
                    break;
                case "docx":
                    $output .= "<div class ='col s4'> <a href='http://dtracking.net/storage/uploads/" . 
                    $directory_with_date_of_file . "/" . $filename . "' download>" .
                    "<img id='image-upload' src='http://dtracking.net/images/word_logo.png'>" .
                    "</a><span>". $filename ."</span></div>";
                    break;
            }
        }
        $output .= '</div>';
        return $output;
    }

}
