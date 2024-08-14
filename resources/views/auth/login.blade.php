@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <input type="email" class="form-control form-control-lg" placeholder="Email" aria-label="Email" name="email" >
        </div>
        
        <div class="mb-3">
            <input type="password" class="form-control form-control-lg" placeholder="Password" aria-label="Password" name="password">
        </div>


        <div class="text-center">
            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-4 mb-0">Sign in</button>
        </div>
    </form>
    
@endsection
