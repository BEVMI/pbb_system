<script>

        // Listen for click on toggle checkbox
        $('#all').click(function(event) {   
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

    function refresh(){
        document.getElementById("all").checked = true;
        let reference = document.getElementById('reference').value;
        let status = document.getElementById('status').value;
        let date = document.getElementById('date').value;
        ifvisible.off('idle');
        ifvisible.setIdleDuration('{!!$idletime!!}'); // Page will become idle after 120 seconds
        ifvisible.on("idle", function(){
            if(!date){
                date_post = '{{$initial_date}}';
            }else{
                date_post = date;
            }
            getPallets(reference,status,date)
        });

    }
    
    $(document).ready(function(){
        Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
        let reference = document.getElementById('reference').value;
        let status = document.getElementById('status').value;
        let date = document.getElementById('date').value;

        ifvisible.setIdleDuration(600); // Page will become idle after 120 seconds
        ifvisible.on("idle", function(){
            if(!date){
                date_post = '{{$initial_date}}';
            }else{
                date_post = date;
            }
            getPallets(reference,status,date)
        });

        if(!date){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "DATE FIELD IS EMPTY",
                showConfirmButton: false,
                timer: 2500
            });
        }else{
            getPallets(reference,status,date)
                Swal.fire({
                position: "center",
                icon: "success",
                title: "LOADING PLEASE WAIT",
                showConfirmButton: false,
                timer: 2500
            });
        }
        
    });

    function getPallets(reference,status,date){
        Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2500
        });
        $('#pallet_body_table').empty();
        ifvisible.off('idle');
        refresh();
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+reference+'&cStatus='+status+'&dOutputDate='+date+'%2000%3A00%3A00',
            success: function (data) {
                irene_parse = JSON.parse(data);
                if(irene_parse.length===0){
                    document.getElementById('qGlobal').style.display = 'none';
                    document.getElementById('aGlobal').style.display = 'none';
                    document.getElementById('oGlobal').style.display = 'none';
                    document.getElementById('rGlobal').style.display = 'none';
                    document.getElementById('tGlobal').style.display = 'none';
                    document.getElementById('pGlobal').style.display = 'none';
                }
                else{
                    let status_post = document.getElementById('status').value;
                    if(status_post == 'Quarantine' || status_post == 'Approved' ){
                        document.getElementById('pGlobal').style.display = '';
                    }else{
                        document.getElementById('pGlobal').style.display = 'none';
                    }
                    $.ajax({
                        async: false ,
                        type: 'GET', //THIS NEEDS TO BE GET
                        url: irene_api_base_url+'/pallet_status_check2/'+status_post,
                        success: function (data) {
                            irene_parse2 = JSON.stringify(data);
                            if(irene_parse2 == 0){
                                document.getElementById('qGlobal').style.display = 'none';
                                document.getElementById('aGlobal').style.display = 'none';
                                document.getElementById('oGlobal').style.display = 'none';
                                document.getElementById('rGlobal').style.display = 'none';
                                document.getElementById('tGlobal').style.display = 'none';

                                quarantine_boolean = irene_parse2.includes('Quarantine');
                                approved_boolean = irene_parse2.includes('Approved');
                                on_hold_boolean = irene_parse2.includes('On Hold');
                                reject_boolean = irene_parse2.includes('Reject');
                                turnover_boolean = irene_parse2.includes('Turnover');
                            }else{
                                quarantine_boolean = irene_parse2.includes('Quarantine');
                                if(quarantine_boolean === true){
                                    document.getElementById('qGlobal').style.display = '';
                                }else{
                                    document.getElementById('qGlobal').style.display = 'none';
                                }
                                
                                approved_boolean = irene_parse2.includes('Approved');
                                if(approved_boolean === true){
                                    document.getElementById('aGlobal').style.display = '';
                                }else{
                                    document.getElementById('aGlobal').style.display = 'none';
                                }

                                on_hold_boolean = irene_parse2.includes('On Hold');
                                if(on_hold_boolean === true){
                                    document.getElementById('oGlobal').style.display = '';
                                }else{
                                    document.getElementById('oGlobal').style.display = 'none';
                                }

                                reject_boolean = irene_parse2.includes('Reject');
                                if(reject_boolean === true){
                                    document.getElementById('rGlobal').style.display = '';
                                }else{
                                    document.getElementById('rGlobal').style.display = 'none';
                                }

                                turnover_boolean = irene_parse2.includes('Turnover');
                                if(turnover_boolean === true){
                                    document.getElementById('tGlobal').style.display = '';
                                }else{
                                    document.getElementById('tGlobal').style.display = 'none';
                                }
                            }
                        }
                    });
                    $.each(irene_parse, function(index,item) {
                        var x = document.getElementById('pallet_body_table').insertRow(-1);
                        var i = x.insertCell(0);
                        var r = x.insertCell(1);
                        var e = x.insertCell(2);
                        var n = x.insertCell(3);
                        var j = x.insertCell(4);
                        var o = x.insertCell(5);
                        var y = x.insertCell(6);
                        
                        
                        i.innerHTML = '<div class="form-check" class="text-center" style="display:inline-block;"><input class="form-check-input checkbox_print" type="checkbox" value='+item.id+' checked></div>';
                        
                        
                        let quarantine_now = quarantine(item.id,item.cStatus,item.cReason,item.cPalletRef,quarantine_boolean);
                        let approved_now = approved(item.id,item.cStatus,item.cReason,item.cPalletRef,approved_boolean);
                        let on_hold_now = on_hold(item.id,item.cStatus,item.cReason,item.cPalletRef,on_hold_boolean);
                        let reject_now = reject(item.id,item.cStatus,item.cReason,item.cPalletRef,reject_boolean);
                        let turnover_now = turnover(item.id,item.cStatus,item.cReason,item.cPalletRef,turnover_boolean);

                        r.innerHTML = quarantine_now+' '+approved_now+' '+on_hold_now+' '+reject_now+' '+turnover_now;
                        
                        e.innerHTML = 'ID:'+item.id+'<br>MAC.ID:'+item.iMachineCounterId+'<br><span class="badge bg-secondary">'+item.cPalletRef+'</span>';  
                        n.innerHTML = 'OUT. DATE: '+formatDate(item.dOutputDate)+'<br>MFG. DATE: '+formatDate(item.dMfgDate)+'<br> EXP. DATE: &nbsp;'+formatDate(item.dExpDate);
                        j.innerHTML = 'JOB:'+item.iJobNo+'<br>'+item.iCases+' CS';    
                        o.innerHTML = item.cLotNumber;      
                        y.innerHTML = item.cStatus;  
                        
                    });
                }
               
            }
        });
    }

    function quarantine(id,cStatus,cReason,cPalletRef,boolean){
        if(boolean == true){
            $.ajax({
                async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    reference2 = irene_parse[0].cPalletRef;
                }
            });
            
            return '<i class="modalView fa-solid fa-circle-exclamation" style="color:black;" data-toggle="tooltip" data-placement="top" title="QUARANTINE TAG." data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Quarantine" ></i>';
        }
        else{
            
            return '';
        }
       
    }



    function approved(id,cStatus,cReason,cPalletRef,boolean){
        if(boolean == true){
            $.ajax({
            async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    reference2 = irene_parse[0].cPalletRef;
                }
            });
           
            let tag = '<i class="modalView fa-solid fa-thumbs-up" style="color:black;" data-toggle="tooltip" data-placement="top" title="APPROVE TAG." style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Approved" ></i>'
            return tag;
        }else{
            return '';
        }
       
    }

    function on_hold(id,cStatus,cReason,cPalletRef,boolean){
        if(boolean == true){
            $.ajax({
                async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    reference2 = irene_parse[0].cPalletRef;
                }
            });
            
            let tag = '<i class="modalView fa-solid fa-hand" style="color:black;" data-toggle="tooltip" data-placement="top" title="ONHOLD TAG." style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="On Hold"></i>'
            return tag;
        }else{
           
            return '';
        } 

        
    }

    function reject(id,cStatus,cReason,cPalletRef,boolean){
        if(boolean == true){
            $.ajax({
                async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    reference2 = irene_parse[0].cPalletRef;
                }
            });
            
            let tag = '<i class="modalView fa-solid fa-rectangle-xmark" data-toggle="tooltip" data-placement="top" title="REJECT TAG." style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Reject"></i>'
            return tag;
        }else{
            
            return '';
        }
    }

    function turnover(id,cStatus,cReason,cPalletRef,boolean){
        if(boolean == true){
            $.ajax({
                async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    reference2 = irene_parse[0].cPalletRef;
                }
            });
            
            let tag = '<i class="modalView fa-solid fa-arrow-right-to-city" data-placement="top" title="TURNOVER TAG." style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Turnover"></i>'
            return tag;
        }else{
            
            return '';
        }
    }

    function search(){
        let reference = document.getElementById('reference').value;
        let status = document.getElementById('status').value;
        let date = document.getElementById('date').value;
        if(!date){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "DATE FIELD IS EMPTY",
                showConfirmButton: false,
                timer: 2500
            });
        }else{
            getPallets(reference,status,date)
            Swal.fire({
                position: "center",
                icon: "success",
                title: "LOADING PLEASE WAIT",
                showConfirmButton: false,
                timer: 2500
            });
        }
    }
</script>

<script>
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){
        $(document).on('click', '.modalView', function (e) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "PLEASE WAIT",
                showConfirmButton: false,
                timer: 1500
            })
            let id = $(this).data('id');
            let status = $(this).data('status');
            let reason = $(this).data('reasonnow');
            let reference =$(this).data('reference');
            let module2 =$(this).data('module');

            $.ajax({
                async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/GetPallet?cPalletRef='+reference,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    status_check = irene_parse[0].cStatus;
                }
            });
            if(status_check !== status){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "STATUS WAS ALREADY UPDATED FROM "+status+" TO "+status_check,
                    text: "AUTO REFRESH AFTER 4 SECONDS",
                    showConfirmButton: false,
                    timer: 4000
                });

                let reference = document.getElementById('reference').value;
                let date = document.getElementById('date').value;

                getPallets(reference,status_check,date)
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "LOADING PLEASE WAIT",
                    showConfirmButton: false,
                    timer: 2500
                });
            }else{
                $('#status_post').empty();
                $.ajax({
                    type: 'GET', //THIS NEEDS TO BE GET
                    url: irene_api_base_url+'/pallet_status_check/'+module2,
                    success: function (data) {
                        irene_parse = data[0];
                        $.each(irene_parse, function (i, item) {
                            if(item.status_name == module2){
                                $('#status_post').append($('<option>', { 
                                    value: item.status_name,
                                    text : item.status_name 
                                }));
                            }
                        });
                        
                        if(data[1]==1){
                            document.getElementById('reason_post_display').style.display = 'block';
                            document.getElementById('reason_post').value = reason;
                        }else{
                            document.getElementById('reason_post_display').style.display = 'none';
                            document.getElementById('reason_post').value = '';
                        }
                        document.getElementById('header_id').value = id;
                    }
                });
            }
        });
    });
</script>

<script>
    function updatePallet(){
        let reference = document.getElementById('reference').value;
        let status = document.getElementById('status').value;
        let date = document.getElementById('date').value;

        let id = document.getElementById('header_id').value;
        let cStatus = document.getElementById('status_post').value;
        let cUpdatedBy = "{!!$user_auth->name!!}";
        
        let cReason_post =  document.getElementById('reason_post').value;
        if(cReason_post){
            cReason = cReason_post;
        }else{
            cReason = '';
        }
        $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Pallet/UpdatePallet?id='+id+'&cStatus='+cStatus+'&cUpdatedBy='+cUpdatedBy+'&cReason='+cReason,
                success: function (data) {
                    Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY UPDATE",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => {
                    getPallets(reference,status,date)
                    $('#modalView').modal('hide');
                }, "2000");
            }
        });
    }
</script>

<script>
    function statusChange(){
        let cStatus = document.getElementById('status_post').value;
        
        if(cStatus === 'Reject' || cStatus === 'On Hold'){
            document.getElementById('reason_post_display').style.display ='block';
        }else{
            document.getElementById('reason_post_display').style.display ='none';
            document.getElementById('reason_post').value ='';
        }
    }
</script>

<script>
    function updateList(){
        let checked = document.querySelectorAll('input.checkbox_print:checked');
        let cStatus = document.getElementById('status_global').value;
        let cReason = document.getElementById('global_reason').value;
        let cCoaRef = document.getElementById('global_approve').value;
        let cUpdatedBy = "{!!$user_auth->name!!}";

        let reference = document.getElementById('reference').value;
        let status = document.getElementById('status').value;
        let date = document.getElementById('date').value;
        if(cCoaRef){
            coa_post_now = cCoaRef;
        }else{
            coa_post_now = '';
        }
        var ids = [];
        for(var x = 0, l = checked.length; x < l;  x++)
        {
            ids.push(checked[x].value);
        }
        
        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/Pallet/UpdatePallet',
            crossDomain: true,
            dataType: 'json',
            headers: { 
                'Accept': 'application/json',
                'Content-Type': 'application/json' 
            },
            data:  JSON.stringify({
                "cStatus": cStatus,
                "cUpdatedBy": cUpdatedBy,
                "cReason": cReason,
                "cCoaRef":coa_post_now,
                "ids": ids,
            }),
            success:function(data){;
             
            }
        });

        
           Swal.fire({
                position: "center",
                icon: "success",
                title: "SUCCESSFULLY UPDATE",
                showConfirmButton: false,
                timer: 5000
            });
            var base_url =  '{{ url("/")}}';
            let title = 'PALLET IS CREATED';
            let content = 'PLEASE CREATE A A TOS';
            let department = 'production2';
            setTimeout(() => {
                $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: base_url+'/api/emailSend/'+title+'/'+content+'/'+department,
                success: function (data) { 
                }
            });
            }, "1000");
            setTimeout(() => {
                $('#modalGlobal').modal('hide');
                getPallets(reference,status,date)
            }, "2000");
    }
    
</script>

<script>
    function globalFunction(module1){
        if(module1 === 'Print'){
            Swal.fire({
                position: "center",
                icon: "success",
                title: "RENDERING PDF",
                showConfirmButton: false,
                timer: 4000
            });
            $('#modalPrint').modal('show');
            let checked = document.querySelectorAll('input.checkbox_print:checked');
            let global_status = document.getElementById('status').value;
            let user_name = document.getElementById('user_name').value;
            let qc_user_1 = document.getElementById('qc_user_1').value;
            let qc_user_2 = document.getElementById('qc_user_2').value;
            let ids = [];
            for(var x = 0, l = checked.length; x < l;  x++)
            {
                ids.push(checked[x].value);
            }
            
            $.ajax({
                async:false,
                type:'POST',
                method:'POST',
                url:api_url+'/Pallet/GetPalletByIds',
                crossDomain: true,
                dataType: 'json',
                contentType: 'application/json',
                data:JSON.stringify(ids),
                success:function(data){;
                   irene_parse_3 = data;
                },
                error: function(e) {
                    console.log(e);
                }
            });

            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: irene_api_base_url+'/print_pdf',
                data:{
                    "ids":ids,
                    "tag":global_status,
                    'user_name':user_name,
                    'qc_user_1':qc_user_1,
                    'qc_user_2':qc_user_2
                },
                success: function (data) {
                    $( "#display_dialog").html('<iframe width="100%" height="600px" src="data:application/pdf;base64,' + data + '"></object>');
                }
            });
        }else{
            $('#modalGlobal').modal('show');
            document.getElementById('modalGlobalLongTitle').innerHTML = module1+' STATUS';
            document.getElementById('status_global').value = module1;
            document.getElementById('global_reason').value = '';
            document.getElementById('global_approve').value = '';
            if(module1 == 'On Hold' || module1 == 'Reject'){
                document.getElementById('global_reason_display').style.display = '';
                document.getElementById('global_approve_display').style.display = 'none';
                document.getElementById('coa_create').style.display = 'none';
            }
            if(module1 == 'Approved'){
                document.getElementById('global_approve_display').style.display = '';
                document.getElementById('global_reason_display').style.display = 'none';
                document.getElementById('coa_create').style.display = '';
            }
            else{
                document.getElementById('global_reason_display').style.display = 'none';
                document.getElementById('global_approve_display').style.display = 'none';
                document.getElementById('coa_create').style.display = 'none';
            }
        }
        
    }
</script>

<script>
    function myFunction() {
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("myInput");
      filter = input.value.toUpperCase();
      table = document.getElementById("irene_table");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          txtValue = td.textContent || td.innerText;
          if (txtValue.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
</script>

<script>
    function modalAdvance(){
        let job_id = document.getElementById('job_id').value;
        let pallet_count = document.getElementById('pallet_count').value;
        let date_advance = document.getElementById('date_advance').value;
        if(job_id == ''){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "JOB IS EMPTY",
                showConfirmButton: false,
                timer: 4000
            });
            
        }else{
            Swal.fire({
                position: "center",
                icon: "success",
                title: "RENDERING PDF",
                showConfirmButton: false,
                timer: 4000
            });
            
            
            $.ajax({
                async: false,
                type: 'GET', //THIS NEEDS TO BE GET
                url: irene_api_base_url+'/print_pdf_advance/'+job_id+'/'+pallet_count+'/'+date_advance+'',
                success: function (data) {
                    $('#modalAdvance').modal('hide');
                    $('#modalPrint').modal('show');
                    $( "#display_dialog").html('<iframe width="100%" height="600px" src="data:application/pdf;base64,' + data + '"></object>');
                }
            });
        }
       
    }
</script>

<script>
    function checkRFA(flag){
        let history_url = '{!!$url_history!!}';
        if(flag == 0){
            coa = document.getElementById('global_approve').value;
            $( "#coa_create").html('<iframe  frameBorder="0" width="100%" height="1000px" src="'+history_url+'/'+coa+'"></object>');
        }else{
            coa = document.getElementById('coa_check_update').value;
            $( "#coa_update").html('<iframe  frameBorder="0" width="100%" height="1000px" src="'+history_url+'/'+coa+'"></object>');
        }  
    }
</script>