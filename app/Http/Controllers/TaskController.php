<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Trip;
use App\Jobs\TripCvsProcess;

class TasksController extends Controller
{
    public function create(){
        return view('import');
    }
    
    public function store(Request $request){
        $request->validate([
    'file' => 'required|mimes:csv,txt'
        ]);
    $file = file($request->file->getRealPath());
dd($file);
    $data = array_slice($file, 1);

    $parts = (array_chunk($data, 1000));

    foreach($parts as $index=>$part){
        $fileName = resource_path('pending-files/'.date('y-m-d-H-i-s').$index. '.csv');

        file_put_contents($fileName, $part);
    }

    $path = resource_path('pending-files/*.csv');

    $get = glob($path);

    foreach (array_slice($get, 0, 1) as $file)
    {
        //TripCvsProcess::dispatch($file);
        $data = array_map('str_getcsv', file($file));

        foreach($data as $row)
        {
            Trip::updateOrCreate([
                'trip_id' => $row[0]
            ],
            [
               'staffName' => $row[1],
               'pickUpAddress' => $row[3],
               'destinationAddress' => $row[2],
               'amount' => $row[4]
            ]);
        }

        unlink($file);
    }
    //session()->flash('status', 'queued for importing')
        return 'data stored';
    }
    }


