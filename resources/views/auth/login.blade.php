<x-guest-layout>
    <x-jet-authentication-card>
        <x-slot name="logo">
            <x-jet-authentication-card-logo />
        </x-slot>
        
        <div class="login-card-body">

            <x-jet-validation-errors class="mb-3 rounded-0" />

            @if (session('status'))
                <div class="alert alert-success mb-3 rounded-0" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{-- <center>
                <img src="{{ asset('/images/maintenance.png') }}" alt="" class="float-left" width="700px" style="opacity: .8">
            </center> --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group mb-3">
                    <x-jet-input class="{{ $errors->has('username') ? 'is-invalid' : '' }}" type="text"
                        name="username" :value="old('username')" placeholder="Username" required />
                    <x-jet-input-error for="username"></x-jet-input-error>
                </div>

                <div class="input-group mb-3">
                    <x-jet-input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" type="password"
                        name="password" required autocomplete="current-password" placeholder="Password"/>
                    <x-jet-input-error for="password"></x-jet-input-error>
                </div>

                <div class="input-group mb-3">
                    <div class="custom-control custom-checkbox">
                        <x-jet-checkbox id="remember_me" name="remember" />
                            {{ __('Remember Me') }}
                    </div>
                </div>

                <div class="input-group mb-3 ">
                    <x-jet-button class="btn btn-primary btn-block">
                        {{ __('Log in') }}
                    </x-jet-button>
                </div>
            </form>
        </div>
    </x-jet-authentication-card>
</x-guest-layout>