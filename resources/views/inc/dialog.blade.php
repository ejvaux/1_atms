
@if ($errors->any())
    @php
        $err = '<ul>';
        foreach ($errors->all() as $error){
            $err .= "<li>".$error."</li>";
        }
        $err .= '</ul>';
        echo "<script>
        iziToast.warning({
        position: 'topCenter',
        timeout: false,
        message: '".$err."'
        });
        </script>";     
    @endphp
@endif

@if(session('success'))
    @php
        echo "<script>
        iziToast.success({
        position: 'topCenter',
        timeout: 5000,
        message: '".session('success')."'
        });
        </script>";  
    @endphp
@endif

@if(session('error'))
    @php
        echo "<script>
        iziToast.error({
        position: 'topCenter',
        timeout: 5000,
        message: '".session('error')."'
        });
        </script>";  
    @endphp
@endif
    
