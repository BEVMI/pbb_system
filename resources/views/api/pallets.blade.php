<script>

    function refresh(){
        let reference = document.getElementById('reference').value;
        let status = document.getElementById('status').value;
        let date = document.getElementById('date').value;
        ifvisible.off('idle');
        ifvisible.setIdleDuration(600); // Page will become idle after 120 seconds
        ifvisible.on("idle", function(){
            if(!date){
                date_post = '{{$initial_date}}';
            }else{
                date_post = date;
            }
            getPallets(reference,status,date)
                Swal.fire({
                position: "center",
                icon: "success",
                title: "LOADING PLEASE WAIT",
                showConfirmButton: false,
                timer: 2500
            });
           
        });

    }
    $(document).ready(function(){
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
                Swal.fire({
                position: "center",
                icon: "success",
                title: "LOADING PLEASE WAIT",
                showConfirmButton: false,
                timer: 2500
            });
           
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
        $('#pallet_body_table').empty();
        ifvisible.off('idle');
        refresh();
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+reference+'&cStatus='+status+'&dOutputDate='+date+'%2000%3A00%3A00',
            success: function (data) {
                irene_parse = JSON.parse(data);
               
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
                   
                    
                    let quarantine_now = quarantine(item.id,item.cStatus,item.cReason,item.cPalletRef);
                    let approved_now = approved(item.id,item.cStatus,item.cReason,item.cPalletRef);
                    let on_hold_now = on_hold(item.id,item.cStatus,item.cReason,item.cPalletRef);
                    let reject_now = reject(item.id,item.cStatus,item.cReason,item.cPalletRef);
                    let turnover_now = turnover(item.id,item.cStatus,item.cReason,item.cPalletRef);

                    r.innerHTML = quarantine_now+' '+approved_now+' '+on_hold_now+' '+reject_now+' '+turnover_now;
                    
                    e.innerHTML = 'ID:'+item.id+'<br>MAC.ID:'+item.iMachineCounterId+'<br><span class="badge bg-secondary">'+item.cPalletRef+'</span>';  
                    n.innerHTML = 'OUT. DATE: '+formatDate(item.dOutputDate)+'<br>MFG. DATE: '+formatDate(item.dMfgDate)+'<br> EXP. DATE: &nbsp;'+formatDate(item.dExpDate);
                    j.innerHTML = 'JOB:'+item.iJobNo+'<br>'+item.iCases+' CS';    
                    o.innerHTML = item.cLotNumber;      
                    y.innerHTML = item.cStatus;  
                    
                });
            }
        });
    }

    function quarantine(id,cStatus,cReason,cPalletRef){
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
            success: function (data) {
                irene_parse = JSON.parse(data);
                reference2 = irene_parse[0].cPalletRef;
            }
        });
        
        return '<i class="modalView fa-solid fa-q style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Quarantine"></i>'
    }

    function approved(id,cStatus,cReason,cPalletRef){
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
            success: function (data) {
                irene_parse = JSON.parse(data);
                reference2 = irene_parse[0].cPalletRef;
            }
        });

        let tag = '<i class="modalView fa-solid fa-a" style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Approved"></i>'
        return tag;
    }

    function on_hold(id,cStatus,cReason,cPalletRef){
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
            success: function (data) {
                irene_parse = JSON.parse(data);
                reference2 = irene_parse[0].cPalletRef;
            }
        });

        let tag = '<i class="modalView fa-solid fa-o" style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="On Hold"></i>'
        return tag;
    }

    function reject(id,cStatus,cReason,cPalletRef){
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
            success: function (data) {
                irene_parse = JSON.parse(data);
                reference2 = irene_parse[0].cPalletRef;
            }
        });

        let tag = '<i class="modalView fa-solid fa-r" style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Reject"></i>'
        return tag;
    }

    function turnover(id,cStatus,cReason,cPalletRef){
        $.ajax({
            async: false,
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Pallet/GetPallet?cPalletRef='+cPalletRef,
            success: function (data) {
                irene_parse = JSON.parse(data);
                reference2 = irene_parse[0].cPalletRef;
            }
        });

        let tag = '<i class="modalView fa-solid fa-t" style="color:black;" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+id+'" data-status="'+cStatus+'" data-reasonnow="'+cReason+'" data-reference="'+reference2+'" data-module="Turnover"></i>'
        return tag;
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
        console.log(checked);

        var ids = [];
        for(var x = 0, l = checked.length; x < l;  x++)
        {
            ids.push(checked[x].value);
        }
        console.log(ids);
    }
    
</script>