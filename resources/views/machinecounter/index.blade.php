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
</style>
@endsection

@section('title') 
    MACHINE COUNTER MODULE
@endsection 

@section('subtitle')
    LIST OF MACHINE COUNTER
@endsection

@section('breadcrumbs_1')
    MACHINE COUNTER
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
        <div class="col-xl-4 col-12"></div>
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
                    <th style="width: 20%">LINEID#</th>
                    <th style="width: 20%">JOB#</th>
                    <th style="width: 20%">DATE</th>
                    <th style="width: 10%">LOST CASE</th>
                    <th style="width: 10%">ENCODED BY</th>
                    <th style="width: 20%">ACTION</th>
                </thead>
                <tbody class="text-center" id="reject_body_table">

                </tbody>
            </table>
        </div>
    </div>
</div>
@include('includes.counter_modals')
@endsection

@section('scripts')
@include('api.counter')
@endsection