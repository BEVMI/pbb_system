
    @if ($message = Session::get('success'))
        <script>
            Swal.fire({
                position: "center",
                icon: "success",
                title: "SUCCESS",
                text: "{!!$message!!}",
                showConfirmButton: false,
                timer: 1500
            })
        </script>
    @endif
    @if ($message = Session::get('danger'))
        
        <script>
            Swal.fire({
                position: "center",
                icon: "error",
                title: "ERROR",
                text: "{!!$message!!}",
                showConfirmButton: false,
                timer: 1500
            })
        </script>
                    
    @endif

@if(count($errors) > 0 )
    <script>
        const wrapper = document.createElement('div');
        wrapper.innerHTML = "";
        console.log(wrapper);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "PLEASE CHECK YOUR INPUTS",
            html: "<pre><b>{!! implode('\n',$errors->all()) !!}</b></pre>",  
            showConfirmButton: false,
            timer: 3500
        })
    </script>
@endif

<script>
    $(document).ready(function(){
        $(".loading_button").click(function(){
            console.log('irene');
            Swal.fire({
                position: "center",
                icon: "success",
                title: "PLEASE WAIT",
                showConfirmButton: false,
            })
        });
    });
</script>
