<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show(){
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request){
        DB::beginTransaction();
        try{
            $getPart = $request->getPart;
            $getDate = $request->getData;
            $part = $request->part;

            $maxLength = max(count($getPart), count($getDate));
            $getPart = array_pad($getPart, $maxLength, null);
            // $maxLength = max(count($getPart), count($getDate));
            // while (count($getPart) < $maxLength) {
            //     $getPart[] = ''; 
            // }
            // dd($getPart);
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            //array_filterで配列を作成している　例　"2023-10-17" => "1"
            // dd($reserveDays);
            foreach($reserveDays as $key => $value){
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request){
        // dd($request);
        DB::beginTransaction();
        try{
            $getPart = $request->part;
            // dd($getPart);
            $getDate = $request->getData;
            // dd($reserveDays);
            $reserve_settings = ReserveSettings::where('setting_reserve', $getDate)->where('setting_part', $getPart)->first();
            $reserve_settings->users()->detach(Auth::id());
            $reserve_settings->increment('limit_users');
            DB::commit();
        }catch(\Exception $e){
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

}