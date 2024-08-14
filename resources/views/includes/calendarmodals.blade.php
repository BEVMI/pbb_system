<!-- Modal Type-->
<div class="modal fade" id="modalCreate"  role="dialog" aria-labelledby="modalCreateCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document" style="max-width: 1366px;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold badge badge-primary" id="modalCreateLongTitle" style="font-size:16px;">PREV. MAINTENANCE CREATION</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class='row'>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="name">NAME:</label>
                            <input id="name" form="create" class="form-control" type="text" name="name">
                        </div>
                        <div class="form-group">
                           <label for="location_id">LOCATION:</label>
                           <select id="location_id" class="form-control" form="create" name="location_id"></select>
                        </div>

                        <div class="form-group">
                            <label for="frequency_id">FREQUENCY:</label>
                            <select id="frequency_id" class="form-control" form="create" name="frequency_id"></select>
                        </div>

                        <div class="form-group">
                            <label for='inventory_id'>INVENTORY:</label>
                            <select id="inventory_id" class="form-control" form="create" name="inventory_id"></select>
                        </div>

                        <div class="form-group">
                            <label for="company_id">COMPANY:</label>
                            {{ html()->select('company_id',$companies,null)->class('form-control')->id('company_id')->attribute('form','create') }}
                        </div>

                        <div class="form-group">
                            <label for="assigned">ASSIGNED:</label>
                            <input id="assigned" type="text" class="form-control" form="create" name="assigned">
                        </div>

                        <div class="form-group">
                            <label for="month">MONTH:</label>
                            <select form="create" class="form-control" name="month" id="month">
                                <option value="01">JAN</option>
                                <option value="02">FEB</option>
                                <option value="03">MAR</option>
                                <option value="04">APRIL</option>
                                <option value="05">MAY</option>
                                <option value="06">JUN</option>
                                <option value="07">JUL</option>
                                <option value="08">AUG</option>
                                <option value="09">SEPT</option>
                                <option value="10">OCT</option>
                                <option value="11">NOV</option>
                                <option value="12">DEC</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="year">YEAR:</label>
                            <select form="create" class="form-control" name="year" id="year">
                                @for ($x = 2024; $x <= 2099 ; $x++)
                                    <option value='{!!$x!!}'>{!!$x!!}</option>
                                @endfor
                            </select>
                        </div>
                        
                    </div>    

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="remarks1">Remarks1:</label>
                            <textarea form="create" class="form-control" name="remarks1" id="remarks1"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="remarks2">Remarks2:</label>
                            <textarea form="create" class="form-control" name="remarks2" id="remarks2"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="remarks3">Remarks3:</label>
                            <textarea form="create" class="form-control" name="remarks3" id="remarks3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="remarks4">Remarks4:</label>
                            <textarea form="create" class="form-control" name="remarks4" id="remarks4"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="remarks5">Remarks5:</label>
                            <textarea form="create" class="form-control" name="remarks5" id="remarks5"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <table class="table">
                            <thead class="text-center">
                                <th style="width: 60%;"></th>
                                <th style="width: 20%;">YES</th>
                                <th style="width: 20%;">NO</th>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>CUSTOM DATE</td>
                                    <td><input type="radio" form="create" name="custom_date" onchange="irene(1)" value="1"></td>
                                    <td><input type="radio" form="create" name="custom_date" onchange="irene(0)" value="0" checked></td>
                                </tr>
                            </tbody>
                        </table>

                        <table id="table-now" class="table">
                            <thead class="text-center">
                                <th style="width: 60%;"></th>
                                <th style="width: 20%;">YES</th>
                                <th style="width: 20%;">NO</th>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>ONE TIME</td>
                                    <td><input type="radio" form="create" name="is_onetime" value="1"></td>
                                    <td><input type="radio" form="create" name="is_onetime" value="0" checked></td>
                                </tr>

                                <tr class="text-center">
                                    <td>WEEK FROM</td>
                                    <td colspan="2">
                                        <select form="create" class="form-control" name="week_from" id="week_form">
                                            <option value="0">1st WEEK</option>
                                            <option value="1">2nd WEEK</option>
                                            <option value="2">3rd WEEK</option>
                                            <option value="3">4th WEEK</option>
                                        </select>
                                    </td>
                                </tr>

                                <tr class="text-center">
                                    <td>WEEK TO</td>
                                    <td colspan="2">
                                        <select form="create" class="form-control" name="week_to" id="week_to">
                                            <option value="0">1st WEEK</option>
                                            <option value="1">2nd WEEK</option>
                                            <option value="2">3rd WEEK</option>
                                            <option value="3">4th WEEK</option>
                                        </select>
                                    </td>
                                </tr>

                               
                            </tbody>
                        </table>

                        <table id="table-now-2" class="table" style="display: none;">
                            <thead class="text-center">
                                <th style="width: 60%;"></th>
                                <th style="width: 40%;">DATES</th>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td>DATE FROM</td>
                                    <td><input class="form-control" type="date" form="create" name="date_form"></td>
                                </tr>

                                <tr class="text-center">
                                    <td>DATE TO</td>
                                    <td><input class="form-control" type="date" form="create" name="date_to"></td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">CLOSE</button>
                {{ html()->submit('SAVE SCHEDULE')->id('create_type_button')->class('btn btn-outline-success')->attribute('form','create')->attribute('data-bs-toggle','modal')->attribute('data-bs-target','#modalManual2') }}
            </div>
        </div>
    </div>
</div>
