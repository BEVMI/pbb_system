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
<style>
    .irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
    }
</style>
@endsection

@section('title') 
    JOBS MODULE
@endsection 

@section('subtitle')
    LIST OF JOBS
@endsection

@section('breadcrumbs_1')
    JOB
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
<button onclick="resetJobFields()" class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;display:none;">JOB CREATE</button> 
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-6 col-lg-3 col-sm-6 col-12"></div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="month_now">MONTH FILTER</label>
            <select id="month_now" class="form-control">
                @foreach ($months as $month)
                    @if($month->month_number == $month_now)
                        <option selected value="{{$month->month_number}}">{{$month->month_name}}</option>
                    @else
                        <option value="{{$month->month_number}}">{{$month->month_name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="year">YEAR</label>
                <input class="form-control" id='year_now' type="number" value="{{$year_now}}">
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <br>
            <button onclick='searchJob()' type="button" class="btn btn-outline-success" style="margin-top:3px; width:100%;">FILTER</button>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table">
                    <thead class="irene_thead">
                        <tr class="text-center"> 
                            <th style="width: 10%;">JOB#</th>
                            <th style="width: 10%;">DATE</th>
                            <th style="width: 20%;">STOCKCODE</th>
                            <th style="width: 20%;">DESCRIPTION</th>
                            <th style="width: 10%;">LONGDESC</th>
                            <th style="width: 10%;">QTYTOMAKE</th>
                            <th style="width: 10%;">PRODUCED</th>
                            <th style="width: 10%;">STATUS</th>
                        </tr>
                    </thead>
                    <tbody class="text-center" id="job_body">
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@include('includes.job_modals')
@endsection

@section('scripts')
@include('api.job')
@endsection