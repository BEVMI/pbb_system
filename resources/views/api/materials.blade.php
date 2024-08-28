<script>
    let api_url = '{!!$api_url!!}';
    loadMaterialFilter('0');

    function loadMaterialFilter(flag){
        if(flag ==='0'){
            stock_code = 'AQL01';
        }
        else{
            stock_code = document.getElementById('stock_code').value;
        }
        $('#get_header_materials').empty();

        Swal.fire({
                position: "center",
                icon: "success",
                title: "LOADING PLEASE WAIT",
                showConfirmButton: false,
                timer: 2000
        });

        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Inventory/GetComponentInventory?cFGSku='+stock_code,
            success: function (data) {
                irene_parse = JSON.parse(data);
                
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('get_header_materials').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var j = x.insertCell(4);
                    var o = x.insertCell(5);
                    var y = x.insertCell(6);
                    var l = x.insertCell(7);

                    i.innerHTML = item.StockCode;
                    r.innerHTML = item.Description;  
                    e.innerHTML = item.LongDesc;
                    n.innerHTML = item.StockUom;    
                    j.innerHTML = item.QtyOnHand;      
                    o.innerHTML = item.QtyOnOrder;   
                    y.innerHTML = item.QtyAllocatedWip;   
                    l.innerHTML = item.FutureBalance;             
              
                });
            }
        });
    }
</script>