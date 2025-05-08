<div class="modal fade" data-bs-backdrop='static' id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered irene_modal"  role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">COUNTER UPDATE</h5>
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-8">

                        </div>
                        <div class="col-xl-2">
                            <button id="post_counter" onclick="updateAll()" class="btn btn-success mt-2 mt-xl-0" style="width:100%;">
                                UPDATE
                            </button> 
                        </div>
                        <div class="col-xl-2">
                            <button class="btn btn-outline-secondary" class="close" data-bs-dismiss="modal" aria-label="Close" style="width:100%; ">
                                CLOSE
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-4">
                            <div class="card text-center">
                                <div class="font-weight-bold card-header bg-primary text-white">
                                    MACHINE COUNTER
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input type="hidden" id="hidden_header_id">
                                                    <label for="lines_update">LINE:</label>
                                                    <select class="form-control" name="lines_update" id="lines_update">
                                                        @foreach ($lines as $line)
                                                            <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="job_number_update">JOB</label>
                                                    <select class="form-control" name="job_number_update" id="job_number_update">
                                                        @foreach ($jobs as $job)
                                                            <option value="{{$job->value}}">{{$job->text}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="iLossPalletUpdate">LOSS CASE</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="iLossPalletUpdate" id="iLossPalletUpdate">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <label for="lines">COUNTER DATE:</label>
                                                <input class="form-control" id="date_update" type="date">
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="job_date">FBO:</label>
                                                    <input class="form-control" type="time" id="FBO_update" name="appt">
                                                </div>
                                            </div>
                    
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="job_date">LBO:</label>
                                                    <input class="form-control" type="time" id="LBO_update" name="appt">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead class="irene_thead text-center">
                                                            <th class="col" style="width:50%;">SECTION</th>
                                                            <th class="col" style="width:25%;">IN</th>
                                                            <th class="col" style="width:25%;">OUT</th>
                                                        </thead>
                                                        <tbody id="counter_body_update" class="text-center" style="font-size: 11px;">
                    
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card text-center">
                                <div class="font-weight-bold card-header bg-primary text-white">
                                    DOWNTIME
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="shift_length">SHIFT LENGTH</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="shiftLength" id="shiftLength_update">
                                                </div>
                                            </div>

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="shift_length">FG CASES</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="dFgCases" id="dFgCases_update">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                @include('downtime_data.data_update')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4">
                            <div class="card text-center">
                                <div class="font-weight-bold card-header bg-primary text-white">
                                    REJECTS
                                </div>
                                <div class="card-body">
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="iLossPalletReject">LOSS CASE</label>
                                                    <input type="number" value="0" min="0" max="99999" class="form-control" name="iLossPalletReject_update" id="iLossPalletReject_update">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="table-reponsive">
                                                            <table class="table">
                                                                <thead class="irene_thead text-center">
                                                                    <th class="col">SECTION</th>
                                                                    <th class="col">MATERIALS</th>
                                                                    <th class="col">QTY</th>
                                                                </thead>
                                                                <tbody id="reject_body_update" class="text-center" style="font-size: 11px;">
                            
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>