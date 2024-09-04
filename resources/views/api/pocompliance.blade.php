<script>
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');   
</script>
<script src="{{asset('js/select2.min.js')}}"></script>
<script>
    
    let current_year = '{!!$year_now!!}';
    let current_month = '{!!$month_now!!}';
    let page_number = 1;
    let status = '';
   
    loadPo(api_url,current_year,current_month,page_number,status);
    

    function loadPoFilter(){
        let months_filter = document.getElementById('months').value;   
        let year_now_filter = document.getElementById('year_now').value;   
        let status_filter = document.getElementById('status').value;
        let load_pages_filter = document.getElementById('load_pages').value;
        
        loadPo(api_url,year_now_filter,months_filter,load_pages_filter,status_filter);
    }

    function loadPo(api_url,current_year,current_month,page_number,status){
        $('#get_header_po').empty();
        var fd = new FormData();
        fd.append('nYear',current_year);
        fd.append('nMonth',current_month);
        fd.append('nPageNum',page_number);
        fd.append('cStatus',status);
        
        $.ajax({
        type: 'GET', //THIS NEEDS TO BE GET
        url: api_url+'/PurchaseOrder/GetPOCompliance?nYear='+current_year+'&nMonth='+current_month+'&nPageNum='+page_number+'&cStatus='+status,
        data: fd,
        // dataType: 'json',
        // contentType: "application/json; charset=utf-8",
        processData: false,
        success: function (data) {
            irene_parse = JSON.parse(data);
            totalpages = irene_parse[1][0].Totalpage+1;
            $("#load_pages").empty();
            for (let i = 1; i < totalpages; i++) {
                $('#load_pages').append("<option value="+i+">"+i+"</option>")
            }
            document.getElementById('load_pages').value = page_number;
            irene_parse_2 = irene_parse[0];
            $.each(irene_parse_2, function(index,item) {
                var x = document.getElementById('get_header_po').insertRow(-1);
            
                var i = x.insertCell(0);
                var r = x.insertCell(1);
                var o = x.insertCell(2);
                var e = x.insertCell(3);
                var n = x.insertCell(4);
                var j = x.insertCell(5);
                
                if(item.OrderStatus == 9){
                    irene_status = '<span class="badge bg-success">COMPLETED</span>';
                }else if(item.OrderStatus == 'S'){
                    irene_status = '<span class="badge bg-warning">SUSPEND</span>';
                }
                else{
                    irene_status = '<span class="badge bg-secondary">OPEN PO</span>';
                }

                i.innerHTML = parseInt(item.SalesOrder,10);
                r.innerHTML = item.Customer;
                o.innerHTML = item.Compliance+'%';
                e.innerHTML = item.CustomerPoNumber;
                n.innerHTML = irene_status;
                j.innerHTML = '<a href="#" class="btn btn-success mt-2 mt-xl-0 view_data" data-bs-toggle="modal" data-bs-target="#modalView" data-id="'+item.SalesOrder+'"> <i class="fas fa-eye"></i></a>';

            });

            Swal.fire({
                    position: "center",
                    icon: "success",
                    title: "LOADING PLEASE WAIT",
                    showConfirmButton: false,
                    timer: 3000
            });
        },
        error: function() { 
        }
    });
    }
</script>

<script>
    $(document).ready(function(){
        $(document).on('click', '.view_data', function (e) {
            let sales_order = $(this).data('id');
            
            $('#ireneTable4').empty();

            $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/PurchaseOrder/GetPODetails?cSalesOrder='+sales_order,
            data: {
                cSalesOrder:sales_order
            },
                success: function (data) {
                    irene_parse = JSON.parse(data);
                    $.each(irene_parse, function(index,item) {
                    let sales_order = document.getElementById('sales_order_column').innerHTML = 'SALES ORDER - '+parseInt(item.SalesOrder,10);
                    var x = document.getElementById('ireneTable4').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);
                    var o = x.insertCell(5);
                    var p = x.insertCell(6);

                    if(item.MStockCode==null || item.MStockCode==' ' || item.MStockCode==''){
                        i.innerHTML = item.MStockDes+'<br>'+item.LongDesc;
                    }else{
                        i.innerHTML = item.MStockCode+'<br>'+item.MStockDes+' '+item.LongDesc;
                    }
                    if(item.AddrCode==null){
                        r.innerHTML = item.ShortName;
                    }else{
                        r.innerHTML = item.ShortName+' - '+item.AddrCode;
                    }
                    // let orderDate = Date.parse(item.OrderDate);
                    e.innerHTML = formatDate(item.OrderDate);
                    n.innerHTML = formatDate(item.ReqShipDate);
                    j.innerHTML = item.MOrderQty;
                    o.innerHTML = item.MBackOrderQty;
                    p.innerHTML = item.MOrderUom;
                    });
                }
            });
        });            
    });
</script>

<script>

</script>

