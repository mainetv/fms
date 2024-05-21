<div class="container">
    <div class="row justify-content-center my-5">
        <div class="col-sm-12 col-md-8 col-lg-5 my-4">
            <div>    
                {{-- {{ $logo }}             --}}
                <div class="login-logo">     
                    <img src="{{ asset('images/dost-pcaarrd-logo.png') }}" width="18%"/>                                  
                    <p style="font-weight: bold;margin-bottom: 0px;">DOST-PCAARRD</p>
                    <h1 style="font-weight: bold;color: #a5d5f5;margin-bottom: 0px;text-shadow: 1px 1px 3px rgb(0,0,0,0.3)">
                        Financial Management 
                        <span style="font-weight: bold;color: #fff;text-shadow: 1px 1px 3px rgb(0,0,0,0.3);">System</span></h1>
                </div>
            </div>
            <div>
                {{ $slot }}                
            </div>
            <p style="text-align:center;">Copyright © 2022. PCAARRD FMS. All Rights Reserved.
        </div>
    </div>
</div>