@props(['product'])
@php
    $name = strtolower($product->name);
    $img = match(true) {
        str_contains($name, 'cappuccino') => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=800&q=80',
        str_contains($name, 'espresso') => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=800&q=80',
        str_contains($name, 'cold brew') => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=800&q=80',
        str_contains($name, 'coklat') => 'https://images.unsplash.com/photo-1517578239113-b03992dcdd25?w=800&q=80',
        str_contains($name, 'croissant') => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=800&q=80',
        str_contains($name, 'kentang') => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=800&q=80',
        str_contains($name, 'tubruk') => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=800&q=80',
        str_contains($name, 'susu') => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=800&q=80',
        default => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=800&q=80',
    };
    $emoji = str_contains($name, 'croissant') || str_contains($name, 'kentang') ? '🥐' : '☕';
@endphp
<article class="group flex flex-col overflow-hidden rounded-xl border border-stone-200 bg-white shadow-sm transition hover:shadow-lg hover:-translate-y-1">
    <a href="{{ route('products.show', $product->slug) }}"class="relative block overflow-hidden bg-stone-100" style="height: 192px; display: block;""">
        <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy" class="h-full w-full object-cover transition group-hover:scale-105" style="height: 192px; width: 100%; object-fit: cover; display: block;"">
        <span class="absolute left-3 top-3 rounded-full bg-white/90 px-2.5 py-1 text-xs font-semibold text-stone-800">{{ $product->category?->name ?? 'Lainnya' }}</span>
        <span class="absolute right-3 top-3 rounded-full bg-white/90 px-2 py-1 text-sm">{{ $emoji }}</span>
    </a>

    <div class="flex flex-1 flex-col p-4">
        <h3 class="text-base font-bold text-stone-900">
            <a href="{{ route('products.show', $product->slug) }}" class="hover:underline">{{ $product->name }}</a>
        </h3>
        <p class="mt-1 line-clamp-2 text-sm text-stone-500">{{ $product->description ?? 'Dibuat fresh, disajikan hangat untuk nemenin hari kamu.' }}</p>

        <div class="mt-auto flex items-center justify-between gap-3 pt-4">
            <span class="text-lg font-extrabold tabular-nums text-stone-900"><x-money :value="$product->price" /></span>

            @if ($product->stock > 0)
                <form method="POST" action="{{ route('cart.store', $product) }}">
                    @csrf
                    <x-button class="px-4 py-2">+ Tambah</x-button>
                </form>
            @else
                <span class="rounded-full bg-red-50 px-3 py-1 text-sm font-medium text-red-700">Habis</span>
            @endif
        </div>
    </div>
</article>