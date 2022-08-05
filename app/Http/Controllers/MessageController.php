<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;

class MessageController extends Controller
{
    public function getTotalMessage(Request $request){
        $validator = \Validator::make($request->all(), [
            'period_start' => 'required|date_format:Y-m-d',
            'period_end' => 'required|date_format:Y-m-d',
        ]);
    
        if ($validator->fails()) {
            return $validator->errors();
        }

        $periodStart = \Carbon\Carbon::createFromFormat('Y-m-d', $request->period_start)->startOfDay();
        $periodEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $request->period_end)->endOfDay();
        $periodGroupUnit = $request->period_group_unit ?? 'year';
        $data = [];
        $periodNext = $periodStart;
        while($periodNext < $periodEnd){
            $periodStart = $periodNext->startOfDay();;
            if($periodGroupUnit == 'year'){
                $periodNext = $periodStart->copy()->addYear()->startOfDay()->subSeconds(1);
            }else if($periodGroupUnit == 'month'){
                $periodNext = $periodStart->copy()->addMonth()->startOfDay()->subSeconds(1);
            }else if($periodGroupUnit == 'day'){
                $periodNext = $periodStart->copy()->addDay()->startOfDay()->subSeconds(1);
            }
            $total = Message::where('created_at', '>', $periodStart)->where('created_at', '<', $periodNext)->count();
            $temp['period_start'] = $periodStart->copy()->format('Y-m-d H:i:s');
            $temp['period_end'] = $periodNext->copy()->format('Y-m-d H:i:s');
            $temp['total'] = $total;
            array_push($data, $temp);
        }
        return $data;
    }

    public function getUsersActive(Request $request){

        $validator = \Validator::make($request->all(), [
            'period_start' => 'required|date_format:Y-m-d',
            'period_end' => 'required|date_format:Y-m-d',
        ]);
    
        if ($validator->fails()) {
            return $validator->errors();
        }

        $periodStart = \Carbon\Carbon::createFromFormat('Y-m-d', $request->period_start)->startOfDay();
        $periodEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $request->period_end)->endOfDay();
        $limit = $request->limit ?? 10;
        $dir = $request->dir ?? 'asc';

        $users = User::userActive($periodStart, $periodEnd, $dir)->take($limit)->sortBy(['created_at' => $dir])->toArray();

        echo "<pre>";
        print_r($users);
        echo "</pre>";
    }

    public function getUsersInactive(Request $request){

        $validator = \Validator::make($request->all(), [
            'period_start' => 'required|date_format:Y-m-d',
            'period_end' => 'required|date_format:Y-m-d',
        ]);
    
        if ($validator->fails()) {
            return $validator->errors();
        }

        $periodStart = \Carbon\Carbon::createFromFormat('Y-m-d', $request->period_start)->startOfDay();
        $periodEnd = \Carbon\Carbon::createFromFormat('Y-m-d', $request->period_end)->endOfDay();
        $limit = $request->limit;
        $dir = $request->dir;

        $activeId = User::userActive($periodStart, $periodEnd, $dir)->pluck('id')->toArray();
        $inactiveUsers = User::whereNotIn('id', $activeId)->take($limit)->orderBy('created_at', $dir)->get()->toArray();

        echo "<pre>";
        print_r($inactiveUsers);
        echo "</pre>";
    }
}
