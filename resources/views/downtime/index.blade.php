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
    .list-group-item.active {
        z-index: 2;
        color: white;
        background-color: #212529;
        border-color: #212529;
    }
</style>
@endsection

@section('title') 
    DOWNTIME MODULE
@endsection 

@section('subtitle')
    LIST OF DOWNTIME
@endsection

@section('breadcrumbs_1')
    DOWNTIME
@endsection

@section('breadcrumbs_2')
    LIST
@endsection

@section('button')
<button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;">CREATE</button> 
@endsection

@section('main')

@include('includes.downtime_modals')
@endsection

@section('scripts')
@include('api.downtime')
@endsection