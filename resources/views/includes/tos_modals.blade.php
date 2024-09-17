<div class="modal fade" data-bs-backdrop='static' id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge bg-primary" id="modalCreateLongTitle" style="font-size:16px;">TOS CREATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">  
                <div class="container-fluid">
                    <table class="table text-center" id="table">
                        <thead class="irene_thead" >
                            <th>JOB#</th>
                            <th>STOCK CODE</th>
                            <th>LOT #</th>
                            <th>PALLET CASE</th>
                            <th>TOS QTY</th>
                            <th>COA REF#</th>
                        </thead>
                        <tbody id="tosTable" class="text-center font-weight-bold">
                            
                        </tbody>
                    </table>
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