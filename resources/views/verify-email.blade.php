@extends('profile.user')

@section('content')

    <div>Подтвердите email:
        <a href="{{route('verification.send')}}">отправить повторно</a>
    </div>
@endsection
