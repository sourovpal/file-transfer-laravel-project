<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\Transfer;
use Carbon\Carbon;

class ProcessExpirationDateTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiration:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Control link expiration date';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
         # Get all requested archives
         $transfers = Transfer::whereNotNull('expires_at')->get();
        
         foreach($transfers as $row) {

            $result = Carbon::createFromFormat('Y-m-d H:i:s', $row['expires_at'])->isPast();
 
             if ($result) {            
                
                switch ($row->storage) {
                    case 'local':
                        if (Storage::exists($row->transfer_url)) {
                            Storage::delete($row->transfer_url);
                        }
                        break;
                    case 's3':
                        if (Storage::disk('s3')->exists($row->object_key)) {
                            Storage::disk('s3')->delete($row->object_key);
                        }
                        break;
                    case 'wasabi':
                        if (Storage::disk('wasabi')->exists($row->object_key)) {
                            Storage::disk('wasabi')->delete($row->object_key);
                        }
                        break;
                    case 'storj':
                        if (Storage::disk('storj')->exists($row->object_key)) {
                            Storage::disk('storj')->delete($row->object_key);
                        }
                        break;
                    case 'gcp':
                        if (Storage::disk('gcp')->exists($row->object_key)) {
                            Storage::disk('gcp')->delete($row->object_key);
                        }
                        break;
                    case 'dropbox':
                        if (Storage::disk('dropbox')->exists($row->object_key)) {
                            Storage::disk('dropbox')->delete($row->object_key);
                        }
                        break;
                    default:
                        # code...
                        break;
                }
                
                $row->delete();
             
             } 
         }
    }
}
