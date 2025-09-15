<div {{ $attributes->merge([
    'class' => 'bg-white shadow-sm border border-zinc-100 rounded-lg',
]) }}>
    {{ $slot }}
</div>
