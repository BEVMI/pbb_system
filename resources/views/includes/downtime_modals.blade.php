<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content" style="height: 140%;">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalPrintLongTitle" style="font-size:16px;">
                    DOWNTIME CREATE
                </h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="lines">LINE:</label>
                                <select onchange="hideall()" class="form-control" name="lines" id="lines">
                                    @foreach ($lines as $line)
                                        <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="shift_length_create">SHIFT LENGTH</label>
                                <input class="form-control" id="shift_length_create" type="number" min="0" value="0" >
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="form-group">
                                <label for="job_number">JOB</label>
                                <select onchange="hideall()" class="form-control" name="job_number" id="job_number">
                                    @foreach ($jobs as $job)
                                        <option value="{{$job}}">{{$job}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-4 col-6">
                            <div class="form-group">
                                <label for="downtime_date">DATE</label>
                                <input id="downtime_date" class="form-control" type="date" value="{{$initial_date}}">
                            </div>
                        </div>
                        <div class="col-sm-4 col-12">
                            <br>
                            <button class="btn btn-success w-100 mt-1" onclick="get_machines()">
                                CHOOSE
                            </button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-xl-12">
                          <div class="list-group" id="myList" role="tablist" style="flex-direction:row;">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#mcd" role="tab">
                                MACHINE DOWNTIME
                            </a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#exd" role="tab">
                                EXPECTED DOWNTIME
                            </a>
                            <a class="list-group-item list-group-item-action" data-toggle="list" href="#uexd" role="tab">
                                UNEXPECTED DOWNTIME
                            </a>
                          </div>
                        </div>
                        <div class="col-12 col-xl-12 mt-2">
                            <div class="tab-content">
                                <div class="tab-pane fade active show" id="mcd" role="tabpanel">
                                    @include('table_downtime.machine')
                                </div>
                                <div class="tab-pane fade" id="exd" role="tabpanel">
                                    @include('table_downtime.expected')
                                </div>
                                <div class="tab-pane fade" id="uexd" role="tabpanel">
                                    @include('table_downtime.unexpected')
                                </div>
                            </div>
                        </div>
                      </div>
                </div>
            </div>
            <div class="modal-footer">
                 <button id="hidden_button" onclick="create()" class="btn btn-success" style="display: none;">
                    CREATE
                 </button>
                <button class="btn btn-secondary" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>