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
    span.tox-statusbar__branding{
        display: none !important;
    }

    span.select2.select2-container.select2-container--default.select2-container--below.select2-container--open{
        width: 210px !important;
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2.select2-container.select2-container--default.select2-container--below,span.select2.select2-container.select2-container--default {
        width: 210px  !important;
        font-size:12px !important;
        font-weight: bold;
    }

    span.select2.select2-container.select2-container--default.select2-container--focus {
        width: 210px  !important;
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
        height: 50px;
		overflow-y: auto !important;
    }
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
        display: block !important;
    }
    iframe{
        margin: 0px !important;
        padding: 0px !important;
        border:none;
    }
</style>
<link href="{{asset('css/select2.min.css')}}" rel="stylesheet" />
<link href=" https://printjs-4de6.kxcdn.com/print.min.css" rel="stylesheet" />
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
                <th class="col">STATUS</th>
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
<script src="{{asset('js/select2.min.js')}}"></script>
<script src="https://printjs-4de6.kxcdn.com/print.min.js" crossorigin="anonymous"></script>
@include('api.tos')

@endsection
