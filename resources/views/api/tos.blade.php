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

                    i.innerHTML = item.iJobNo;
                    r.innerHTML = item.cStockCode;  
                    e.innerHTML = item.cLotNumber;
                    n.innerHTML = item.iCases;    
                    j.innerHTML = '<input name="iCases[]" class="form-control" type="number" min="0" value="0"><input name="lot_number[]" type="hidden" value="'+item.cLotNumber+'">';      
                    o.innerHTML = '<input name="coa[]" class="form-control" type="text"> <input name="iCasesCheck[]" type="hidden" value="'+item.iCases+'" >';               
                });
            }
        });
    }
</script>
<script>
    function saveTos(){
        let cases = document.querySelectorAll("input[name^='iCases[']");
        let coas = document.querySelectorAll("input[name^='coa[']");
        let cases_checks = document.querySelectorAll("input[name^='iCasesCheck[']");
        let lot_number = document.querySelectorAll("input[name^='lot_number[']");

        let dTurnOverDate = "{{$initial_date}}";
        let user_auth = "{{$user_auth->name}}";
        let details = [];
        for (var i = 0; i <cases.length; i++) {
            let cases_post=cases[i].value;
            let coas_post=coas[i].value;
            let cases_checks_post=cases_checks[i].value;
            let lot_number_post = lot_number[i].value;
            if(cases_post > 0){
                details.push({
                    "nQty":cases_post,
                    "cLotNumber":lot_number_post,
                    "cCoaRefNo":coas_post
                });   
            }
        }
        
        $.ajax({
            async:false,
            type:'POST',
            method:'POST',
            url:api_url+'/TOS/UpdateTOS',
            crossDomain: true,
            dataType: 'json',
            contentType: 'application/json',
            data:JSON.stringify({
                "id": 0,
                "dTurnOverDate": dTurnOverDate,
                "cCreatedBy": user_auth,
                "details":details
            }),
            success:function(data){;
                $('#modalCreate').modal('hide');
                load();
            },
            error: function(e) {
                console.log(e);
            }
        });

    }
</script>