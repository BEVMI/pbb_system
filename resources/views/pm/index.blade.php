<?php 
    $user_name = Auth::user()->name;
?>
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
    PM MODULE
@endsection 

@section('subtitle')
    LIST OF PLANS
@endsection

@section('breadcrumbs_1')
    PLAN
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')

@endsection

@section('main')
{!! html()->modelForm(null, null)->class('form')->id('search')->attribute('action',route('pm.index'))->attribute('method','GET')->open() !!}
{!! html()->closeModelForm() !!}
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-7">

        </div>

        <div class="col-xl-3">
            <div class="form-group">
                <label for="line">CHOOSE LINE</label>
                <select class="form-control" form="search" name="line" id="line">
                    @foreach ($lines as $line_post)
                        @if($line == $line_post->id)
                            <option selected value="{{$line_post->id}}">{{$line_post->cDescription}}</option>
                        @else
                            <option value="{{$line_post->id}}">{{$line_post->cDescription}}</option>
                        @endif
                    @endforeach
                   
                </select>
            </div>
        </div>

        <div class="col-xl-2">
            <br>
            {{ html()->submit('SEARCH')->class('btn btn-outline-success btn-block loading_button')->attribute('form','search')->attribute('style','width:100%; margin-top:3px;') }}
        </div>
    </div>
</div>

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