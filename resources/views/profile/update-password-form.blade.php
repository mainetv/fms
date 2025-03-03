<div>
  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif
  <x-jet-form-section submit="updatePassword">
    <x-slot name="title">
      <div class="mb-2">
        {{ __('Update Password') }}
      </div>
    </x-slot>

    <x-slot name="description">
      <div class="mb-2">
      </div>
      {{-- {{ __('Ensure your account is using a long, random password to stay secure.') }} --}}
    </x-slot>

    <x-slot name="form">
      <div class="w-md-75">
        <div class="mb-3">
          <x-jet-label for="current_password" value="{{ __('Current Password') }}" />
          <x-jet-input id="current_password" type="password"
            class="{{ $errors->has('current_password') ? 'is-invalid' : '' }}" wire:model.defer="state.current_password"
            autocomplete="current-password" />
          <x-jet-input-error for="current_password" />
        </div>

        <div class="mb-3">
          <x-jet-label for="password" value="{{ __('New Password') }}" />
          <x-jet-input id="password" type="password" class="{{ $errors->has('password') ? 'is-invalid' : '' }}"
            wire:model.defer="state.password" autocomplete="new-password" />
          <x-jet-input-error for="password" />
        </div>

        <div class="mb-3">
          <x-jet-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
          <x-jet-input id="password_confirmation" type="password"
            class="{{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}"
            wire:model.defer="state.password_confirmation" autocomplete="new-password" />
          <x-jet-input-error for="password_confirmation" />
        </div>
      </div>
    </x-slot>

    <x-slot name="actions">
      <div class="w-100 text-start">
        <x-jet-button wire:loading.attr="disabled" wire:target="updatePassword"
          class="d-inline-flex align-items-center">
          <span wire:loading.remove wire:target="updatePassword" class="text-nowrap">
            {{ __('Save') }}
          </span>
          <span wire:loading wire:target="updatePassword" class="spinner-border spinner-border-sm ms-2" role="status">
            <span class="visually-hidden">Loading...</span>
          </span>
        </x-jet-button>
      </div>
    </x-slot>
  </x-jet-form-section>
</div>
<script>
  window.addEventListener('password-updated', () => {
    alert('Your password has been changed successfully.');
  });
</script>
