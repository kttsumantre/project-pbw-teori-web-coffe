<x-layouts.shop :title="$product->name">
@php
    $name = strtolower($product->name);
    $img = match(true) {
        str_contains($name, 'cappuccino') => 'https://images.unsplash.com/photo-1541167760496-1628856ab772?w=900&q=80',
        str_contains($name, 'espresso') => 'https://images.unsplash.com/photo-1510591509098-f4fdc6d0ff04?w=900&q=80',
        str_contains($name, 'cold brew') => 'https://images.unsplash.com/photo-1517701604599-bb29b565090c?w=900&q=80',
        str_contains($name, 'coklat') => 'https://images.unsplash.com/photo-1517578239113-b03992dcdd25?w=900&q=80',
        str_contains($name, 'croissant') => 'https://images.unsplash.com/photo-1555507036-ab1f4038808a?w=900&q=80',
        str_contains($name, 'kentang') => 'https://images.unsplash.com/photo-1573080496219-bb080dd4f877?w=900&q=80',
        str_contains($name, 'tubruk') => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=900&q=80',
        str_contains($name, 'susu') => 'https://images.unsplash.com/photo-1461023058943-07fcbe16d735?w=900&q=80',
        default => 'https://images.unsplash.com/photo-1509042239860-f550ce710b93?w=900&q=80',
    };
@endphp
    <a href="{{ route('home') }}#menu" class="text-sm font-medium text-stone-600 hover:text-stone-900">&larr; Kembali ke menu</a>

    <div class="mt-6 grid gap-10 md:grid-cols-2">
        <div class="overflow-hidden rounded-xl border border-stone-200 bg-stone-100" style="height: 420px; display: block;">
            <img src="{{ $img }}" alt="{{ $product->name }}" class="w-full object-cover" style="height: 420px; width: 100%; object-fit: cover; display: block;">
        </div>

        <div>
            @if ($product->category)
                <a href="{{ route('home', ['category' => $product->category->slug]) }}#menu" class="text-sm font-medium text-amber-800 hover:underline">
                    {{ $product->category->name }}
                </a>
            @endif

            <h1 class="mt-1 text-3xl font-extrabold tracking-tight text-stone-900">{{ $product->name }}</h1>
            <p class="mt-3 text-2xl font-bold tabular-nums text-stone-900"><x-money :value="$product->price" /></p>

            @if ($product->description)
                <p class="mt-5 max-w-prose leading-relaxed text-stone-700">{{ $product->description }}</p>
            @endif

            <div class="mt-8 border-t border-stone-200 pt-6">
                @if ($product->stock > 0)
                    <p class="text-sm text-stone-600">
                        @if ($product->stock <= 5)
                            Tinggal {{ $product->stock }} porsi.
                        @else
                            Tersedia.
                        @endif
                    </p>

                    <form method="POST" action="{{ route('cart.store', $product) }}" class="mt-3 flex items-end gap-3">
                        @csrf
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-stone-700">Jumlah</label>
                            <x-input name="quantity" type="number" :value="1" min="1" :max="min($product->stock, 99)" class="mt-1 w-24" />
                        </div>
                        <x-button class="px-5 py-2.5">Tambah ke keranjang</x-button>
                    </form>
                    <x-input-error :messages="$errors->get('quantity')" class="mt-2" />
                @else
                    <p class="font-semibold text-red-700">Menu ini sedang habis.</p>
                @endif
            </div>
        </div>
    </div>
</x-layouts.shop>