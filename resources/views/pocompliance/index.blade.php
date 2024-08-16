@extends('layouts.main')

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
    PO COMPIANCE MODULE
@endsection 

@section('subtitle')
    LIST OF PO COMPLIANCE
@endsection

@section('breadcrumbs_1')
    PO COMPLIANCE
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
            <label for="months">MONTH FILTER</label>
            <select class="form-control" id="months">
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
                <label for="year">YEAR</label>
                <input class="form-control" id='year_now' type="number" value="{{$year_now}}">
            </div>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <label for="year">STATUS</label>
            <select class="form-control" name="status" id="status">
                <option value="">ALL</option>
                <option value="9">COMPLETED</option>
                <option value="S">SUSPEND</option>
                <option value="O">OPEN PO</option>
            </select>
        </div>
        <div class="col-xl-2 col-lg-3 col-sm-6 col-12">
            <br>
            {{ html()->submit('FILTER')->class('btn btn-outline-success btn-block loading_button')->attribute('style','width:100%; margin-top:3px;') }}
        </div>

        <div class="row">
            <div class="col-12">
                <div class="table-responsive"  style="height:60vh; overflow:auto;">
                    <table class="table text-center">
                        <thead class="irene_thead">
                            <th>SalesOrder</th>
                            <th>Customer</th>
                        </thead>
                        <tbody id="get_header_po">
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@include('api.pocompliance')
@endsection