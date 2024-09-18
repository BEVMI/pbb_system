<script>
 
</script>
<script>
    load();
    function refresh(){
        ifvisible.off('idle');
        ifvisible.setIdleDuration(600); // Page will become idle after 120 seconds
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

                    i.innerHTML = item.cTOSRefNo;
                    r.innerHTML = formatDate(item.dDate);
                    e.innerHTML = item.cCreatedBy;
                    n.innerHTML = '';

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
        });
    }
  
</script>
<script>
    function saveTos(){
        let coas = document.querySelectorAll("input[name^='coa[']");
        let lot_number = document.querySelectorAll("input[name^='lot_number[']");
        let pallets = document.querySelectorAll("select[name^='iPallet[']");
        let dTurnOverDate = "{{$initial_date}}";
        let user_auth = "{{$user_auth->name}}";
        let details = [];
        let pallet_details = [];
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
                
            }
            pallet_details=[];
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
                "id": 0,
                "dTurnOverDate": dTurnOverDate,
                "cCreatedBy": user_auth,
                "details":details
            }),
            success:function(data){
                $('#modalCreate').modal('hide');
                details=[];
                load();
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

    function goBack(){
        $('#modalCreate').modal('show');
        $('#modalPallet').modal('hide');
    }

    $('#select-all').click(function(event) {   
        if(this.checked) {
            // Iterate each checkbox
            $(':checkbox').each(function() {
                this.checked = true;                        
            });
        } else {
            $(':checkbox').each(function() {
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
</script>