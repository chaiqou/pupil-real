@extends('layouts.dashboard')
@section('content')
    <div>
        <form method="POST" action="{{route('send.invite')}}">
            @csrf
            <input name="email" type="text"/>
        </form>
    </div>

   <div class="mx-10 mt-10">
       <invites :school-id="{{$schoolId}}"></invites>
   </div>
@endsection
