<?php

namespace App\Http\Controllers;

use App\Models\Reports\Weather\ShortTimeReport;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class ShortTimeDataController extends Controller
{

    public function store(Request $request){
        $ok=[];
        Log::info("-- INCOMING DATA --");

        $incomingData = $request->all();

        foreach($incomingData as $row){
            if(isset($row['interval'])){
                $row['interval'] = Carbon::parse($row['interval'])->format('Y-m-d H:i:s');
            }

            if(ShortTimeReport::where('interval',$row['interval'])->exists()){
                $ok[]= $row['interval'];
                continue;
            }

            $validator = Validator::make($row,[
                'interval'          => 'required|date|before:now|unique:weather_short_time_reports,interval',
                'temperature'       => 'nullable|numeric',
                'dew_point'         => 'nullable|numeric',
                'pressure'          => 'nullable|numeric',
                'humidity'          => 'nullable|integer',
                'rain_rate'         => 'nullable|numeric',
                'gust_speed'        => 'nullable|numeric',
                'wind_speed'        => 'nullable|numeric',
                'wind_dir'          => 'nullable|integer|max:360',
                'sky_temperature'   => 'nullable|numeric',
                'sqm'               => 'nullable|numeric',
                'sky_brightness'    => 'nullable|numeric',
                'cloud_cover'       => 'nullable|numeric',
            ]);
            
            if($validator->fails()){
                Log::error("validazione fallita");
                
                if(isset($row['interval'])){
                    Log::error($row['interval']);
                    $errors[] = [
                        'interval' => $row['interval'],
                        'errors' => $validator->errors()->toArray()
                    ];
                } else {
                    Log::error("campo interval assente");
                    $errors[] = [
                        'interval' => null,
                        'errors' => $validator->errors()->toArray()
                    ];
                }
                Log::error($validator->errors()->toArray());
            } else {
                try {
                    ShortTimeReport::create($validator->validated());
                    $ok[] = $row['interval'];
                } catch (\Throwable $th) {
                    $ok[] = $row['interval'];
                    
                }

                continue;
            }
        }

        if (empty($errors)) {
            Log::info("no errors in all data");
            Log::info("--END--");
            return response()->json([
                'status' => 'success',
                'valid_rows' => $ok,
            ]);
        }

        // Se ci sono errori, rispondi con i dettagli degli errori
        Log::info("something wrong");
        Log::info("--END--");
        return response()->json([
            'status' => 'error',
            'message' => 'Alcuni dati non sono validi',
            'invalid_rows' => $errors,
            'valid_rows' => $ok
        ], 422);  // Codice di stato 422 Unprocessable Entity

    }
}
