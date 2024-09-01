<script>
    function uploadPlan(){
        let month_upload = document.getElementById('month_upload').value;
        let year_now = document.getElementById('year_now').value;
        let line = document.getElementById('line').value;
        let upload_file_irene =  $('#plan_upload')[0].files;
        let api_url = '{!!$api_url!!}';
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
    let initial_date = '{{$initial_date}}';

    Array.prototype.clear = function() {
        this.splice(0, this.length);
    };
    let irene2 = [];
    let month = {!!$month_now!!};
    let line = {!!$line!!};
    let year = {!!$year_now!!};
    $.ajax({
        async: false,
        type:"GET",//or POST
        url:'{{url("/plan_ajax/")}}'+'/'+year+'/'+month+'/'+line,
        success:function(calendars){
           irene2 = calendars.data;
        }
    });

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
                                calendar.refetchEvents();
                            }, "1");
                          }
                        }
                    },
                    headerToolbar: {
                        left: 'prevButton,nextButton,prevYearButton,nextYearButton',
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
                        document.getElementById('plan_id').value = info.event.id;
                        document.getElementById('planTitle').innerHTML = info.event.title;
                        document.getElementById('qty_update').value = info.event.extendedProps.plan_qty;
                        if(info.event.extendedProps.plan_qty === 0){
                            document.getElementById('stock_codes_update').value = 'NO_STOCK_CODE';
                            document.getElementById('display_update').style.display = 'block';
                            document.getElementById('custom_update').value = info.event.title;
                        }else{
                            document.getElementById('stock_codes_update').value = info.event.extendedProps.stock_code;
                            document.getElementById('display_update').style.display = 'none';
                            document.getElementById('custom_update').value = '';
                        }
                        $('#modalDetail').modal('show');
                    }
                });
                calendar.render();
            }, "1000");
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
        let api_url = '{!!$api_url!!}';

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
                            location.reload();
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
                        location.reload();
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
        let api_url = '{!!$api_url!!}';
        
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
           location.reload();
        }, 2000);

    }
</script>
