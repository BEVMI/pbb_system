<?php 
$user_auth = Auth::user();
$layout = session('pms_pbb_design');
if($layout == 1):
    $layout_post = 'main';
else:
    $layout_post = 'main1';
endif;
?>

@extends('layouts.'.$layout_post)

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
    }
    td{
        vertical-align: middle;
    }
    .list-group-item.active {
        z-index: 2;
        color: white;
        background-color: #212529;
        border-color: #212529;
    }
</style>
@endsection

@section('title') 
    DOWNTIME MODULE
@endsection 

@section('subtitle')
    LIST OF DOWNTIME
@endsection

@section('breadcrumbs_1')
    DOWNTIME
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
<button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;">CREATE</button> 
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-2 col-12"></div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="job_search">JOB</label>
            <input id="job_search" class="form-control" type="number" min="0" >
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="line_search">LINES</label>
            <select onchange="hideFields()" class="form-control" name="line_search" id="line_search">
                @foreach ($lines as $line)
                    <option value="{{$line->id}}">{{$line->cDescription}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="month_now">MONTH FILTER</label>
            {{ html()->select('month_now')->options($months)->value($month_now)->class('form-control ')->id('month_now') }}
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="year_now">YEAR</label>
                <input class="form-control" id='year_now' type="number" value="{{$year_now}}">
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <br>
            <button onclick='search()' type="button" class="btn btn-outline-success" style="margin-top:3px; width:100%;">FILTER</button>
        </div>
    </div>
    <div class="row">
        <div class="table-responsive" style="height:60vh; overflow:auto;">
            <table class="table">
                <thead class="text-center irene_thead">
                    <th style="width: 20%">JOB#</th>
                    <th style="width: 20%">DATE#</th>
                    <th style="width: 20%">SHIFT LENGTH</th>
                    <th style="width: 20%">CREATED DETAILS</th>
                    <th style="width: 20%">ACTION</th>
                </thead>
                <tbody class="text-center" id="downtime_main_body_table">

                </tbody>
            </table>
        </div>
    </div>
</div>
@include('includes.downtime_modals')
@include('includes.downtime_update_modal')
@endsection

@section('scripts')
@include('api.downtime_search')
@include('api.downtime')
@endsection