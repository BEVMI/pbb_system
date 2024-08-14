{{-- <script src="{{asset('evo-calendar/js/evo-calendar.min.js')}}"></script> --}}
<script src='{{asset('js/index.global.js')}}'></script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
$( "#location_id" ).select2({
    dropdownParent: $("#modalCreate"),
    ajax: { 
        url: '{{url("/location_ajax")}}',
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
        return {
            _token: CSRF_TOKEN,
            search: params.term, 
            };
        },
        processResults: function (response) {
        return {
            results: response.data
            };
        },
        cache: true
    }

})

$( "#frequency_id" ).select2({
    dropdownParent: $("#modalCreate"),
    ajax: { 
        url: '{{url("/frequency_ajax")}}',
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
        return {
            _token: CSRF_TOKEN,
            search: params.term, 
            };
        },
        processResults: function (response) {
        return {
            results: response.data
            };
        },
        cache: true
    }

})

$( "#inventory_id" ).select2({
    dropdownParent: $("#modalCreate"),
    ajax: { 
        url: '{{url("/inventory_ajax")}}',
        type: "post",
        dataType: 'json',
        delay: 250,
        data: function (params) {
        return {
            _token: CSRF_TOKEN,
            search: params.term, 
            };
        },
        processResults: function (response) {
        return {
            results: response.data
            };
        },
        cache: true
    }

})
</script>

<script>
    Array.prototype.clear = function() {
        this.splice(0, this.length);
    };
    let irene2 = [];
    let companies = 'irene';
    let month = {!!$month!!};
    
    let year = {!!$year!!};
    let department_id = '{!!$department_id!!}';
    console.log(month);
    $.ajax({
        async: false,
        type:"GET",//or POST
        url:'{{url("/calendar_ajax/")}}'+'/'+month+'/'+year+'/'+companies+'/'+department_id,
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
                    initialDate: '2024-08-01',
                    editable: false,
                    themeSystem: 'bootstrap5',
                    selectable: true,
                    initialView: 'dayGridMonth',
                    businessHours: true,
                    dayMaxEvents: true, // allow "more" link when too many events
                    events: irene2,
                    eventClick: function(info) {
                        console.log(info.event.extendedProps.location);
                        document.getElementById('main-title').innerHTML = info.event.title; 
                        document.getElementById('header_id_store').value = info.event.id;
                        document.getElementById('main_location').innerHTML = info.event.extendedProps.location;
                        info.el.style.borderColor = 'red';
                    }
                });
                calendar.render();
            }, "1000");
        });
 
  </script>
<script>
    function irene(flag){
        if(flag===0){
            document.getElementById('table-now').style.display = '';
            document.getElementById('table-now-2').style.display = 'none';
        }
        else{
            document.getElementById('table-now').style.display = 'none';
            document.getElementById('table-now-2').style.display = '';
        }
    }

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
            url:'{{url("/calendar_ajax/")}}'+'/'+month[initialDatePost.getMonth()]+'/'+initialDatePost.getFullYear()+'/'+companies+'/'+department_id,
            success:function(calendars){
                irene2 = calendars.data;
            }   
        });
        return irene2;
    }

    function finalize(){
        header_id = document.getElementById('header_id_store').value;
        tech_remarks = document.getElementById('tech_remarks').value;
        control_number = document.getElementById('control_number').value;
        attachment = document.getElementById('attachment').value;
    }
</script>