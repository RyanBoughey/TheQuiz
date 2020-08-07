@extends('layouts.app')

@section('title', 'Leaderboard')

@section('content')
    <div>
        <p>Your score is {{ $score }}, to save it to the leaderboard please enter your name and email address</p>
        <form method="POST" action="/">
            @csrf
            <input type="hidden" name="score" value="{{ $score }}">
            <div class="question mb-1">
                <p>Name</p>
                <input type="text" name="name" value="" <?= ($errors->has('name') ? 'class="error"' : '') ?> >
            </div>
            <div class="question mb-1">
                <p>Email</p>
                <input type="email" name="email" value="" <?= ($errors->has('email') ? 'class="error"' : '') ?> >
            </div>
            <input type="submit" class="button" value="Submit">
        </form>
    </div>
@endsection
