<?php 
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
<link rel="stylesheet" href="{{asset('css/select2.min.css')}}" type="text/css">
<style>
    :not(td) > table > #ireneTable2 > tr:first-child td,.irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
    }
    span.select2.select2-container.select2-container--default.select2-container--below.select2-container--open{
        width: 100% !important;
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2.select2-container.select2-container--default.select2-container--below,span.select2.select2-container.select2-container--default {
        width: 100% !important;
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2.select2-container.select2-container--default.select2-container--focus {
        width: 100% !important;
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2-selection.select2-selection--single {
      height:35px !important;
      font-size:12px !important;
      font-weight: bold;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
      height: 35px;
      position: absolute;
      top: 1px;
      right: 1px;
      width: 20px;
    }
    .select2-container--default .select2-selection--single{
        border:1px solid #dee2e6 !important;
        font-size:12px !important;
        font-weight: bold;
    }

    .select2-container .select2-selection--single .select2-selection__rendered{
        margin-top:3px !important;
        font-size:12px !important;
        font-weight: bold;
    }

    
</style>
@endsection

@section('title') 
    FORECAST MODULE
@endsection 

@section('subtitle')
    LIST OF FORECAST
@endsection

@section('breadcrumbs_1')
    Forecast
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')
    <button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate">UPLOAD FORECAST</button> 
@endsection


@section('main')

<div class="container-fluid">
    <div class="row">
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="myInput">MONTH FILTER</label>
            {{-- <input class="form-control" type="text" id="myInput"  placeholder="Search for names.." title="Type in a name"> --}}
            <select id="myInput" class="form-control" onchange="myFunction()">
                <option value="">ALL</option>
                <option value="JANUARY">JANUARY</option>
                <option value="FEBRUARY">FEBRUARY</option>
                <option value="MARCH">MARCH</option>
                <option value="APRIL">APRIL</option>
                <option value="MAY">MAY</option>
                <option value="JUNE">JUNE</option>
                <option value="JULY">JULY</option>
                <option value="AUGUST">AUGUST</option>
                <option value="SEPTEMBER">SEPTEMBER</option>
                <option value="OCTOBER">OCTOBER</option>
                <option value="NOVEMBER">NOVEMBER</option>
                <option value="DECEMBER">DECEMBER</option>
            </select>
        </div>
        <div class="col-xl-6 col-lg-3 col-sm-6 col-12"></div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="year">YEAR</label>
                <input class="form-control" id='year_now' type="number" value="{{$year_now}}">
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <br>
            {{ html()->submit('FILTER')->class('btn btn-outline-success btn-block loading_button')->attribute('style','width:100%; margin-top:3px;') }}
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <input type="hidden" name="" id="forecast_header_id">
            <div class="table-responsive"  style="height:60vh; overflow:auto;">
                <table class="table text-center">
                    <thead class="irene_thead">
                        <th>ID</th>
                        <th>MONTH</th>
                        <th>YEAR</th>
                        <th>ACTION</th>
                    </thead>
                    <tbody id="get_header_forecast">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('includes.forecast_modals')
@include('includes.loading')
@endsection

@section('scripts')
@include('includes.form_error')
@include('api.forecast')
@endsection