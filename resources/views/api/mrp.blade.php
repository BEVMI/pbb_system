<script>
    $(document).ready(function(){
        let get_source = 'Plan';
        let get_type = 'Summary';
        let get_month = {!!$month_now!!};
        let get_year = {!!$year_now!!};

        getMaterials(get_month,get_year,get_source,get_type);
    });
</script>

<script>
    function computeMaterials(){
        let month = document.getElementById('month_now').value;
        let year_now = document.getElementById('year_now').value;
        let source = document.getElementById('source').value;
        

        $.ajax({
            type:'POST',
            method:'POST',
            url:api_url+'/Mrp/ComputeMaterials?nYear='+year_now+'&nMonth='+month+'&cSource='+source,
            contentType: false,
            processData: false,
            success:function(data){
                Swal.fire({
                position: "center",
                icon: "success",
                title: "COMPUTATION SUCCESSFULLY",
                showConfirmButton: false,
                timer: 2500
            });

            setTimeout(function(){
                    location.reload();
                }, 2500);
            }
        });    
    }
</script>

<script>
    function getComputed(){
        let get_month = document.getElementById('get_month').value;
        let get_year = document.getElementById('get_year').value;
        let get_source = document.getElementById('get_source').value;
        let get_type = document.getElementById('get_type').value;

        getMaterials(get_month,get_year,get_source,get_type);
    }
</script>

<script>
     function getMaterials(get_month,get_year,get_source,get_type){
        
        let base_url = '{!!$irene_base_url!!}';
        $('#get_header').empty();

        Swal.fire({
            position: "center",
            icon: "success",
            title: "LOADING PLEASE WAIT",
            showConfirmButton: false,
            timer: 2000
        });
        if(get_type  === 'Summary'){
            document.getElementById('table-plan').style.display = 'block';
            document.getElementById('table-detail').style.display = 'none';
            $.ajax({
                type: 'GET', //THIS NEEDS TO BE GET
                url: api_url+'/Mrp/GetComputedMaterials?nYear='+get_year+'&nMonth='+get_month+'&cSource='+get_source+'&cType='+get_type,
                success: function (data) {
                    irene_parse = JSON.parse(data);
                
                    $.each(irene_parse, function(index,item) {
                        var x = document.getElementById('get_header').insertRow(-1);
                        var i = x.insertCell(0);
                        var r = x.insertCell(1);
                        var e = x.insertCell(2);
                        var n = x.insertCell(3);
                        var j = x.insertCell(4);
                        var o = x.insertCell(5);
                        var y = x.insertCell(6);

                        i.innerHTML = item.cStockCodeComponent;
                        r.innerHTML = item.cDescriptionComponent;  
                        e.innerHTML = item.cLongDescComponent;
                        n.innerHTML = item.nOnHand.toFixed(2);    
                        j.innerHTML = item.nOnOrder.toFixed(2);      
                        o.innerHTML = item.nTotalRequired.toFixed(2);   
                        y.innerHTML = item.nToOrder.toFixed(2);             
                    });
                }
            });
        }
        else{
            document.getElementById('table-plan').style.display = 'none';
            document.getElementById('table-detail').style.display = 'block';
            document.getElementById("detail_frame").src=base_url+'/mrp_detail/'+get_month+'/'+get_year+'/'+get_source;
        }
    }
</script>