<script>
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
</script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    let api_url = '{!!$api_url!!}';
    let current_year = '{!!$year_now!!}';
    let current_month = '{!!$month_now!!}';
    let page_number = 1;
    let status = 'all';
    console.log(current_year);
    loadPo(api_url,current_year,current_month,page_number,status);

    function loadPo(api_url,current_year,current_month,page_number,status){
        console.log(api_url);
        var fd = new FormData();
        fd.append('nYear',current_year);
        fd.append('nMonth',current_month);
        fd.append('nPageNum',page_number);
        fd.append('cStatus',status);
        
        $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: api_url+'/PurchaseOrder/GetPOCompliance',
        data: fd,
        // dataType: 'json',
        // contentType: "application/json; charset=utf-8",
        processData: false,
        success: function (data) {
            irene_parse = JSON.parse(data);
            // console.log(irene_parse[0][0].SalesOrder);
            // console.log(irene_parse[1][0].Totalpage);
            irene_parse_2 = irene_parse[0];
            console.log(irene_parse_2);
            $.each(irene_parse_2, function(index,item) {
                var x = document.getElementById('get_header_po').insertRow(-1);
            
                var i = x.insertCell(0);
                var r = x.insertCell(1);
                var e = x.insertCell(2);
                var n = x.insertCell(3);
                
            

                i.innerHTML = item.SalesOrder;
                r.innerHTML = item.Customer;

            });

        },
        error: function() { 
        }
    });
    }
</script>

{{-- <script>
    function loadPo(api_url,current_year,current_month,page_number,status){
    // var fd = new FormData();
    //     fd.append('nYear',current_year);
    //     fd.append('nMonth',current_month);
    //     fd.append('nPageNum',page_number);
    //     fd.append('cStatus',status);

    //     console.log(fd);
    
    // $.ajax({
    //     type: 'GET', //THIS NEEDS TO BE GET
    //     url: api_url+'/Forecast/GetForecastHeader/',
    //     data: fd,
    //     processData: false,
    //     success: function (data) {
    //         irene_parse = JSON.parse(data);
    //         $.each(irene_parse, function(index,item) {
    //             var x = document.getElementById('get_header_forecast').insertRow(-1);
            
    //             var i = x.insertCell(0);
    //             var r = x.insertCell(1);
    //             var e = x.insertCell(2);
    //             var n = x.insertCell(3);
                
            

    //             i.innerHTML = item.id;
    //             r.innerHTML = post_month;
    //             e.innerHTML = item.nYear;
    //             n.innerHTML = '<a href="#" class="btn btn-success mt-2 mt-xl-0 view_data" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+item.id+'"> <i class="fas fa-eye"></i></a>&nbsp;<a onclick="confirmDeleteForecastHeader('+item.id+')" href="#" class="btn btn-danger mt-2 mt-xl-0"><i class="fa-solid fa-trash"></i></a>';
    //         });

    //     },
    //     error: function() { 
    //     }
    // });
    }
</script> --}}
