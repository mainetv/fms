<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-primary text-white text-uppercase']) }}>
    {{ $slot }}
</button>
