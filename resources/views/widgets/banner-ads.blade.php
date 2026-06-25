@if(!empty($imageUrl))
<div class="mb-12 w-full flex justify-center">
    <a href="{{ $targetLink }}" target="_blank" rel="noopener noreferrer" class="block w-full max-w-5xl rounded-xl overflow-hidden shadow-md hover:shadow-xl transition-shadow group relative">
        <img src="{{ $imageUrl }}" alt="Advertisement" class="w-full h-auto object-cover md:max-h-48 group-hover:scale-105 transition-transform duration-500">
        
        <!-- Label kecil penanda Iklan -->
        <span class="absolute top-2 right-2 bg-black/50 text-white text-[10px] px-2 py-1 rounded backdrop-blur-sm uppercase tracking-widest">
            Ad
        </span>
    </a>
</div>
@endif