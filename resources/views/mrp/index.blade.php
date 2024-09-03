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
    MRP MODULE
@endsection 

@section('subtitle')
    LIST OF MRP
@endsection

@section('breadcrumbs_1')
    MRP
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')
    <button class="btn btn-primary mt-2 mt-xl-0" style="width: 100%;" data-bs-toggle="modal" data-bs-target="#modalMRP">COMPUTE</button> 
@endsection

@section('main')
<div class="container-fluid" style="padding-left: 0px; padding-right: 0px;">
    <div class="row">
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
        </div>
        
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="get_month">MONTH FILTER</label>
            <select class="form-control" id="get_month">
                @foreach ($months as $month)
                    @if($month->month_number === $month_now)
                        <option selected value="{{$month->month_number}}">{{$month->month_name}}</option>
                    @else
                        <option value="{{$month->month_number}}">{{$month->month_name}}</option>
                    @endif
                @endforeach
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <div class="form-group">
                <label for="get_year">YEAR</label>
                <input class="form-control" id='get_year' type="number" value="{{$year_now}}">
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="get_source">SOURCE</label>
            <select class="form-control" id='get_source'>
                <option value="Plan">PLAN</option>
                <option value="Forecast">FORECAST</option>
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="get_type">TYPE</label>
            <select class="form-control" id='get_type'>
                <option value="Summary">SUMMARY</option>
                <option value="Detail">DETAIL</option>
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <br>
            <input onclick="getComputed()" class="btn btn-outline-success btn-block loading_button" style="width:100%; margin-top:3px;" type="submit" value="FILTER">
        </div>
    </div>
    <div class="row" id="table-plan">
        <div class="table-responsive" style="height:600px; overflow-x: scroll;">
            <table class="table text-center">
                <thead class="irene_thead">
                    <th>StockCode</th>
                    <th>Description</th>
                    <th>LongDesc</th>
                    <th>OnHand</th>
                    <th>OnOrder</th>
                    <th>Total Required</th>
                    <th>To Order</th>
                </thead>
                <tbody id="get_header">
                    
                </tbody>
            </table>
        </div>
    </div>
    <div class="row" id="table-detail" style="display: none;">
        <iframe scrolling="no" id="detail_frame" style="height: 60vh;"></iframe>
    </div>
</div>

@include('includes.mrp_modals')
@endsection

@section('scripts')
@include('api.mrp')
@endsection