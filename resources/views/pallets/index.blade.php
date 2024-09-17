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
    PALLETS MODULE
@endsection 

@section('subtitle')
    LIST OF PALLETS 
@endsection

@section('breadcrumbs_1')
    PALLET
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-12"></div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="reference">REFERENCE</label>
                <input id="reference" class="form-control" type="text">
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="status">STATUS</label>
                <select class="form-control" name="status" id="status">
                    @foreach ($statuses as $status)
                        <option value="{{$status}}">{{$status}}</option>    
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="date">DATE</label>
                <input class="form-control" type="date" id="date" value="{{$initial_date}}">
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
                <th class="col"></th>
                <th class="col">
                    <input type="hidden" id="user_name" value="{{$user_auth->name}}">
                    <i style="display: none;" id="qGlobal" onclick="globalFunction('Quarantine')" class="fa-solid fa-q"></i>
                    <i id="aGlobal" onclick="globalFunction('Approved')" class="fa-solid fa-a"></i>
                    <i id="oGlobal" onclick="globalFunction('On Hold')" class="fa-solid fa-o"></i>
                    <i id="rGlobal" onclick="globalFunction('Reject')" class="fa-solid fa-r"></i>
                    <i id="tGlobal" onclick="globalFunction('Turnover')" class="fa-solid fa-t"></i>
                    <i id="pGlobal" onclick="globalFunction('Print')" class="fa-solid fa-p"></i>
                </th>
                <th class="col">
                    <input  type="text" id="myInput" onkeyup="myFunction()" placeholder="SEARCH">
                </th>
                <th class="col">DATES</th>
                <th class="col">JOB#</th>
                <th class="col">LOT</th>
                <th class="col">STATUS</th>
                
            </thead>
            <tbody class="text-center" id="pallet_body_table">

            </tbody>
        </table>
    </div>
</div>
@include('includes.pallets_modals')
@endsection

@section('scripts')
@include('api.pallets')
@endsection
