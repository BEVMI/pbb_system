<script>
    
    loadFGFilter('0');
    function loadFGFilter(flag){
        if(flag ==='0'){
            stock_code = '';
        }
        else{
            stock_code = document.getElementById('stock_code').value;
        }
        $('#fg_table').empty();

        $.ajax({
            type: 'GET', //THIS NEEDS TO BE GET
            url: api_url+'/Inventory/GetFGStockCodes?cText='+stock_code,
            success: function (data) {
                irene_parse = JSON.parse(data);
                
                $.each(irene_parse, function(index,item) {
                    var x = document.getElementById('fg_table').insertRow(-1);
                    var i = x.insertCell(0);
                    var r = x.insertCell(1);
                    var e = x.insertCell(2);
                    var n = x.insertCell(3);
                    var y = x.insertCell(4);
                    var l = x.insertCell(5);
                    var v = x.insertCell(6);
                    var p = x.insertCell(7);
                    var j = x.insertCell(8);
                    var o = x.insertCell(9);

                    let qty_on_hand_net = item.QtyOnHand.toFixed(2) - item.QtyAllocated.toFixed(2);
                    let average_sales_two = item.AveSales.toFixed(2) * 2;
                    let total_irene = average_sales_two.toFixed(2) - qty_on_hand_net.toFixed(2);
                    let inventory_cover = qty_on_hand_net.toFixed(2)/item.AveSales.toFixed(2);
                    let completion_days = total_irene.toFixed(2) / item.DailyCapacity.toFixed(2);
                    if(average_sales_two >= qty_on_hand_net){
                        p.innerHTML =  total_irene.toFixed(2);
                    }else{
                        p.innerHTML = 0;
                    }

                    i.innerHTML = item.cStockCode+'<br>'+item.cDescription+'<br>'+item.cLongDesc;
                    r.innerHTML = item.QtyOnHand;  
                    e.innerHTML = item.QtyAllocated;
                    n.innerHTML = qty_on_hand_net;    
                    y.innerHTML = item.QtyOnBackOrder;   
                    l.innerHTML = item.DailyCapacity;             
                    v.innerHTML = item.AveSales.toFixed(2);

                    if (isNaN(inventory_cover)) {
                        j.innerHTML = '-';
                    }else{
                        j.innerHTML = inventory_cover.toFixed(2);
                    }
                   
                    if (isNaN(completion_days)) {
                        o.innerHTML = '-';
                    }else{
                        if(completion_days==Infinity ){
                            o.innerHTML = '-';
                        }else{
                            o.innerHTML = Math.ceil(completion_days);
                        }
                        
                    }
                    
                });
            }
        });
    }
</script>