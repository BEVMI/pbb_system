<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">JOB CREATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid" style="padding-left: 0px; padding-right:0px;">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="job_number">JOB NUMBER:</label>
                                <input onkeyup="hideJob()" class="form-control" id="job_number" type="number" name="job_number">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <br>
                                <button onclick="verifyJob()" class="btn btn-outline-success" style="margin-top:2px; width:100%;">VERIFY</button>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="job_section" style="display: none;">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="stock_code">STOCK CODE</label>
                                <input class="form-control" id="stock_code" readonly type="text">
                            </div>
                        </div>
                        <div class="col-4"></div>
                    
                    </div>
                    <div class="row" id="job_section_1" style="display: none;">
                        <div class="col-8">
                            <div class="form-group">
                                <label for="qty_to_make">QTY TO MAKE</label>
                                <input class="form-control" id="qty_to_make" readonly type="number">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <br>
                                <button id="job_button" class="btn btn-success" style="margin-top:3px; width:100%;" onclick="job_creation()">JOB CREATE</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{-- <button onclick="()" class="btn btn-success mt-2 mt-xl-0"style="width:100%;">
                  
                </button>  --}}
            </div>
        </div>
    </div>
</div>