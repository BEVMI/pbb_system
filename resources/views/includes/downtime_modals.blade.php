<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
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
                        <div class="col-12">
                            <div class="row">
                               
                                <div class="col-12 col-lg-3 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="lines">LINE:</label>
                                        <select onchange="hideall()" class="form-control" name="lines" id="lines">
                                            @foreach ($lines as $line)
                                                <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-xl-1 col-md-6">
                                    <div class="form-group">
                                        <label for="job_number">JOB</label>
                                        <select onchange="hideall()" class="form-control" name="job_number" id="job_number">
                                            @foreach ($jobs as $job)
                                                <option value="{{$job}}">{{$job}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="shift_length_search">SHIFT LENGTH</label>
                                        <input class="form-control" id="shift_length_create" onkeyup="irene(0)" type="number" min="0" value="0" >
                                    </div>
                                </div>
                                <div class="col-12 col-lg-2 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="job_date">DATE:</label>
                                        <input onchange="hideall()" id="job_date" class="form-control" type="date" value="{{$initial_date}}">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-2 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="job_date">FBO:</label>
                                        <input class="form-control" type="time" id="FBO" name="appt">
                                    </div>
                                </div>

                                <div class="col-12 col-lg-2 col-xl-2 col-md-6">
                                    <div class="form-group">
                                        <label for="job_date">LBO:</label>
                                        <input class="form-control" type="time" id="LBO" name="appt">
                                    </div>
                                </div>
                               
                                <div class="col-12 col-lg-2 col-xl-1 col-md-6">
                                    <br>
                                    <button class="btn btn-success w-100 mt-1" onclick="get_machines()">
                                        <i class="fa-solid fa-arrow-right-to-bracket"></i>
                                    </button>
                                </div>
                                <div class="col-12">
                                    <hr style="border:1px solid gray;">
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-7 col-lg-7 col-md-7 col-sm-6 col-12">
                            @include('downtime_data.data_create_total')
                        </div>
                        <div class="col-xl-5 col-lg-5 col-md-5 col-sm-6 col-12">
                            @include('downtime_data.data_create')
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