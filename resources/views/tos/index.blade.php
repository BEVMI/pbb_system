<?php 
$layout = session('pms_pbb_design');
if($layout == 1):
    $layout_post = 'main';
else:
    $layout_post = 'main1';
endif;
$user_auth = Auth::user();
?>

@extends('layouts.'.$layout_post)

@section('styles')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .irene_thead {
        font-weight: bold;
        background-color: #5e72e4;
        color: white;
        vertical-align: middle;
    }
    td{
        vertical-align: middle;
    }
    .tooltip {
        z-index: 100000000; 
    }
</style>
@endsection

@section('title') 
    TOS MODULE
@endsection 

@section('subtitle')
    LIST OF TOS 
@endsection

@section('breadcrumbs_1')
    TOS
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
<button class="btn btn-primary mt-2 mt-xl-0" onclick="loadForTos()" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;">CREATE TOS</button>
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-12"></div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            
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
</div>
<div class="row">
    <div class="table-responsive" style="height:60vh; overflow:auto;">
        <table class="table" id="irene_table" style="font-size:14px;">
            <thead class="text-center irene_thead">
                <th class="col">
                    <input type="hidden" id="user_name" value="{{$user_auth->name}}">
                    TOS REF#
                </th>
                <th class="col">DATE</th>
                <th class="col">CREATED BY</th>
                <th class="col">ACTION</th>
            </thead>
            <tbody class="text-center" id="tos_body_table">

            </tbody>
        </table>
    </div>
</div>
@include('includes.tos_modals')
@endsection

@section('scripts')
@include('api.tos')
@endsection
