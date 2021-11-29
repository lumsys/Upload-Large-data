<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Trip;

class ProcessCsvUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    public $file;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($file)
    {
        //

        $this->file=$file;
    }

    /**
     * Execute the job.
     *
     * @return void
     * 
     **/
    public function handle()
    {
        //
        $data = array_map('str_getcsv', file($this->file));

        foreach($data as $row)
        {
            //dd($row);
            Trip::updateOrCreate([
                'trip_id' => $row[0]
            ],
            [
               'staffName' => $row[1],
               'pickUpAddress' => $row[3],
               'destinationAddress' => $row[2],
               'amount' => $row[4]
            ]);
           // Trip::create($row);
        }
        unlink($this->file);
    }
    }

