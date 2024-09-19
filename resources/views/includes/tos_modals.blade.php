<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">TOS CREATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table text-center" id="table" style="font-size: 12px;">
                            <thead class="irene_thead" >
                                <th style="width: 10%;">JOB#</th>
                                <th style="width: 10%;">STOCK CODE</th>
                                <th style="width: 10%;">REFERENCE#</th>
                                <th style="width: 10%;">LOT #</th>
                                <th style="width: 5%;">CASE</th>
                                <th style="width: 40%;">PALLETS</th>
                                <th style="width: 15%;">COA REF#</th>
                            </thead>
                            <tbody id="tosTable" class="text-center font-weight-bold">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal" aria-label="Close">
                    CLOSE
                </button>
                <button onclick="saveTos()" class="btn btn-success">
                    SAVE
                </button> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop='static' id="modalPallet" tabindex="-1" role="dialog" aria-labelledby="modalPalletCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  font-weight-bold badge bg-primary" id="modalPalletLongTitle" style="font-size:16px;">CHOOSE QTY</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="table-responsive">
                        <input type="hidden" id="ref_num" value="">
                        <table class="table text-center" id="table">
                            <thead class="irene_thead" >
                                <th><input type="checkbox" name="select-all" id="select-all" /></th>
                                <th>PALLETS</th>
                                <th>CASES</th>
                            </thead>
                            <tbody id="palletTable" class="text-center font-weight-bold">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="goBack()" type="button" class="btn btn-danger">
                    GO BACK
                </button>
                <button id="savePallet" onclick="savePallet()" class="btn btn-success">
                    CHOOSE
                </button> 
            </div>
        </div>
    </div>
</div>


<div class="modal fade" data-bs-backdrop='static' id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="modalEditCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">TOS UPDATE</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="table-responsive">
                        <input type="hidden" id="tos_id_update">
                        <table class="table text-center" id="table" style="font-size: 12px;">
                            <thead class="irene_thead" >
                                <th style="width: 10%;">JOB#</th>
                                <th style="width: 10%;">STOCK CODE</th>
                                <th style="width: 10%;">REFERENCE#</th>
                                <th style="width: 10%;">LOT #</th>
                                <th style="width: 5%;">CASE</th>
                                <th style="width: 40%;">PALLETS</th>
                                <th style="width: 15%;">COA REF#</th>
                            </thead>
                            <tbody id="tosUpdateTable" class="text-center font-weight-bold">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary " data-bs-dismiss="modal" aria-label="Close">
                    CLOSE
                </button>
                <button onclick="updateSaveTos()" class="btn btn-success">
                    UPDATE
                </button> 
            </div>
        </div>
    </div>
</div>

<div class="modal fade" data-bs-backdrop='static' id="modalPalletUpdate" tabindex="-1" role="dialog" aria-labelledby="modalPalletUpdateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title  font-weight-bold badge bg-primary" id="modalPalletUpdateLongTitle" style="font-size:16px;">CHOOSE QTY</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <div class="table-responsive">
                        <input type="hidden" id="ref_num_update" value="">
                        <table class="table text-center" id="table">
                            <thead class="irene_thead" >
                                <th><input type="checkbox" name="select-all-update" id="select-all-update" /></th>
                                <th>PALLETS</th>
                                <th>CASES</th>
                            </thead>
                            <tbody id="palletTableUpdate" class="text-center font-weight-bold">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button onclick="goBack2()" type="button" class="btn btn-danger">
                    GO BACK
                </button>
                <button onclick="saveUpdatePallet()" class="btn btn-success">
                    CHOOSE
                </button> 
            </div>
        </div>
    </div>
</div>