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

@endsection

@section('title') 
    USER MODULE
@endsection 

@section('subtitle')
    LIST OF USERS
@endsection

@section('breadcrumbs_1')
    User
@endsection

@section('breadcrumbs_2')
    List
@endsection

@section('button')
    <button class="btn btn-primary mt-2 mt-xl-0" data-bs-toggle="modal" data-bs-target="#modalCreate" style="width:100%;">CREATE USER</button> 
@endsection


@section('main')

{!! html()->modelForm(null, null)->class('form')->id('search')->attribute('action',route('users.index'))->attribute('method','GET')->open() !!}
{!! html()->closeModelForm() !!}

{!! html()->modelForm(null, null)->class('form')->id('store')->attribute('action',route('users.store'))->attribute('method','POST')->acceptsFiles()->open() !!}
{!! html()->closeModelForm() !!}

{!! html()->modelForm(null, null)->class('form')->id('update')->attribute('action',route('update_user'))->attribute('method','POST')->acceptsFiles()->open() !!}
{!! html()->closeModelForm() !!}


<div class="container-fluid" style="height: 70vh;">
    <div class="row">
        <div class="col-xl-7">

        </div>
        <div class="col-xl-3">
            {{ html()->label('SEARCH:')->attribute('style','font-weight:bold;')->attribute('for','search_user') }}
            {{ html()->text('search',$search)->placeholder('ENTER USER')->class('form-control ')->id('search_user')->attribute('style','font-weight:bold;')->attribute('form','search') }}
        </div>
        <div class="col-xl-2">
            <br>
            {{ html()->submit('SEARCH')->class('btn btn-outline-success btn-block loading_button')->attribute('form','search')->attribute('style','width:100%; margin-top:3px;') }}
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                    <thead class="text-center">
                        <th style="width:10%;">ACTION</th>
                        <th style="width:10%;">PHOTO</th>
                        <th style="width:10%;">SIGNATURE</th>
                        <th style="width:25%;">NAME</th>
                        <th style="width:15%;">EMAIL</th>
                        <th style="width:10%;">SUPERUSER</th>
                        <th style="width:10%;">ACTIVE</th>
                        <th style="width:10%;">WAREHOUSE</th>
                        <th style="width:10%;">QC</th>
                        <th style="width:10%;">PRODUCTION</th>
                        <th style="width:10%;">SUPERVISOR</th>
                        <th style="width:10%;">MANAGER</th>
                    </thead>  
                    <tbody class="text-center">
                        @if($users->isEmpty())
                        @else
                            @foreach ($users as $user)
                                <tr>
                                    <td style="vertical-align: middle;">
                                        <a href="#" class="btn btn-primary mt-2 mt-xl-0 show_data" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit"
                                            data-id="{!!$user->id!!}"
                                            data-name="{{$user->name}}"
                                            data-email="{{$user->email}}"
                                            data-admin="{{$user->is_admin}}"
                                            data-active="{{$user->is_active}}"
                                            data-warehouse="{{$user->is_warehouse}}"
                                            data-qc="{{$user->is_qc}}"
                                            data-production="{{$user->is_production}}"
                                            data-line1="{{$user->line_1}}"
                                            data-line2="{{$user->line_2}}"
                                            data-injection="{{$user->injection}}"
                                            data-is_pm="{{$user->is_pm}}"
                                            data-is_supervisor="{{$user->is_supervisor}}"
                                            data-is_manager="{{$user->is_manager}}"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <img style="border-radius: 50%;" src="{{asset('user_images')}}/{{$user->photo}}" width="75px" alt="">
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <img style="border-radius: 50%;" src="{{asset('signatures')}}/{{$user->signature}}" width="75px" alt="">
                                    </td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        @if($user->is_admin == 1)
                                            <span class="badge bg-success" style="font-weight: bold;"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                            <span class="badge bg-danger" style="font-weight: bold;"><i class="fa-solid fa-thumbs-down"></i></span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->is_active == 1)
                                            <span class="badge bg-success" style="font-weight: bold;"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                            <span class="badge bg-danger" style="font-weight: bold;"><i class="fa-solid fa-thumbs-down"></i></span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->is_warehouse == 1)
                                            <span class="badge bg-success" style="font-weight: bold;"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                            <span class="badge bg-danger" style="font-weight: bold;"><i class="fa-solid fa-thumbs-down"></i></span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->is_qc == 1)
                                            <span class="badge bg-success" style="font-weight: bold;"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                            <span class="badge bg-danger" style="font-weight: bold;"><i class="fa-solid fa-thumbs-down"></i></span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->is_production == 1)
                                            <span class="badge bg-success" style="font-weight: bold;"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                            <span class="badge bg-danger" style="font-weight: bold;"><i class="fa-solid fa-thumbs-down"></i></span>
                                        @endif
                                    </td>

                                    <td>
                                        @if($user->is_supervisor == 1)
                                            <span class="badge bg-success" style="font-weight: bold;"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                            <span class="badge bg-danger" style="font-weight: bold;"><i class="fa-solid fa-thumbs-down"></i></span>
                                        @endif
                                    </td>
                                    
                                    <td>
                                        @if($user->is_manager == 1)
                                            <span class="badge bg-success" style="font-weight: bold;"><i class="fa-solid fa-thumbs-up"></i></span>
                                        @else 
                                            <span class="badge bg-danger" style="font-weight: bold;"><i class="fa-solid fa-thumbs-down"></i></span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
                {{$users->render()}}
            </div>
        </div>
    </div>
</div>
<!-- Modal Create-->
<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">USER CREATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ html()->label('USER NAME:')->attribute('style','font-weight:bold;')->attribute('for','name') }}
                            {{ html()->text('name')->class('form-control')->id('name')->attribute('style','font-weight:bold;')->attribute('form','store') }}
                        </div>

                        <div class="form-group">
                            {{ html()->label('EMAIL:')->attribute('style','font-weight:bold;')->attribute('for','email') }}
                            {{ html()->email('email')->class('form-control')->id('email')->attribute('style','font-weight:bold;')->attribute('form','store') }}
                        </div>

                        <div class="form-group">
                            {{ html()->label('PASSWORD:')->attribute('style','font-weight:bold;')->attribute('for','password') }}
                            {{ html()->password('password')->class('form-control')->id('password')->attribute('style','font-weight:bold;')->attribute('form','store') }}
                        </div>
                        <div class="form-group">
                            {{ html()->label('UPLOAD PICTURE:')->attribute('style','font-weight:bold;')->attribute('for','photo') }}
                            {{ html()->file('photo')->class('form-control')->id('photo')->attribute('style','font-weight:bold;')->attribute('form','store') }}
                        </div>
                        <div class="form-group">
                            {{ html()->label('UPLOAD SIGNATURE:')->attribute('style','font-weight:bold;')->attribute('for','signature') }}
                            {{ html()->file('signature')->class('form-control')->id('signature')->attribute('style','font-weight:bold;')->attribute('form','store') }}
                        </div>
                    </div>    
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table irene-table">
                                <thead class="text-center">
                                    <tr>
                                        <th style="border-color: transparent;"></th>
                                        <th style="border-color: transparent;">YES</th>
                                        <th style="border-color: transparent;">NO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="irene-tr">
                                        <td colspan="3"><br></td>
                                    </tr>
                                    <tr class="irene-tr">
                                        <td>SUPER USER</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_admin" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_admin" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS ACTIVE</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_active" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_active" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS WAREHOUSE</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_warehouse" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_warehouse" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS QC</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_qc" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_qc" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS PRODUCTION</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_production" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_production" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>LINE 1</td>
                                        <td class="text-center"><input type="radio" form="store" name="line_1" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="line_1" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>LINE 2</td>
                                        <td class="text-center"><input type="radio" form="store" name="line_2" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="line_2" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>INJECTION</td>
                                        <td class="text-center"><input type="radio" form="store" name="injection" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="injection" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>PM</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_pm" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_pm" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>SUPERVISOR</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_supervisor" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_supervisor" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>MANAGER</td>
                                        <td class="text-center"><input type="radio" form="store" name="is_manager" value="1" checked></td>
                                        <td class="text-center"><input type="radio" form="store" name="is_manager" value="0"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-block" data-bs-dismiss="modal">CLOSE</button>
                {{ html()->submit('SAVE USER')->class('btn btn-outline-success btn-block loading_button')->attribute('form','store')->attribute('data-bs-toggle','modal')->attribute('data-bs-target','#modalManual2') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Update-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalEditLongTitle" style="font-size:16px;">USER UPDATE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ html()->hidden('update_id')->attribute('form','update')->attribute('id','update_id') }}
                            {{ html()->label('USER NAME:')->attribute('style','font-weight:bold;')->attribute('for','name_update') }}
                            {{ html()->text('name_update')->class('form-control')->id('name_update')->attribute('style','font-weight:bold;')->attribute('form','update') }}
                        </div>

                        <div class="form-group">
                            {{ html()->label('EMAIL:')->attribute('style','font-weight:bold;')->attribute('for','email_update') }}
                            {{ html()->email('email_update')->class('form-control')->id('email_update')->attribute('style','font-weight:bold;')->attribute('form','update') }}
                        </div>

                        <div class="form-group">
                            {{ html()->label('PASSWORD:')->attribute('style','font-weight:bold;')->attribute('for','password_update') }}
                            {{ html()->password('password_update')->class('form-control')->id('password_update')->attribute('style','font-weight:bold;')->attribute('form','update') }}
                        </div>

                        <div class="form-group">
                            {{ html()->label('UPLOAD PICTURE:')->attribute('style','font-weight:bold;')->attribute('for','update_photo') }}
                            {{ html()->file('update_photo')->class('form-control')->id('update_photo')->attribute('style','font-weight:bold;')->attribute('form','update') }}
                        </div>

                        <div class="form-group">
                            {{ html()->label('UPLOAD SIGNATURE:')->attribute('style','font-weight:bold;')->attribute('for','update_photo') }}
                            {{ html()->file('update_signature')->class('form-control')->id('update_signature')->attribute('style','font-weight:bold;')->attribute('form','update') }}
                        </div>

                    </div>    
                    <div class="col-sm-6">
                        <div class="table-responsive">
                            <table class="table irene-table">
                                <thead class="text-center">
                                    <tr>
                                        <th style="border-color: transparent;"></th>
                                        <th style="border-color: transparent;">YES</th>
                                        <th style="border-color: transparent;">NO</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="irene-tr">
                                        <td colspan="3"><br></td>
                                    </tr>
                                    <tr class="irene-tr">
                                        <td>SUPER USER</td>
                                        <td class="text-center"><input type="radio" id="admin_true" form="update" name="is_admin_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="admin_false" form="update" name="is_admin_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS ACTIVE</td>
                                        <td class="text-center"><input type="radio" id="active_true" form="update" name="is_active_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="active_false" form="update" name="is_active_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS WAREHOUSE</td>
                                        <td class="text-center"><input type="radio" id="warehouse_true" form="update" name="is_warehouse_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="warehouse_false" form="update" name="is_warehouse_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS QC</td>
                                        <td class="text-center"><input type="radio" id="qc_true" form="update" name="is_qc_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="qc_false" form="update" name="is_qc_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS PRODUCTION</td>
                                        <td class="text-center"><input type="radio" id="production_true" form="update" name="is_production_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="production_false" form="update" name="is_production_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>LINE 1</td>
                                        <td class="text-center"><input type="radio" id="line_1_true" form="update" name="line_1_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="line_1_false" form="update" name="line_1_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>LINE 2</td>
                                        <td class="text-center"><input type="radio" id="line_2_true" form="update" name="line_2_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="line_2_false" form="update" name="line_2_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>INJECTION</td>
                                        <td class="text-center"><input type="radio" id="injection_true" form="update" name="injection_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="injection_false" form="update" name="injection_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS PM</td>
                                        <td class="text-center"><input type="radio" id="is_pm_true" form="update" name="is_pm_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="is_pm_false" form="update" name="is_pm_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS SUPERVISOR</td>
                                        <td class="text-center"><input type="radio" id="is_supervisor_true" form="update" name="is_supervisor_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="is_supervisor_false" form="update" name="is_supervisor_update" value="0"></td>
                                    </tr>

                                    <tr class="irene-tr">
                                        <td>IS MANAGER</td>
                                        <td class="text-center"><input type="radio" id="is_manager_true" form="update" name="is_manager_update" value="1" checked></td>
                                        <td class="text-center"><input type="radio" id="is_manager_false" form="update" name="is_manager_update" value="0"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary btn-block" data-bs-dismiss="modal">CLOSE</button>
                {{ html()->submit('UPDATE USER')->class('btn btn-outline-success btn-block loading_button')->attribute('form','update')}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    @include('includes.form_error')
    <script>
        $(document).ready(function(){
            $(document).on('click', '.show_data', function (e) {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let email = $(this).data('email');
                let admin = $(this).data('admin');
                let active = $(this).data('active');
                let warehouse = $(this).data('warehouse');
                let qc = $(this).data('qc');
                let production = $(this).data('production');
                let line_1 = $(this).data('line1');
                let line_2 = $(this).data('line2');
                let injection = $(this).data('injection');
                let is_pm = $(this).data('is_pm'); 
                let is_supervisor = $(this).data('is_supervisor');
                let is_manager = $(this).data('is_manager');
                console.log(is_manager+'-'+is_pm);
                $('#update_id').val(id);
                $('#name_update').val(name);
                $('#email_update').val(email);

                if(admin === 1){
                    $("#admin_true").prop("checked", true);
                    $("#admin_false").prop("checked", false);
                }else{
                    $("#admin_true").prop("checked", false);
                    $("#admin_false").prop("checked", true);
                }

                if(active === 1){
                    $("#active_true").prop("checked", true);
                    $("#active_false").prop("checked", false);
                }else{
                    $("#active_true").prop("checked", false);
                    $("#active_false").prop("checked", true);
                }

                if(warehouse === 1){
                    $("#warehouse_true").prop("checked", true);
                    $("#warehouse_false").prop("checked", false);
                }else{
                    $("#warehouse_true").prop("checked", false);
                    $("#warehouse_false").prop("checked", true);
                }

                if(qc === 1){
                    $("#qc_true").prop("checked", true);
                    $("#qc_false").prop("checked", false);
                }else{
                    $("#qc_true").prop("checked", false);
                    $("#qc_false").prop("checked", true);
                }

                if(production === 1){
                    $("#production_true").prop("checked", true);
                    $("#production_false").prop("checked", false);
                }else{
                    $("#production_true").prop("checked", false);
                    $("#production_false").prop("checked", true);
                }

                if(line_1 === 1){
                    $("#line_1_true").prop("checked", true);
                    $("#line_1_false").prop("checked", false);
                }else{
                    $("#line_1_true").prop("checked", false);
                    $("#line_1_false").prop("checked", true);
                }

                if(line_2 === 1){
                    $("#line_2_true").prop("checked", true);
                    $("#line_2_false").prop("checked", false);
                }else{
                    $("#line_2_true").prop("checked", false);
                    $("#line_2_false").prop("checked", true);
                }

                if(injection === 1){
                    $("#injection_true").prop("checked", true);
                    $("#injection_false").prop("checked", false);
                }else{
                    $("#injection_true").prop("checked", false);
                    $("#injection_false").prop("checked", true);
                }

                if(is_pm === 1){
                    console.log('irene1');
                    $("#is_pm_true").prop("checked", true);
                    $("#is_pm_false").prop("checked", false);
                }else{
                    $("#is_pm_true").prop("checked", false);
                    $("#is_pm_false").prop("checked", true);
                }

                if(is_supervisor === 1){
                    $("#is_supervisor_true").prop("checked", true);
                    $("#is_supervisor_false").prop("checked", false);
                }else{
                    $("#is_supervisor_true").prop("checked", false);
                    $("#is_supervisor_false").prop("checked", true);
                }

                if(is_manager === 1){
                    $("#is_manager_true").prop("checked", true);
                    $("#is_manager_false").prop("checked", false);
                }else{
                    $("#is_manager_true").prop("checked", false);
                    $("#is_manager_false").prop("checked", true);
                }
            });
        });
    </script>
@endsection