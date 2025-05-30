<script>
    function uploadPlan(){
        let month_upload = document.getElementById('month_upload').value;
        let year_now = document.getElementById('year_now').value;
        let line = document.getElementById('line').value;
        let upload_file_irene =  $('#plan_upload')[0].files;
        
        document.getElementById("upload").disabled = true;
        var fd = new FormData();
       
        fd.append('file',upload_file_irene[0]);

        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/MonthlyPlan/Upload?nYear='+year_now+'&nMonth='+month_upload+'&nLineNo='+line,
            contentType: false,
            processData: false,
            enctype: 'multipart/form-data',
            data: fd,
            success:function(data){
                location.reload();
            }
        });    
    }
</script>

<script>
    function refresh2(){
        ifvisible.off('idle');
        ifvisible.setIdleDuration('{!!$idletime!!}'); // Page will become idle after 120 seconds
        ifvisible.on("idle", function(){
            document.querySelector('.fc-refresh-button').click();
        });

    }
</script>

<script>
    let initial_date = '{{$initial_date}}';
   
    Array.prototype.clear = function() {
        this.splice(0, this.length);
    };
    let irene2 = [];
    let month = {!!$month_now!!};
    let line = {!!$line!!};
    let year = {!!$year_now!!};
    let pm_flag = {!!$pm_flag!!};
    
    // $.ajax({
    //     async: false,
    //     type:"GET",//or POST
    //     "crossDomain": true,
    //     url:'{{url("/plan_ajax/")}}'+'/'+year+'/'+month+'/'+line,
    //     success:function(calendars){
    //        irene2 = calendars.data;
    //     }
    // });
    
    setTimeout(function() {
            document.querySelector('.fc-refresh-button').click();
    }, 2100);
    
    
    document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
     
            setTimeout(() => {
                var calendar = new FullCalendar.Calendar(calendarEl, {
                    customButtons: {
                        prevButton: {
                        text: 'PREV MOS',
                        click: function() {
                            calendar.prev();
                            var date = calendar.getDate();
                            let irene4 = irene3(date);
                            setTimeout(() => {

                                calendar.removeAllEvents();
                                calendar.addEventSource({
                                    events:irene4
                                });
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "LOADING PLEASE WAIT",
                                    showConfirmButton: false,
                                    timer: 2500
                                });

                                calendar.refetchEvents();
                            }, "1");
                            }

                        },
                        nextButton: {
                        text: 'NXT MOS',
                        click: async function() {
                            calendar.next();
                            var date2 = calendar.getDate();
                            let irene4 = irene3(date2);
                            setTimeout(() => {
                                calendar.removeAllEvents();
                                calendar.addEventSource({
                                    events:irene4
                                });
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "LOADING PLEASE WAIT",
                                    showConfirmButton: false,
                                    timer: 2500
                                });

                                calendar.refetchEvents();
                            }, "1");
                            }
                        },

                        prevYearButton: {
                        text: 'PREV YR',
                        click: async function() {
                            calendar.prevYear();
                            var date2 = calendar.getDate();
                            let irene4 = irene3(date2);
                            setTimeout(() => {
                                calendar.removeAllEvents();
                                calendar.addEventSource({
                                    events:irene4
                                });
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "LOADING PLEASE WAIT",
                                    showConfirmButton: false,
                                    timer: 2500
                                });

                                calendar.refetchEvents();
                            }, "1");
                            }
                        },

                        nextYearButton: {
                        text: 'NXT YR',
                        click: async function() {
                            calendar.nextYear();
                            var date2 = calendar.getDate();
                            let irene4 = irene3(date2);
                            setTimeout(() => {
                                calendar.removeAllEvents();
                                calendar.addEventSource({
                                    events:irene4
                                });
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "LOADING PLEASE WAIT",
                                    showConfirmButton: false,
                                    timer: 2500
                                });

                                calendar.refetchEvents();
                            }, "1");
                          }
                       
                        },
                        refresh: {
                        text: 'REFRESH',
                        click: async function() {
                            var date2 = calendar.getDate();
                            let irene4 = irene3(date2);
                            refresh2();
                            setTimeout(() => {
                                calendar.removeAllEvents();
                                calendar.addEventSource({
                                    events:irene4
                                });
                                Swal.fire({
                                    position: "center",
                                    icon: "success",
                                    title: "LOADING PLEASE WAIT",
                                    showConfirmButton: false,
                                    timer: 2500
                                });

                                calendar.refetchEvents();
                            }, "1");
                            }
                        },
                        plan: {
                        text: 'ADD PLAN',
                        click: async function() {
                            // var date2 = calendar.getDate();
                            // let irene4 = irene3(date2);
                            $('#modalCreate2').modal('show');
                            }
                        }
                    },
                    headerToolbar: {
                        left: 'prevButton,nextButton,prevYearButton,nextYearButton,refresh,plan',
                        center:'title' ,
                        right: 'dayGridMonth,listWeek'
                    },
                    initialDate: initial_date,
                    editable: false,
                    themeSystem: 'bootstrap5',
                    selectable: true,
                    initialView: 'dayGridMonth',
                    businessHours: true,
                    dayMaxEvents: true, // allow "more" link when too many events
                    // MERON IRENE2
                    events: irene2,
                    height: 640,
                    eventClick: function(info) {
                        // console.log(info.event.start);
                        // console.log(info.event.extendedProps.plan_date);
                        if(pm_flag ==0){
                            document.getElementById('plan_id').value = info.event.id;
                            document.getElementById('job_plan_id').value = info.event.id;
                            document.getElementById('planTitle').innerHTML = info.event.title;
                            document.getElementById('qty_update').value = info.event.extendedProps.plan_qty;
                            document.getElementById('pm_remarks_create').value = info.event.extendedProps.cRemarks;
                            if(info.event.extendedProps.plan_qty === 0){
                                document.getElementById('stock_codes_update').value = 'NO_STOCK_CODE';
                                document.getElementById('display_update').style.display = 'block';
                                document.getElementById('stock_code_irene').innerHTML = 'STOCK CODE DOES NOT EXIST';
                                document.getElementById('custom_update').value = info.event.title;
                                document.getElementById('job_section').style.display = 'none';
                                document.getElementById('job_stock_code').value = '';
                            }else{
                                if(info.event.extendedProps.job !==''){
                                    document.getElementById('stock_code_irene').innerHTML = 'JOB IS ALREADY CREATED FOR THIS PLAN -  '+info.event.extendedProps.job;
                                    document.getElementById('qty_to_make').value = '';
                                    document.getElementById('qty_to_make').style.display = 'none';
                                    document.getElementById('qty_to_make_display').style.display = 'none';
                                    document.getElementById('createJobDisplay').style.display = 'none';
                                    document.getElementById('job_number').style.display = 'none';
                                    document.getElementById('display_update').style.display = 'none';
                                    document.getElementById('custom_update').value = '';
                                    document.getElementById('job_section').style.display = 'none';
                                }else{
                                    // console.log(info.event.extendedProps.pm);
                                    // if(!info.event.extendedProps.pm ){
                                    //     document.getElementById('stock_code_irene').innerHTML = 'PM DOES NOT YET APPROVED THIS PLAN';
                                    //     document.getElementById('qty_to_make').value = '';
                                    //     document.getElementById('qty_to_make').style.display = 'none';
                                    //     document.getElementById('qty_to_make_display').style.display = 'none';
                                    //     document.getElementById('createJobDisplay').style.display = 'none';
                                    //     document.getElementById('job_number').style.display = 'none';
                                    //     document.getElementById('display_update').style.display = 'none';
                                    //     document.getElementById('custom_update').value = '';
                                    //     document.getElementById('job_section').style.display = 'none';
                                    // }
                                    // else{
                                        document.getElementById('job_number').value = '';
                                        document.getElementById('job_number').style.display = 'block';
                                        document.getElementById('qty_to_make').value = '';
                                        document.getElementById('qty_to_make').style.display = 'none';
                                        document.getElementById('qty_to_make_display').style.display = 'none';
                                        document.getElementById('createJobDisplay').style.display = 'none';
                                        document.getElementById('stock_codes_update').value = info.event.extendedProps.stock_code;
                                        document.getElementById('stock_code_irene').innerHTML = 'JOB CREATE - STKC '+info.event.extendedProps.stock_code;
                                        document.getElementById('job_stock_code').value = info.event.extendedProps.stock_code;
                                        document.getElementById('display_update').style.display = 'none';
                                        document.getElementById('custom_update').value = '';
                                        document.getElementById('job_section').style.display = '';
                                    // }
                                }
                            }
                        }else{
                            document.getElementById('plan_id').value = info.event.id;
                            document.getElementById('pm_remarks').value = info.event.extendedProps.cRemarks;
                        }
                        $('#modalDetail').modal('show');
                    }
                });
                calendar.render();
            }, "2000");
        });
</script>
<script>
    function irene3(initialDatePost){
        var month = new Array();
            month[0] = "1";
            month[1] = "2";
            month[2] = "3";
            month[3] = "4";
            month[4] = "5";
            month[5] = "6";
            month[6] = "7";
            month[7] = "8";
            month[8] = "9";
            month[9] = "10";
            month[10] = "11";
            month[11] = "12";

        irene2.clear();
        $.ajax({
            async: false,
            type:"GET",//or POST
            url:'{{url("/plan_ajax/")}}'+'/'+initialDatePost.getFullYear()+'/'+month[initialDatePost.getMonth()]+'/'+line,
            success:function(calendars){
                irene2 = calendars.data;
            }   
        });
        return irene2;
    }

    function updatePlan(){
        let plan_id = document.getElementById('plan_id').value;
        let stock_code = document.getElementById('stock_codes_update').value;
        let custom_update = document.getElementById('custom_update').value;
        let qty_update = document.getElementById('qty_update').value;

        if(stock_code === 'NO_STOCK_CODE'){
            if(custom_update===''){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "CUSTOM DETAIL IS EMPTY",
                    showConfirmButton: false,
                    timer: 3000
                });
            }else{
                $.ajax({
                    type: 'POST', //THIS NEEDS TO BE GET
                    url: api_url+'/MonthlyPlan/UpdatePlanDetail?iPlanId='+plan_id+'&cStockCode='+custom_update+'&nQty=0',
                    success: function (data) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "SUCCESSFULLY SAVED",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            refresh();
                            $('#modalDetail').modal('hide');
                        }, "2000");
                       
                    }
                });
            }
        }else{
            $.ajax({
                type: 'POST', //THIS NEEDS TO BE GET
                url: api_url+'/MonthlyPlan/UpdatePlanDetail?iPlanId='+plan_id+'&cStockCode='+stock_code+'&nQty='+qty_update,
                success: function (data) {
                    Swal.fire({
                        position: "center",
                        icon: "success",
                        title: "SUCCESSFULLY SAVED",
                        showConfirmButton: false,
                        timer: 2000
                    });
                    setTimeout(() => {
                        refresh();
                        $('#modalDetail').modal('hide');
                    }, "2000");
                }
            });
        }
        // let plan_id = document.getElementById('plan_id').value;
    }

    function updateStockCode(){
        let stock_code = document.getElementById('stock_codes_update').value;

        if(stock_code === 'NO_STOCK_CODE'){
            document.getElementById('display_update').style.display = 'block';
        }else{
            document.getElementById('display_update').style.display = 'none';
        }
    }
    
</script>

<script>
    function confirmDelete(){
        let plan_id = document.getElementById('plan_id').value;
        Swal.fire({
            title: 'Do you want to delete this Plan?',
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: 'Yes',
            denyButtonText: 'No',
            customClass: {
                actions: 'my-actions',
                cancelButton: 'order-3',
                confirmButton: 'order-1 right-gap',
                denyButton: 'order-2',
            },
            }).then((result) => {
            if (result.isConfirmed) {
                deleteDetail(plan_id)
            } else if (result.isDenied) {
                Swal.fire('Changes are not saved', '', 'info')
            }
        })
    }
</script>

<script>
    function deleteDetail(id){
        let id_post = id;
        let irene_data = {
            iPlanId:id_post, 
        };
        
        
        $.ajax({
            type:'post',
            headers: {  'Access-Control-Allow-Origin': '*' },
            url:api_url+'/MonthlyPlan/DeletePlanDetail?iPlanId='+id_post,
            crossDomain: true,
            dataType: 'json',
            contentType: "application/json; charset=utf-8",
            success:function(data){
            } 
        });
       
        Swal.fire({
                position: "center",
                icon: "success",
                title: "Plan Successfully Deleted",
                showConfirmButton: false,
                timer: 2000
        });
        setTimeout(function(){
            refresh();
        }, 2000);

    }
</script>

<script>
    function approveMassPM(){
        let user = '{!!$user_name!!}';
        let mass_date_from = document.getElementById('mass_date_from').value;
        let mass_date_to = document.getElementById('mass_date_to').value;
        let pm_mass_remarks = document.getElementById('pm_mass_remarks').value;
        line_search = document.getElementById('line').value;
        
        if(mass_date_from == '' || mass_date_to == '' || pm_mass_remarks == ''){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "PLEASE FILL ALL THE FIELDS",
                showConfirmButton: false,
                timer: 2000
            });

        }else{
            let from_date_post = new Date(mass_date_from);
            let from_date_to_post = new Date(mass_date_to);
           
            if(from_date_post.getMonth() > from_date_to_post.getMonth()){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "FROM DATE IS GREATER THAN TO DATE",
                    showConfirmButton: false,
                    timer: 2000
                });
            }else if(from_date_post.getFullYear()!= from_date_to_post.getFullYear()){
                Swal.fire({
                    position: "center",
                    icon: "error",
                    title: "FROM DATE AND TO DATE SHOULD BE THE SAME YEAR",
                    showConfirmButton: false,
                    timer: 2000
                });

            }else{
                line_search = document.getElementById('line').value;
                $.ajax({
                    type: 'GET', //THIS NEEDS TO BE GET
                    url: irene_api_base_url+'/pm_mass_date/'+mass_date_from+'/'+mass_date_to+'/'+pm_mass_remarks+'/'+from_date_post.getFullYear()+'/'+from_date_post.getMonth()+'/'+line_search,
                    success: function (data) {
                        Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "SUCCESSFULLY SAVED",
                            showConfirmButton: false,
                            timer: 2000
                        });
                        setTimeout(() => {
                            refresh();
                            setTimeout(() => {
                                $('#modalMassPm').modal('hide');
                            }, 2000)
                        }, "2000");
                    }
                });
            }
           
        
        }
    }
</script>

<script>
    function approvePM(){
        let user = '{!!$user_name!!}';
        let plan_id = document.getElementById('plan_id').value;
        let pm_remarks = document.getElementById('pm_remarks').value;

        $.ajax({
            type: 'POST', //THIS NEEDS TO BE GET
            url: api_url+'/MonthlyPlan/ApprovedPmMonthlyPlan?iPlanId='+plan_id+'&cPmApprovedBy='+user+'&cRemarks='+pm_remarks,
            success: function (data) {
                Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "SUCCESSFULLY SAVED",
                    showConfirmButton: false,
                    timer: 2000
                });
                setTimeout(() => {
                    Swal.fire({
                            position: "center",
                            icon: "success",
                            title: "PM Successfully Approved",
                            showConfirmButton: false,
                            timer: 2000
                    });
                    refresh();
                    setTimeout(() => {
                        $('#modalDetail').modal('hide');
                    }, 2000)
                }, "2000");
            }
        });
        
        
    }

    function refresh(){
        setTimeout(() => {
            document.querySelector('.fc-refresh-button').click();
        }, 500) //1 second delay
    }

    function verifyJob(){
        let plan_id = document.getElementById('job_plan_id').value;
        let job_number = document.getElementById('job_number').value; 
        let job_stock_code = document.getElementById('job_stock_code').value; 
        

        if(!job_number){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "JOB NUMBER FIELD IS EMPTY",
                showConfirmButton: false,
                timer: 2000
            });
        }
        else{
            $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: irene_api_base_url+'/job/'+job_number,
            async: false,
            success: function (data) {
                if(data==1){
                    flag = 1;
                }else{
                    flag = 0;
                }
            }
            });
            
            $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Production/GetJobSysproDetails?ijob='+job_number,
            success: function (data) {
                irene_parse = JSON.parse(data);
                if(irene_parse.length > 0){
                    if(irene_parse[0].cStockCode === job_stock_code){

                    
                        document.getElementById('qty_to_make').value = irene_parse[0].nQtyToMake; 
                        document.getElementById('qty_to_make_display').style.display = 'block';
                        document.getElementById('qty_to_make').style.display = 'block';
                        document.getElementById('createJobDisplay').style.display = 'block'; 
                    
                    
                    }else{
                        document.getElementById('qty_to_make_display').style.display = 'none';
                        document.getElementById('qty_to_make').style.display = 'none';
                        document.getElementById('createJobDisplay').style.display = 'none'; 
                        if(flag === 0){
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title:"STOCK DOES NOT MATCH",
                                text: "STOCK CODE "+job_stock_code+" TO JOB STOCK CODE "+irene_parse[0].cStockCode,
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }else{
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title:'JOB '+job_number,
                                text: "ALREADY CREATED",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                        
                    }
                }else{
                    Swal.fire({
                        position: "center",
                        icon: "error",
                        title:"JOB DOES NOT EXIST",
                        text: "JOB "+job_number,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
            }
        });
        }
    }

    function hideJob(){
        document.getElementById('qty_to_make_display').style.display = 'none';
        document.getElementById('createJobDisplay').style.display = 'none'; 
    }

    function createJob(){
        let job_number = document.getElementById('job_number').value; 
        let plan_id = document.getElementById('plan_id').value;
        
        let qty_to_make = document.getElementById('qty_to_make').value;
        document.getElementById("createJobDisplay").disabled = true;
        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Production/GetJobSysproDetails?ijob='+job_number,
            success: function (data) {
                irene_parse = JSON.parse(data);
                $('#modalDetail').modal('show');
                $.ajax({
                    type:'POST',
                    method:'POST',
                    url:api_url+'/Production/CreateJob',
                    crossDomain: true,
                    dataType: 'json',
                    headers: { 
                        'Accept': 'application/json',
                        'Content-Type': 'application/json' 
                    },
                    data:  JSON.stringify({
                        'iPlanId':plan_id,
                        'iJobNo':job_number,
                        'dJobDate':irene_parse[0].dJobDate,
                        'nQtyToMake':irene_parse[0].nQtyToMake,
                        'cStockCode':irene_parse[0].cStockCode,
                        'cDescription':irene_parse[0].cDescription,
                        'cLongDesc':irene_parse[0].cLongDesc,
                        'cStatus':'Pending',
                        'nQtyProduce':0
                    }),
                    success:function(data){
                       
                        if(data.indexOf("Column1") > -1){
                            Swal.fire({
                                position: "center",
                                icon: "error",
                                title: "STOCK CODE DOES NOT EXIST",
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }else{
                            var base_url =  '{{ url("/")}}';
                            let title = 'JOB '+job_number+' CREATED';
                            let content = 'PLEASE CREATE A MACHINE JOB FOR JOB '+job_number;
                            let department = 'production';
                            setTimeout(() => {
                                $.ajax({
                                type: 'GET', //THIS NEEDS TO BE GET
                                url: base_url+'/api/emailSend/'+title+'/'+content+'/'+department,
                                success: function (data) { 
                                    setTimeout(() => {
                                        refresh();
                                        $('#modalDetail').modal('hide');
                                    }, "5000");
                                }
                            });
                            }, "1000");
                           
                        }
                        document.getElementById("createJobDisplay").disabled = false;
                    }
                });    
            }
        });
    }

    function insertPlan(){
        let stock_code = document.getElementById('stock_codes_create_plan').value;
        let date_plan = document.getElementById('date_plan').value;
        
        let line_plan = document.getElementById('line_plan').value;
        let qty_plan = document.getElementById('qty_plan').value;

        if(stock_code === 'NO_STOCK_CODE' || date_plan === '' || line_plan === '' || qty_plan === ''){
            Swal.fire({
                position: "center",
                icon: "error",
                title: "PLEASE FILL UP ALL FIELDS",
                showConfirmButton: false,
                timer: 2000
            });
        }else{
            let date_plan_2 = new Date();
            let month_plan = date_plan_2.getMonth()+1;
            let year_plan = date_plan_2.getFullYear();
            Swal.fire({
                position: "center",
                icon: "success",
                title: "PLAN SUCCESSFULLY CREATED",
                showConfirmButton: false,
                timer: 3000
            });
            $.ajax({
                type:'POST',
                method:'POST',
                url:api_url+'/MonthlyPlan/PostPlanByDay',
                crossDomain: true,
                dataType: 'json',
                headers: { 
                    'Accept': 'application/json',
                    'Content-Type': 'application/json' 
                },
                data: JSON.stringify({
                    "nYear":year_plan,
                    "nMonth":month_plan,
                    "dPlanDate":date_plan,
                    "cStockCode":stock_code,
                    "cQty":qty_plan,
                    "nLineNo":line_plan
                }),
                success:function(data){
                   
                }
            });    

            setTimeout(() => {
                refresh();
                $('#modalCreate2').modal('hide');
            }, "2000");
        }
    }
</script>
