<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">REJECT CREATION</h5>
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
                                <select onchange="hideFields()" class="form-control" name="lines" id="lines">
                                    @foreach ($lines as $line)
                                        <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="job_number">JOB</label>
                                <input onkeyup="hideFields()" class="form-control" id="job_number" type="text" value="">
                            </div>
                        </div>
                        <div class="col-6">
                            <label for="lines">LOSS CASE:</label>
                            <input class="form-control" id="lost_case" type="number" min="0" value="0">
                        </div>
                        <div class="col-6">
                            <br>
                            <button onclick="choose_line()" class="btn btn-outline-success" style="margin-top:3px; width:100%;">CHOOSE</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-reponsive">
                                <table class="table">
                                    <thead class="irene_thead text-center">
                                        <th class="col">SECTION</th>
                                        <th class="col">MATERIALS</th>
                                        <th class="col">QTY</th>
                                    </thead>
                                    <tbody id="reject_body" class="text-center">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="post_reject" onclick="postReject()" class="btn btn-success mt-2 mt-xl-0" style="display:none;">
                    SAVE REJECT
                </button> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="modalViewCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalViewLongTitle" style="font-size:16px;">REJECT UPDATE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="lines">LINE:</label>
                                <select class="form-control" id="lines_update">
                                    @foreach ($lines as $line)
                                        <option value="{{$line->id}}">{{$line->cDescription}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label for="job_number_update">JOB</label>
                                <input class="form-control" id="job_number_update" type="text" value="">
                            </div>
                        </div>
                        <div class="col-4">
                            <label for="lines">LOSS CASE:</label>
                            <input class="form-control" id="lost_case_update" type="number" min="0" value="0">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-reponsive">
                                <table class="table">
                                    <thead class="irene_thead text-center">
                                        <th class="col">SECTION</th>
                                        <th class="col">MATERIALS</th>
                                        <th class="col">QTY</th>
                                    </thead>
                                    <tbody id="reject_body_update" class="text-center">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="post_reject" onclick="updateReject()" class="btn btn-success mt-2 mt-xl-0" style="display:none;">
                    UPDATE REJECT
                </button> 
            </div>
        </div>
    </div>
</div>