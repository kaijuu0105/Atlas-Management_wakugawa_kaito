<?php
namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\ReserveSettingUser;

class CalendarWeekDay{
  protected $carbon;

  function __construct($date){
    $this->carbon = new Carbon($date);
  }

  function getClassName(){
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render(){
    return '<p class="day calendar-day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay(){
    return $this->carbon->format("Y-m-d");
  }

  // $ymdには日付が入っているいる（2023-10-01）
  function dayPartCounts($ymd){
    $html = [];
    $one_part_reserve = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->value('id');
    $one_part = ReserveSettingUser::where('reserve_setting_id', $one_part_reserve)->count('reserve_setting_id');
    // dd($one_part);
    if(empty($one_part)){
      $one_part = 0;
    }

    $two_part_reserve = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->value('id');
    $two_part = ReserveSettingUser::where('reserve_setting_id', $two_part_reserve)->count('reserve_setting_id');
    if(empty($two_part)){
      $two_part = 0;
    }

    $three_part_reserve = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->value('id');
    $three_part = ReserveSettingUser::where('reserve_setting_id', $three_part_reserve)->count('reserve_setting_id');
    // dd($one_part);
    if(empty($three_part)){
      $three_part = 0;
    }

    $html[] = '<div class="p-text-left text-left">';  
    $html[] = '<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => 1]) . '" class="a-day_part1">1部</a><p class="day_part1 m-0 pt-1">' .$one_part. '</p>';
    $html[] ='<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => 2]) . '" class="a-day_part2">2部</a><p class="day_part2 m-0 pt-1">' .$two_part. '</p>';
    $html[] ='<a href="' . route('calendar.admin.detail', ['date' => $ymd, 'part' => 3]) . '" class="a-day_part3">3部</a><p class="day_part3 m-0 pt-1">' .$three_part. '</p>';
    $html[] = '</div>';

    return implode("", $html);
  }


  function onePartFrame($day){
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if($one_part_frame){
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    }else{
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day){
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if($two_part_frame){
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    }else{
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day){
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if($three_part_frame){
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    }else{
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment(){
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}