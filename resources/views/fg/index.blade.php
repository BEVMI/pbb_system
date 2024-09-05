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
    tr{
        vertical-align: middle;
        font-weight: bold;
    }
</style>
@endsection

@section('title') 
    INVENTORY FG MODULE
@endsection 

@section('subtitle')
    LIST OF FG
@endsection

@section('breadcrumbs_1')
    FG
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')
@endsection

@section('main')
<div class="container-fluid">
    <div class="row">
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="stock_code">STOCK CODE</label>
            <select class="form-control" name="stock_code" id="stock_code">
                
                @foreach($stock_codes as $stock_code)
                    <option value="{{$stock_code}}">{{$stock_code}}</option>
                @endforeach
                <option selected value="">ALL</option>
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <br>
            <input onclick="loadFGFilter('1')" class="btn btn-outline-success btn-block loading_button" style="width:100%; margin-top:3px;" type="submit" value="FILTER">
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive"  style="height:60vh; overflow:auto;">
                <table class="table text-center">
                    <thead class="irene_thead">
                        <th>StockCode</th>
                        <th>OnHand</th>
                        <th>Allocated</th>
                        <th>OnHand(NET)</th>
                        <th>BackOrder</th>
                        <th>Capacity</th>
                        <th>AveSales</th>
                        <th>ToProduce1</th>
                        <th>Month Cover</th>
                        <th>Completion Days</th>
                    </thead>
                    <tbody id="fg_table">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('api.fg')
@endsection