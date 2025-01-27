<div class="modal fade" data-bs-backdrop='static' id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-12 col-lg-3 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="lines_update">LINE:</label>
                                        <select class="form-control" name="lines_update" id="lines_update">
                                            @foreach ($lines as $line)
                                                <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="job_number_update">JOB</label>
                                        <select class="form-control" name="job_number_update" id="job_number_update" onmousedown="(function(e){ e.preventDefault(); })(event, this)">
                                            @foreach ($jobs as $job)
                                                <option value="{{$job}}">{{$job}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="shift_length_update">SHIFT LENGTH</label>
                                        <input type="hidden" id="update_id">
                                        <input class="form-control" id="shift_length_update" onkeyup="irene(1)" type="number" min="0" value="0" >
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="downtime_date_update">DOWNTIME DATE</label>
                                        <input id="downtime_date_update" class="form-control" type="date">
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="job_date">FBO:</label>
                                        <input class="form-control" type="time" id="FBO_update" name="appt">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-2 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="job_date">LBO:</label>
                                        <input class="form-control" type="time" id="LBO_update" name="appt">
                                    </div>
                                </div>

                                <div class="col-12">
                                    <hr style="border:1px solid gray;">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-6 col-12">
                            @include('downtime_data.data_update_total')
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-12">
                            @include('downtime_data.data_update')
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                 <button id="hidden_button" onclick="update()" class="btn btn-success">
                    UPDATE
                 </button>
                <button class="btn btn-secondary" type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    CLOSE
                </button>
            </div>
        </div>
    </div>
</div>