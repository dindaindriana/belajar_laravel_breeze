<div {{ $attributes->merge([
    'class' => 'bg-zinc-900 border border-zinc-800 shadow-sm rounded-lg',
]) }}>
    {{ $slot }}
</div>
