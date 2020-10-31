<?php

namespace App\Http\Controllers;

use App\Models\Breakdown;
use App\Models\Random;
use Illuminate\Http\Request;
use Webpatser\Uuid\Uuid;

class BreakdownController extends Controller
{

    public function generate(Request $request)
    {
        $flag = 1;
        $randoms = Random::all()->toArray();

        foreach($randoms as $random)
        {
            $flag = Random::max('flag') + 1;
            break;
        }

        foreach($request->input("data") as $data)
        {
            $random = new Random([
                'id' => $data["random_id"],
                'values' => $data["random_value"],
                'flag' => $flag
            ]);

            $random->save();
            
            foreach($data["breakdowns"] as $bvalues)
            {
                $breakdown = new Breakdown([
                    'random_id' => $data["random_id"],
                    'values' => $bvalues
                ]);
    
                $breakdown->save();
            }
        }
        return response()->json('Success');
    }

    public function retrievedata()
    {
        $randoms = Random::all();
        $datas = [];
        $datatemp = [
            'flag' => "",
            'values' => ""
        ];
        $ctr = 0;
        $flag = 0;
        $values = "";
        foreach($randoms as $random)
        {
            if($ctr == 0)
            {
                $flag = $random["flag"];
            }
            
            $currentflag = $random["flag"];

            $breakdowns = Random::find($random["id"])->breakdowns;

            if($currentflag != $flag)
            {
                array_push($datas, $datatemp);

                $ctr = 0;
                $datatemp = [
                    'flag' => "",
                    'values' => ""
                ];
                
                $values = $random["values"];
                foreach($breakdowns as $breakdown)
                {
                    $values .= " ".$breakdown["values"];
                }
            }
            else
            {
                
                $values .= $random["values"];

                foreach($breakdowns as $breakdown)
                {
                    $values .= " ".$breakdown["values"];
                }

                $datatemp = [
                    'flag' => $currentflag,
                    'values' => $values
                ];
                $ctr++;
            }
        }
        array_push($datas, $datatemp);
        return response()->json($datas);
    }

   
}
