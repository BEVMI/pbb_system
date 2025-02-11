<script>
 
</script>
<script>
    load();
    function refresh(){
        ifvisible.off('idle');
        ifvisible.setIdleDuration('{!!$idletime!!}'); // Page will become idle after 120 seconds
        ifvisible.on("idle", function(){
           load();
        });

    }
    function load(){
        $(document).ready(function(){
            let month = document.getElementById('month_now').value;
            let year = document.getElementById('year_now').value;
            getTosHeader(month,year);
        });
    }
   
    function getTosHeader(month,year){
        Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
        $('#tos_body_table').empty();
        ifvisible.off('idle');
        
        refresh();

        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/TOS/GetTOSHeader?nYear='+year+'&nMonth='+month,
            success: function (data) {
                irene_parse = JSON.parse(data);
              
                console.log(irene_parse);
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('tos_body_table').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    let print = '<button class="btn btn-primary" onclick="printTos('+item.id+')" style="margin:0;"><i class="fa-solid fa-print"></i></button> &nbsp;';
                    let edit = '<button class="btn btn-success" onclick="updateTos('+item.id+')" style="margin:0;"><i class="fa-solid fa-pencil"></i></button> &nbsp;';
                    let remove = '<button class="btn btn-danger" onclick="confirmDeleteTos('+item.id+')" style="margin:0;"><i class="fa-solid fa-trash"></i></button>';

                    i.innerHTML = item.cTOSRefNo;
                    r.innerHTML = formatDate(item.dDate);
                    e.innerHTML = item.cCreatedBy;
                    n.innerHTML = print+edit+remove;

                }); 
            }
        });
    }

    function search(){
        load();
    }
</script>

<script>
    function loadForTos(){
     
        $('#tosTable').empty();
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/TOS/GetForTOS',
            success: function (data) {
                
                irene_parse = JSON.parse(data);
                if(irene_parse.length===0){
                    document.getElementById('save_button').style.display = 'none';
                }
                else{
                    document.getElementById('save_button').style.display = 'non';
                    $.each(irene_parse, function(index,item) {
                        var x = document.getElementById('tosTable').insertRow(-1);
                        var i = x.insertCell(0);
                        var r = x.insertCell(1);
                        var e = x.insertCell(2);
                        var n = x.insertCell(3);
                        var j = x.insertCell(4);
                        var o = x.insertCell(5);
                        var y = x.insertCell(6);

                        i.innerHTML = item.iJobNo;
                        r.innerHTML = item.cStockCode;  
                        e.innerHTML = item.RefNo;  
                        n.innerHTML = item.cLotNumber;
                        j.innerHTML = item.iCases;    
                        o.innerHTML = "<div class='container'><div class='row'><div class='col-9' style='margin:auto;'><select id='P-"+item.RefNo+"' name='iPallet[]' class='form-control ireneajax' multiple></select></div><div class='col-3' style='margin:auto;'><button onclick=pallets('"+item.RefNo+"') class='btn btn-warning' style='margin:auto;'><i class='fa-solid fa-arrows-spin'></i></button></div></div></div>";      
                        y.innerHTML = '<input name="lot_number[]" type="hidden" value="'+item.cLotNumber+'"><input name="coa[]" class="form-control" type="text"> <input name="iCasesCheck[]" type="hidden" value="'+item.iCases+'" >';   
                        
                        $( ".ireneajax" ).select2({
                            
                        });
                        $(".ireneajax").prop("disabled", true);
                    });
                }
                
            }
        });
    }
  
</script>
<script>
    function saveTos(){
        document.getElementById("save_button").disabled = true;
        let coas = document.querySelectorAll("input[name^='coa[']");
        let lot_number = document.querySelectorAll("input[name^='lot_number[']");
        let pallets = document.querySelectorAll("select[name^='iPallet[']");
        let dTurnOverDate = "{{$initial_date}}";
        let user_auth = "{{$user_auth->id}}";
        let details = [];
        let pallet_details = [];
        let check_count = [];
        for (var i = 0; i <lot_number.length; i++) {
            let coas_post=coas[i].value;
            let lot_number_post = lot_number[i].value;
            let pallets_check = pallets[i]; 
            if(pallets_check.length !== 0){
                for (var v = 0; v <pallets_check.length; v++) {
                        pallet_details.push({
                            "id":pallets_check[v].value,
                            "cPalletRef":pallets_check[v].innerHTML
                        }
                    );
                }
                
                details.push({
                    "nQty":0,
                    "iCases": 0,
                    "cLotNumber":lot_number_post,
                    "cCoaRefNo":coas_post,
                    "palletDetails":pallet_details
                });   
                check_count.push(1);
            }
            pallet_details=[];
        }
        if(check_count ===0){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "ONLY 5 MAXIMUM BATCHS",
                showConfirmButton: false,
                timer: 2000
            });
        }else{
            $.ajax({
                async:false,
                type:'POST',
                method:'POST',
                url:api_url+'/TOS/UpdateTOSPallet',
                crossDomain: true,
                dataType: 'json',
                contentType: 'application/json',
                data:JSON.stringify({
                    "id": 0,
                    "dTurnOverDate": dTurnOverDate,
                    "iUserId": user_auth,
                    "details":details
                }),
                success:function(data){
                    $('#modalCreate').modal('hide');
                    document.getElementById("save_button").disabled = false;
                    details=[];
                    check_count=[];
                    load();
                },
                error: function(e) {
                    console.log(e);
                }
            });
        }
    }

    function updateSaveTos(){
        let coas = document.querySelectorAll("input[name^='coaUpdate[']");
        let lot_number = document.querySelectorAll("input[name^='lot_number_update[']");
        let pallets = document.querySelectorAll("select[name^='iPalletUpdate[']");
        let dTurnOverDate = "{{$initial_date}}";
        let user_auth = "{{$user_auth->id}}";
        console.log(user_auth);
        let details_update = [];
        let pallet_details_update = [];
        let id = document.getElementById('tos_id_update').value;

        for (var i = 0; i <lot_number.length; i++) {
            let coas_post=coas[i].value;
            let lot_number_post = lot_number[i].value;
            let pallets_check = pallets[i]; 
            if(pallets_check.length !== 0){
                for (var v = 0; v <pallets_check.length; v++) {
                        pallet_details_update.push({
                            "id":pallets_check[v].value,
                            "cPalletRef":pallets_check[v].innerHTML
                        }
                    );
                }
                
                details.push({
                    "nQty":0,
                    "iCases": 0,
                    "cLotNumber":lot_number_post,
                    "cCoaRefNo":coas_post,
                    "palletDetails":pallet_details_update
                });   
                
            }
            pallet_details_update=[];
        }
        
        $.ajax({
            async:false,
            type:'POST',
            method:'POST',
            url:api_url+'/TOS/UpdateTOSPallet',
            crossDomain: true,
            dataType: 'json',
            contentType: 'application/json',
            data:JSON.stringify({
                "id": id,
                "dTurnOverDate": dTurnOverDate,
                "iUserId": user_auth,
                "details":details
            }),
            success:function(data){
                $('#modalEdit').modal('hide');
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "UPDATED SUCCESSFULLY",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(function(){ 
                    updateTos(id);
                    load();
                }, 2000);
            },
            error: function(e) {
                console.log(e);
            }
        });
    }
</script>

<script>
    function pallets(ref){
        $('#select-all').prop('checked', false);
        $('#modalCreate').modal('hide');
        $('#modalPallet').modal('show');
        $('#palletTable').empty();
        document.getElementById('ref_num').value = ref;
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+ref+'&cStatus=Approved',
            success: function (data) {
                irene_parse = JSON.parse(data);
                
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('palletTable').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);

                    i.innerHTML = "<input type='checkbox' class='checkboxes' value='"+item.id+"~"+item.cPalletRef+"'>";
                    r.innerHTML = item.cPalletRef; 
                    e.innerHTML = item.iCases; 
                 
                              
                });
            }
        });
    }

    function palletsUpdate(ref){
        $('#modalPalletUpdate').modal('show');
        $('#modalEdit').modal('hide');
        $('#palletTableUpdate').empty();
        $('#select-all-update').prop('checked', false);
        document.getElementById('ref_num_update').value = ref;
        
        var pallet_details = $('#UP-'+ref).select2('data'); 
        pallet_details.forEach(function (item2) { 
            var x = document.getElementById('palletTableUpdate').insertRow(-1);
            var i = x.insertCell(0);
            var r = x.insertCell(1);
            var e = x.insertCell(2);
            $.ajax({
                async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/GetPallet?cPalletRef='+item2.text,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    $.each(irene_parse, function(index,item) {

                        i.innerHTML = "<input type='checkbox' checked class='checkboxesUpdate' value='"+item.id+"~"+item.cPalletRef+"'>";
                        r.innerHTML = item.cPalletRef; 
                        e.innerHTML = item.iCases; 
                                
                    });
                }
            });
        })
       
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+ref+'&cStatus=Approved',
            success: function (data) {
                irene_parse = JSON.parse(data);
                
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('palletTableUpdate').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);

                    i.innerHTML = "<input type='checkbox' class='checkboxesUpdate' value='"+item.id+"~"+item.cPalletRef+"'>";
                    r.innerHTML = item.cPalletRef; 
                    e.innerHTML = item.iCases; 
                 
                              
                });
            }
        });
    }

    function goBack(){
        $('#modalCreate').modal('show');
        $('#modalPallet').modal('hide');
    }

    function goBack2(){
        $('#modalEdit').modal('show');
        $('#modalPalletUpdate').modal('hide');
    }

    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.checkboxes:checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.checkboxes:checkbox').each(function() {
                this.checked = false;                       
            });
        }
    }); 

    $('#select-all-update').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $('.checkboxesUpdate:checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $('.checkboxesUpdate:checkbox').each(function() {
                this.checked = false;                       
            });
        }
    }); 

    function savePallet(){
        let checked = document.querySelectorAll('input.checkboxes:checked');
        let ref_num = document.getElementById('ref_num').value;
        
       
        $('#P-'+ref_num).html('').select2({});
        for(var x = 0, l = checked.length; x < l;  x++)
        {
            let value_to_split = checked[x].value;
            let id = value_to_split.split("~")[0];
            let pallet_ref = value_to_split.split("~")[1];
            var newOption = new Option(pallet_ref,id);
            $('#P-'+ref_num).append(newOption).trigger('change');
            $('#P-'+ref_num+' > option').prop("selected","selected");
        }
        $('#modalPallet').modal('hide');
        $('#modalCreate').modal('show');
       
       
    }

    function saveUpdatePallet(){
        let checked = document.querySelectorAll('input.checkboxesUpdate:checked');
        let ref_num = document.getElementById('ref_num_update').value;
        $('#UP-'+ref_num).html('').select2({});
        for(var x = 0, l = checked.length; x < l;  x++)
        {
            let value_to_split = checked[x].value;
            let id = value_to_split.split("~")[0];
            let pallet_ref = value_to_split.split("~")[1];
            var newOption = new Option(pallet_ref,id);
            $('#UP-'+ref_num).append(newOption).trigger('change');
            $('#UP-'+ref_num+' > option').prop("selected","selected");
        }
        $('#modalPalletUpdate').modal('hide');
        $('#modalEdit').modal('show');
        
    }
</script>

<script>
    function confirmDeleteTos(id){
        Swal.fire({
            title: 'Do you want to delete this TOS?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-1 right-gap',
                confirmButton: 'order-2',
                denyButton: 'order-3',
            },
            }).then((result) => {
            if (result.isConfirmed) {
                deleteTos(id)
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }

    function deleteTos(id){
        $.ajax({
            type:'post',
            headers: {  'Access-Control-Allow-Origin': '*' },
            url:api_url+'/TOS/DeleteTos?iTosId='+id,
            crossDomain: true,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success:function(data){
                
            } 
        });

        load();
    }
</script>

<script>
    function updateTos(id){
        $('#modalEdit').modal('show');
        // $('#modalPallet').modal('show');
        $('#tosUpdateTable').empty();
        document.getElementById('tos_id_update').value = id;
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/TOS/GetTOSDetails?id='+id,
            success: function (data) {
                item2 = data;
                details = item2.details;
               
                $.each(details, function(index,item) {
                    var x = document.getElementById('tosUpdateTable').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);
                    var o = x.insertCell(5);
                    var y = x.insertCell(6);

                    i.innerHTML = item.iJobNo;
                    r.innerHTML = item.cStockCode;  
                    e.innerHTML = item.refNo;  
                    n.innerHTML = item.cLotNumber;
                    j.innerHTML = item.iCases;    
                    o.innerHTML = "<div class='container'><div class='row'><div class='col-9' style='margin:auto;'><select id='UP-"+item.refNo+"' name='iPalletUpdate[]' class='form-control ireneajax2' multiple></select></div><div class='col-3' style='margin:auto;'><button onclick=palletsUpdate('"+item.refNo+"') class='btn btn-warning' style='margin:auto;'><i class='fa-solid fa-arrows-spin'></i></button></div></div></div>";      
                    y.innerHTML = '<input name="lot_number_update[]" type="hidden" value="'+item.cLotNumber+'"><input name="coaUpdate[]" class="form-control" type="text" value="'+item.cCoaRefNo+'"> <input name="iCasesCheckUpdate[]" type="hidden" value="'+item.iCases+'" >';   
                    
                    $( ".ireneajax2" ).select2({});
                    $(".ireneajax2").prop("disabled", true);

                    $('#UP-'+item.refNo).html('').select2({});
                    let  pallet_details = item.palletDetails;
                    for(var x = 0, l = pallet_details.length; x < l;  x++)
                    {
                        let id = pallet_details[x].id;
                        let pallet_ref = pallet_details[x].cPalletRef;
                        var newOption = new Option(pallet_ref,id);
                        $('#UP-'+item.refNo).append(newOption).trigger('change');
                        $('#UP-'+item.refNo+' > option').prop("selected","selected");
                    }
                });
                
            }
        });
        
    }
</script>

<script>
    function printTos(id){
        Swal.fire({
            position: "center",
            icon: "success",
            title: "RENDERING PDF",
            showConfirmButton: false,
            timer: 4000
        });
        
        $('#modalPrint').modal('show');
        // $.ajax({
        //     type: 'GET', //THIS NEEDS TO BE GET
        //     url: irene_api_base_url+'/turnover_form/'+id+'/0',
        //     success: function (data) {
        //         $( "#display_dialog").html('<iframe width="100%" height="600px" src="data:application/pdf;base64,' + data + '"></object>');
        //     }
        // });
        $( "#display_dialog").html('<iframe  frameBorder="0" width="100%" height="1000px" src="'+irene_api_base_url+'/turnover_form1/'+id+'/0"></object>');
    }
</script>

<script>
    function irene(){
        printJS({
            printable: 'display_dialog',
            type: 'html',
            css: [
                '{{asset("css/tos.css")}}'
            ],
            scanStyles: false
        })
    }
</script>

<script>
    function checkRFA(flag){
        let history_url = '{!!$url_history!!}';
        if(flag == 0){
            coa = document.getElementById('coa_check').value;
            $( "#coa_create").html('<iframe  frameBorder="0" width="100%" height="1000px" src="'+history_url+'/'+coa+'"></object>');
        }else{
            coa = document.getElementById('coa_check_update').value;
            $( "#coa_update").html('<iframe  frameBorder="0" width="100%" height="1000px" src="'+history_url+'/'+coa+'"></object>');
        }  
    }
</script>