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
    APPROVER LEVEL MODULE
@endsection 

@section('subtitle')
    LIST OF APPROVER LEVEL
@endsection

@section('breadcrumbs_1')
    Approver Level
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')

@endsection


@section('main')
{!! html()->modelForm(null, null)->class('form')->id('update')->attribute('action',route('approver_level.update'))->attribute('method','GET')->open() !!}
{!! html()->closeModelForm() !!}
<div class="container-fluid">
    <div class="row">
        <div class="table-responsive">
            <table class="table">
                <thead class="text-center">
                    <th style="width: 10%;">ID</th>
                    <th style="width: 50%;">NAME</th>
                    <th style="width: 20%;">LEVEL</th>
                    <th style="width: 20%;">ACTION</th>
                </thead>
                <tbody>
                    @foreach ($levels as $level)
                        <tr class="text-center">
                            <td>{{$level->id}}</td>
                            <td>{{$level->User->name}}</td>
                            <td>{{$level->level}}</td>
                            <td style="vertical-align: middle;">
                                <a href="#" class="btn btn-primary mt-2 mt-xl-0 show_data" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#modalEdit"
                                    data-id="{!!$level->id!!}"
                                    data-level="{!!$level->level!!}"
                                >
                                    <i class="fas fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalEditLongTitle" style="font-size:16px;">LEVEL UPDATE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='row'>
                    {{ html()->hidden('update_id')->attribute('form','update')->attribute('id','update_id') }}
                    {{ html()->hidden('update_level')->attribute('form','update')->attribute('id','update_level') }}
                    <div class="form-group">
                        <label for="user">USER</label>
                        <select form="update" class="form-control" name="approver" id="user">
                            @foreach ($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach        
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-block" data-bs-dismiss="modal">CLOSE</button>
                {{ html()->submit('UPDATE LEVEL')->class('btn btn-outline-success btn-block loading_button')->attribute('form','update')}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function(){
        $(document).on('click', '.show_data', function (e) {
            let id = $(this).data('id');
            let level = $(this).data('level');
            document.getElementById('update_id').value = id;
            document.getElementById('update_level').value = level;
        });
    });
</script>
@endsection