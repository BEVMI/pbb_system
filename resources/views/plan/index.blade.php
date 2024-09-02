@extends('layouts.main')

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
    }
</style>
@endsection

@section('title') 
    LINE
    @if($line == '3') 
        INJECTION 
    @else
        {{$line}}
    @endif
    PLANS MODULE
@endsection 

@section('subtitle')
    LIST OF LINE 
    @if($line == '3') 
        INJECTION 
    @else
        {{$line}}
    @endif
    PLANS
@endsection

@section('breadcrumbs_1')
    LINE 

    @if($line == '3') 
        INJECTION 
    @else
        {{$line}}
    @endif
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')
<button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;">UPLOAD LINE 
    @if($line == '3') 
        INJECTION 
    @else
        {{$line}}
    @endif
    PLAN
</button> 
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-12 col-sm-12">
            <div id='calendar'></div>
        </div>
        <div class="col-xl-3 col-sm-12"></div>
    </div>
</div>
@if($pm_flag==0)
    @include('includes.plan_modal')
@else
    @include('includes.pm_modal')
@endif
@endsection

@section('scripts')
<script src="{{asset('js/index.global.min.js')}}"></script>
@include('api.plan')
@endsection