<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Services\Statistics\StorageUsageService;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Transfer;
use DataTables;
use Carbon\Carbon;

class TransferResultController extends Controller
{
    /** 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {  
        $storage_usage = new StorageUsageService();

        if ($request->ajax()) {
            $data = Transfer::where('user_id', Auth::user()->id)->latest()->get();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('actions', function($row){
                        $actionBtn = '<div>                                            
                            <a href="'. route("user.transfer.list.show", $row["id"] ). '"><i class="fa-solid fa-cabinet-filing table-action-buttons view-action-button" title="View Transfer Details"></i></a>
                            <a class="deleteTransferButton" id="'. $row["id"] .'" href="#"><i class="fa-solid fa-trash-xmark table-action-buttons delete-action-button" title="Delete Transfer"></i></a>
                        </div>';
                       
                        return $actionBtn;
                    })
                    ->addColumn('created-on', function($row){
                        $created_on = '<span class="font-weight-bold">'.date_format($row["created_at"], 'd M Y').'</span><br><span>'.date_format($row["created_at"], 'H:i A').'</span>';
                        return $created_on;
                    })   
                    ->addColumn('expires-on', function($row){
                        $expires_on = ($row["expires_at"]) ? '<span class="font-weight-bold">'.Carbon::parse($row["expires_at"])->format('d M Y').'</span><br><span>'.Carbon::parse($row["expires_at"])->format('H:i A').'</span>' : '';
                        return $expires_on;
                    })
                    ->addColumn('custom-format', function($row){
                        $custom_format = '<span class="font-weight-bold">'.strtoupper($row["file_ext"]).'</span>';
                        return $custom_format;
                    })    
                    ->addColumn('custom-type', function($row){
                        switch ($row['share_type']) {
                            case 'link':
                                $custom_type = '<span class="font-weight-bold glacier cell-box">Link</span>';
                                break;
                            case 'email':
                                $custom_type = '<span class="font-weight-bold glacier-ir cell-box">Email</span>';
                                break;
                            default:
                                $custom_type = '<span class="font-weight-bold glacier cell-box">Link</span>';
                                break;
                        }
                        return $custom_type;
                    })   
                    ->addColumn('custom-name', function($row){
                        $icon = '<div class="file-placeholder-container">                                    
                                    <span class="file-placeholder-text text-center">'.$row['file_ext'].'</span>
                                    <svg width="30px" height="35px" fill="currentColor" viewBox="0 0 38 51" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" class="file-placeholder"><path d="M22.1666667,13.546875 L22.1666667,0 L2.375,0 C1.05885417,0 0,1.06582031 0,2.390625 L0,48.609375 C0,49.9341797 1.05885417,51 2.375,51 L35.625,51 C36.9411458,51 38,49.9341797 38,48.609375 L38,15.9375 L24.5416667,15.9375 C23.2354167,15.9375 22.1666667,14.8617187 22.1666667,13.546875 Z M38,12.1423828 L38,12.75 L25.3333333,12.75 L25.3333333,0 L25.9369792,0 C26.5703125,0 27.1739583,0.249023438 27.6192708,0.697265625 L37.3072917,10.4589844 C37.7526042,10.9072266 38,11.5148437 38,12.1423828 Z"></path></svg>';
                                '</div>';
                        $custom_name = $icon . '<a class="file-name font-weight-bold" href="#" id="'.$row["id"].'">'.substr($row["file_name"],0,30).'</a>';
                        return $custom_name;
                    })  
                    ->addColumn('custom-size', function($row){
                        $size = '<span class="font-weight-bold">'.$this->formatSize($row["size"]).'</span>';
                        return $size;
                    })
                    ->addColumn('custom-protected', function($row){
                        $protected = ($row['protected']) ? '<i class="fa-solid fa-circle-check table-info-button green fs-20"></i>' : '<i class="fa-solid fa-circle-xmark red table-info-button fs-20"></i>';
                        return $protected;
                    })
                    ->rawColumns(['actions', 'created-on', 'custom-size', 'custom-format', 'custom-type', 'custom-name', 'custom-protected', 'expires-on'])
                    ->make(true);
                    
        }

        $storage = [
            'total' => $storage_usage->getTotalAchives(),
            'links' => $storage_usage->getTotalLinkShared(),
            'email' => $storage_usage->getTotalEmailShared(),
        ];

        return view('user.transfers.index', compact('storage'));
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Transfer $id)
    {
        if ($id->user_id == Auth::user()->id){

            return view('user.transfers.show', compact('id'));     

        } else{
            return redirect()->route('user.transfer.list');
        }
      
    }


    /**
     * Format storage space to readable format
     */
    private function formatSize($size, $precision = 2) { 
        $units = array('B', 'KB', 'MB', 'GB', 'TB'); 
    
        $size = max($size, 0); 
        $pow = floor(($size ? log($size) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 
        
        $size /= pow(1024, $pow);

        return round($size, $precision) . $units[$pow]; 
    }
}
