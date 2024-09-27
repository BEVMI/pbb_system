<div class="modal fade" data-bs-backdrop='static' id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalUpdareCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="height: 140%;">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalPrintLongTitle" style="font-size:16px;">
                    DOWNTIME UPDATE
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <input type="hidden" id="update_id">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
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
                                <label for="shift_length_update">SHIFT LENGTH</label>
                                <input class="form-control" id="shift_length_update" type="number" min="0" value="0" >
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="downtime_date_update">DATE:</label>
                            <input class="form-control" id="downtime_date_update" type="date" value="{{$initial_date}}">
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="job_number_update">JOB</label>
                                <select class="form-control" name="job_number_update" id="job_number_update">
                                    @foreach ($jobs as $job)
                                        <option value="{{$job}}">{{$job}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-end">
                            <hr style="border:1px solid gray;">
                            <button class="badge bg-secondary">TOTAL MINUTES: <span id='irene3'>0</span></button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12">
                          <div class="list-group" id="myList1" role="tablist" style="flex-direction:row;">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#up_mcd" role="tab">
                                MACHINE DOWNTIME
                                <span id="mctotal_update" class="badge bg-secondary rounded-pill">0</span>
                            </a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#up_exd" role="tab">
                                EXPECTED DOWNTIME
                                <span id="extotal_update" class="badge bg-secondary rounded-pill">0</span>
                            </a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#up_uexd" role="tab">
                                UNEXPECTED DOWNTIME
                                <span id="uextotal_update" class="badge bg-secondary rounded-pill">0</span>
                            </a>
                          </div>
                        </div>
                        <div class="col-12 col-xl-12 mt-2">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="up_mcd" role="tabpanel">
                                    @include('table_downtime.machine_update')
                                </div>
                                <div class="tab-pane fade" id="up_exd" role="tabpanel">
                                    @include('table_downtime.expected_update')
                                </div>
                                <div class="tab-pane fade" id="up_uexd" role="tabpanel">
                                    @include('table_downtime.unexpected_update')
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
                 <button onclick="update()" class="btn btn-success">
                    UPDATE
                 </button>
                <button class="btn btn-secondary" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>