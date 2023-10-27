@extends('layouts.sidebar')

@section('content')
<div class="vh-100 d-flex" style="align-items:center; justify-content:center;">
  <div class="w-50 m-auto h-75">
    <p style="font-size: larger;"><span>{{ $date }}日</span><span class="ml-3">{{ $part }}部</span></p>
    <div class="h-75 border" style="background: white;">
      <table class="reserve-detail-tabale">
        @foreach($reservePersons as $reservePerson)
          <tbody class="reserve-detail-tbody">
            <tr class="text-center reserve-detail-label" style="background: #03AAD2;color: white;">
              <th style="margin-left: 10%;">ID</th>
              <th style="width: 65%;position: relative;right: 8%;">名前</th>
              <th style="margin-right: 18%;">場所</th>
            </tr>
            @foreach($reservePerson->users as $user)
              @if($reservePerson->users)
              <tr class="reserve-users">
                <td class="reserve-user-id" >{{ $user->id }}</td>
                <td class="reserve-user-name" ><sapn>{{ $user->over_name }}</span><span>{{ $user->under_name }}</span></td>
                <td class="reserve-user-place">リモート</td>
              </tr>
              @endif
            @endforeach
          </tbody>
        @endforeach
      </table>
    </div>
  </div>
</div>
@endsection