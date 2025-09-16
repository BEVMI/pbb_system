<div class="modal fade" data-bs-backdrop='static' id="viewCoa" tabindex="-1" role="dialog" aria-labelledby="viewCoaCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="viewCoaLongTitle" style="font-size:16px;">COA MODULE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                  <input id='tos_id_coa' type='hidden' value="">
                  <div id="qc_module" class="form-group">
                    
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-xl-12 col-lg-12">
                                <div class="container-fluid">
                                    <div class="row">
                                      <div class="col-12">
                                        <div id="alert" class="alert alert-info" style="color: white;">
                                        @if($user_auth->is_qc == 1)
                                            Please upload the COA document.
                                        @else
                                            @if($user_auth->is_qc == 1)
                                                Please upload the COA document.
                                            @else
                                                QC/QA has not yet uploaded the COA document.
                                            @endif
                                        @endif
                                        </div>
                                        <div id="success" class="alert alert-success" style="color: white;">COA document uploaded.</div>
                                      </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12 col-lg-12">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-8">
                                            <label id="label-coa" for="coa_number">UPLOAD COA </label>
                                            <input style="padding-top: 11px; padding-left: 20px;" accept=".pdf" id="coa_upload" class="form-control" type="file">
                                        </div>
                                        <div class="col-4 mt-2">
                                            <br>
                                            <button id="upload" onclick="uploadCoa()" class="btn btn-success mt-5 mt-xl-0" style=" width:100%;">
                                                SAVE
                                            </button> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="border: 1px solid #000;">
                            <div class="col-xl-12 col-lg-12">
                                <div class="container-fluid">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <a target="_blank" class="btn btn-primary" href="" style="width:100%;" id="print">DOWNLOAD</a>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <button class="btn btn-danger mt-2 mt-xl-0" style="width:100%;" data-bs-dismiss="modal" aria-label="Close">
                                                GO BACK
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                  </div>
                  
            </div>
            <div class="modal-footer">
             
            </div>
        </div>
    </div>
</div>