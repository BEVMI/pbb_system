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
        <div class="col-sm-6"></div>
        <div class="col-sm-2">
            <label for="select_one">
                SELECT FIRST QC USER 
            </label>
            <select id='qc_user_1' class="form-control">
                <option value="0">NONE</option>
                @foreach($qc_users as $qc_user):
                    <option value="{{$qc_user->id}}">{{$qc_user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2">
            <label for="select_one">
                SELECT SECOND QC USER 
            </label>
            <select id='qc_user_2' class="form-control">
                <option value="0">NONE</option>
                @foreach($qc_users as $qc_user):
                    <option value="{{$qc_user->id}}">{{$qc_user->name}}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-2">
            <br>
            <button  data-bs-toggle="modal" data-bs-target="#modalAdvance" class="btn btn-primary" style="margin-top:3px; width:100%;">
                ADVANCE PRINT
            </button>
        </div>
    </div>
</div>
<hr style="border: 1px solid rgb(138, 138, 138);">
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-4 col-12 text-center">
            <div class="form-group">
                <label for="reference">LEGENDS</label><br>
                <table class="table">
                    <tr>
                        <td><i class="fa-solid fa-circle-exclamation" style="color:black;"></i>: QUARANTINE</td>
                        <td><i class="fa-solid fa-thumbs-up" style="color:black;"></i>: APPROVE</td>
                        <td><i class="fa-solid fa-hand" style="color:black;"></i>: ON HOLD</td>
                        <td><i class="fa-solid fa-rectangle-xmark" style="color:black;"></i>: REJECT</td>
                        <td><i class="fa-solid fa-print" style="color:black;"></i>: PRINT</td>
                    </tr>
                </table>
            </div>
        </div>
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
                <th class="col">
                    <div class="form-check">
                        <input id="all" class="form-check-input text-center" type="checkbox" checked style="position: absolute;">
                    </div>
                </th>
                <th class="col">
                    <input type="hidden" id="user_name" value="{{$user_auth->name}}">
                    <i style="display: none;" id="qGlobal" onclick="globalFunction('Quarantine')" class="fa-solid fa-circle-exclamation"  data-toggle="tooltip" data-placement="top" title="GLOBAL QUARANTINE TAG."></i>
                    <i id="aGlobal" onclick="globalFunction('Approved')" class="fa-solid fa-solid fa-thumbs-up" data-toggle="tooltip" data-placement="top" title="GLOBAL APPROVE TAG."></i>
                    <i id="oGlobal" onclick="globalFunction('On Hold')" class="fa-solid fa-solid fa-hand" data-toggle="tooltip" data-placement="top" title="GLOBAL ONHOLD TAG."></i>
                    <i id="rGlobal" onclick="globalFunction('Reject')" class="fa-solid fa-rectangle-xmark" data-toggle="tooltip" data-placement="top" title="GLOBAL REJECT TAG."></i>
                    <i id="tGlobal" onclick="globalFunction('Turnover')" class="fa-solid fa-t"></i>
                    <i id="pGlobal" onclick="globalFunction('Print')" class="fa-solid fa-print" data-toggle="tooltip" data-placement="top" title="GLOBAL PRINT TAG."></i>
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
