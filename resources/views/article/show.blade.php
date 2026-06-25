@inject('generalSettings', 'App\Settings\GeneralSettings')
@inject('monetizationSettings', 'App\Settings\MonetizationSettings')

@php
// Ambil total views dari tabel agregat article_daily_stats secara real-time & efisien
$totalViews = \DB::table('article_daily_stats')
->where('article_id', $article->id)
->sum('total_views') ?? 0;

// URL & Judul untuk keperluan Social Share
$shareUrl = urlencode(request()->url());
$shareTitle = urlencode($article->title);

@endphp

<x-layouts.app :title="$article->title" :description="$article->excerpt">
    {{-- Toast Notification untuk Sukses Salin Tautan --}}
    <div id="toast-copy" class="fixed bottom-5 right-5 z-[9999] transform translate-y-20 opacity-0 transition-all duration-300 ease-out pointer-events-none">
        <div class="bg-[#0F2D52] text-white px-5 py-3.5 rounded-xl shadow-2xl flex items-center gap-3 border border-[#1A3F6D]">
            <div class="bg-[#D4A017] p-1.5 rounded-lg text-[#0F2D52]">
                <x-heroicon-s-check class="w-4 h-4" />
            </div>
            <span class="text-sm font-sans font-bold tracking-wide">Tautan berhasil disalin ke papan klip!</span>
        </div>
    </div>

    {{-- Melebarkan layout utama untuk menampung Sidebar --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col lg:flex-row gap-10 lg:gap-14">

            {{-- ========================================== --}}
            {{-- KOLOM KIRI: KONTEN UTAMA (Lebar 65% di Desktop) --}}
            {{-- ========================================== --}}
            <main class="w-full lg:w-[65%]">

                {{-- Breadcrumbs Minimalis --}}
                <nav class="flex text-xs md:text-sm text-slate-500 mb-8 font-sans font-medium" aria-label="Breadcrumb">
                    <a href="{{ url('/') }}" class="hover:text-[#0F2D52] transition-colors">Beranda</a>
                    <span class="mx-2 text-slate-300">/</span>
                    <a href="{{ route('category.show', $article->category->slug) }}" class="text-[#D4A017] hover:underline uppercase tracking-wider font-bold">
                        {{ $article->category->name ?? 'Uncategorized' }}
                    </a>
                    <span class="mx-2 text-slate-300">/</span>
                    <span class="text-slate-800 truncate max-w-[150px] sm:max-w-xs">{{ $article->title }}</span>
                </nav>

                {{-- Header Artikel --}}
                <header class="mb-8">
                    <h1 class="text-3xl md:text-[2.75rem] font-heading font-extrabold text-[#0F2D52] leading-[1.2] mb-6 tracking-tight">
                        {{ $article->title }}
                    </h1>

                    {{-- Meta Data Penulis, Waktu, & Views --}}
                    <div class="flex flex-wrap items-center text-slate-500 text-sm gap-y-4 gap-x-6 font-sans py-4 border-b border-gray-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-[#0F2D52] text-[#D4A017] flex items-center justify-center font-bold text-lg shadow-sm">
                                {{ substr($article->reporter_name ?? $article->author->name ?? 'R', 0, 1) }}
                            </div>
                            <div>
                                {{-- LOGIKA DINAMIS: Cek apakah ada reporter lapangan khusus --}}
                                @if(!empty($article->reporter_name))
                                <p class="text-xs text-slate-400 mb-0.5 uppercase tracking-wider font-bold">Laporan Jurnalis</p>
                                <span class="font-bold text-slate-800">{{ $article->reporter_name }}</span>
                                @else
                                <p class="text-xs text-slate-400 mb-0.5 uppercase tracking-wider font-bold">Oleh</p>
                                <span class="font-bold text-slate-800">{{ $article->author->name ?? 'Redaksi NusaAksara' }}</span>
                                @endif
                            </div>
                        </div>

                        <span class="hidden md:inline-block text-gray-200 text-3xl font-light">|</span>

                        <div class="flex flex-col">
                            <p class="text-xs text-slate-400 mb-0.5 uppercase tracking-wider font-bold">Diterbitkan pada</p>
                            <span class="font-medium text-slate-700 flex items-center gap-1.5">
                                <x-heroicon-o-clock class="w-4 h-4 text-[#D4A017]" />
                                {{ $article->published_at ? $article->published_at->translatedFormat('l, d F Y - H:i') : $article->created_at->translatedFormat('l, d F Y - H:i') }} WITA
                            </span>
                        </div>

                        <span class="hidden md:inline-block text-gray-200 text-3xl font-light">|</span>

                        <div class="flex flex-col">
                            <p class="text-xs text-slate-400 mb-0.5 uppercase tracking-wider font-bold">Dilihat sebanyak</p>
                            <span class="font-bold text-slate-800 flex items-center gap-1.5">
                                <x-heroicon-o-eye class="w-4 h-4 text-[#D4A017]" />
                                {{ number_format($totalViews) }} Kali Dibaca
                            </span>
                        </div>
                    </div>
                </header>

                {{-- Gambar Cover Artikel --}}
                @if($article->hasMedia('cover'))
                <figure class="mb-8 group">
                    <div class="rounded-xl overflow-hidden shadow-sm border border-gray-100 bg-gray-50">
                        <img src="{{ $article->getFirstMediaUrl('cover') }}" alt="{{ $article->title }}" class="w-full h-auto object-cover max-h-[500px]">
                    </div>

                    {{-- Memanggil secara dinamis dengan fallback jika kosong --}}
                    <figcaption class="text-left text-slate-400 text-xs mt-3 font-sans border-l-2 border-[#D4A017] pl-3">
                        {{ $article->cover_caption ?? 'Ilustrasi: ' . $article->title }}
                        <span class="text-slate-300 mx-1.5">|</span>
                        Foto: {{ $article->cover_source ?? 'Dok. NusaAksara' }}
                    </figcaption>
                </figure>
                @endif


                {{-- Action Bar: Social Share --}}
                <div class="flex items-center justify-between py-4 border-y border-gray-100 mb-8">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-heading font-extrabold text-slate-400 uppercase tracking-widest hidden sm:block">Bagikan:</span>

                        {{-- Facebook Share --}}
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-[#F5F7FA] border border-gray-200 flex items-center justify-center text-slate-500 hover:bg-[#1877F2] hover:text-white hover:border-[#1877F2] hover:scale-105 transition-all" title="Bagikan ke Facebook">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                            </svg>
                        </a>

                        {{-- X / Twitter Share --}}
                        <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-[#F5F7FA] border border-gray-200 flex items-center justify-center text-slate-500 hover:bg-[#000000] hover:text-white hover:border-[#000000] hover:scale-105 transition-all" title="Bagikan ke X (Twitter)">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                            </svg>
                        </a>

                        {{-- WhatsApp Share --}}
                        <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="w-9 h-9 rounded-full bg-[#F5F7FA] border border-gray-200 flex items-center justify-center text-slate-500 hover:bg-[#25D366] hover:text-white hover:border-[#25D366] hover:scale-105 transition-all" title="Bagikan ke WhatsApp">
                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                        </a>

                        {{-- Copy Link Button (JS Integrasi Terjamin) --}}
                        <button onclick="copyCurrentUrl()" class="w-9 h-9 rounded-full bg-[#F5F7FA] border border-gray-200 flex items-center justify-center text-slate-500 hover:bg-[#D4A017] hover:text-white hover:border-[#D4A017] hover:scale-105 transition-all" title="Salin Tautan">
                            <x-heroicon-m-link class="w-4 h-4" />
                        </button>
                    </div>

                    <div class="flex items-center gap-2 text-slate-400">
                        <x-heroicon-m-home class="w-5 h-5 hidden sm:block" />
                    </div>
                </div>

                {{-- Isi Konten Utama --}}
                <article class="prose prose-lg md:prose-xl max-w-none mb-12 font-sans leading-relaxed text-slate-800 article-content">
                    {!! $article->content !!}
                </article>

                {{-- Bagian Tag --}}
                @if($article->tags->isNotEmpty())
                <div class="flex flex-wrap items-center gap-3 font-sans mb-10 border-b border-gray-100 pb-10">
                    <span class="text-sm font-heading font-extrabold text-[#0F2D52] uppercase tracking-widest mr-2">Topik:</span>
                    @foreach($article->tags as $tag)
                    <a href="#" class="bg-[#F5F7FA] text-slate-600 border border-slate-200 px-4 py-1.5 rounded-md text-sm hover:bg-[#0F2D52] hover:text-white hover:border-[#0F2D52] transition-colors font-medium">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                @endif

                {{-- Author Box (Kotak Penulis) - Versi Simpel, Elegan & Akurat --}}
                <div class="flex items-center justify-between py-5 border-y border-gray-100 mb-14 bg-gray-50/50 px-6 rounded-xl">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-full bg-[#0F2D52] text-white flex items-center justify-center text-lg font-heading font-bold shadow-sm shrink-0">
                            {{ substr($article->author->name ?? 'R', 0, 1) }}
                        </div>
                        <div>
                            {{-- Karena ini akun CMS yang memposting, kita beri label Editor/Penulis --}}
                            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-0.5">Editor / Penulis</p>
                            <h4 class="text-base font-extrabold text-[#0F2D52]">{{ $article->author->name ?? 'Redaksi NusaAksara' }}</h4>
                        </div>
                    </div>
                    <a href="{{ route('author.show', $article->author) }}" class="hidden sm:inline-flex items-center text-xs font-bold text-[#0F2D52] hover:text-[#D4A017] transition-colors uppercase tracking-wider">
                        Semua Artikel <x-heroicon-m-arrow-right class="w-3 h-3 ml-1" />
                    </a>
                </div>

                {{-- Comment Section --}}
                <section class="mb-14" id="komentar">
                    <div class="flex items-center justify-between mb-8 pb-4 border-b-2 border-gray-100">
                        <h3 class="text-2xl font-heading font-extrabold text-[#0F2D52] uppercase tracking-tight">Komentar Pembaca</h3>
                        <span class="bg-[#0F2D52] text-white px-3 py-1 rounded text-sm font-bold shadow-sm">0</span>
                    </div>

                    {{-- Form Komentar --}}
                    <div class="bg-white border border-slate-200 rounded-xl p-5 mb-8 shadow-sm">
                        <h4 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <x-heroicon-s-chat-bubble-left-ellipsis class="w-5 h-5 text-[#D4A017]" /> Tinggalkan Komentar Anda
                        </h4>
                        <textarea class="w-full bg-slate-50 border border-slate-200 rounded-lg p-4 text-sm focus:ring-2 focus:ring-[#0F2D52] focus:border-transparent transition-all outline-none resize-none" rows="3" placeholder="Tulis komentar yang relevan dan sopan..."></textarea>
                        <div class="mt-3 flex justify-between items-center">
                            <p class="text-[11px] text-slate-400 w-2/3">Komentar sepenuhnya menjadi tanggung jawab pembaca sesuai UU ITE.</p>
                            <button class="bg-[#0F2D52] text-white font-bold py-2.5 px-6 rounded-lg hover:bg-[#D4A017] transition-colors text-sm shadow-md">Kirim</button>
                        </div>
                    </div>

                    {{-- List Komentar (Kosong sebagai default desain) --}}
                    <div class="text-center py-10 bg-[#F5F7FA] rounded-xl border border-dashed border-slate-300">
                        <p class="text-slate-500 text-sm font-medium">Belum ada komentar. Jadilah yang pertama memberikan tanggapan!</p>
                    </div>
                </section>
            </main>

            {{-- ========================================== --}}
            {{-- KOLOM KANAN: STICKY SIDEBAR (Lebar 35% di Desktop) --}}
            {{-- ========================================== --}}
            <aside class="w-full lg:w-[35%]">
                <div class="sticky top-20 flex flex-col gap-8">

                    {{-- 1. Related News (Berita Terkait) --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)]">
                        <div class="flex items-center gap-2 mb-6 border-b-2 border-slate-100 pb-3">
                            <div class="w-2 h-6 bg-[#D4A017] rounded-sm"></div>
                            <h3 class="text-xl font-heading font-extrabold text-[#0F2D52] uppercase tracking-wider">Terkait</h3>
                        </div>

                        {{-- Mengambil 4 artikel dari kategori yang sama secara acak/terbaru --}}
                        @php
                        $relatedArticles = \App\Models\Article::where('category_id', $article->category_id)
                        ->where('id', '!=', $article->id)
                        ->where('status', 'published')
                        ->latest('published_at')
                        ->take(4)
                        ->get();
                        @endphp

                        <div class="flex flex-col gap-5">
                            @forelse($relatedArticles as $relArt)
                            <a href="{{ route('article.show', $relArt->slug) }}" class="group flex gap-4 items-start">
                                <div class="w-20 h-20 shrink-0 rounded-lg overflow-hidden bg-slate-100">
                                    @if($relArt->hasMedia('cover'))
                                    <img src="{{ $relArt->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <h4 class="text-sm font-bold text-slate-800 leading-snug group-hover:text-[#D4A017] transition-colors line-clamp-3">
                                        {{ $relArt->title }}
                                    </h4>
                                    <span class="text-[11px] text-slate-400 mt-1.5 font-medium">{{ $relArt->published_at ? $relArt->published_at->diffForHumans() : '' }}</span>
                                </div>
                            </a>
                            @empty
                            <p class="text-sm text-slate-500">Belum ada berita terkait.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- 2. Banner Iklan Sidebar --}}
                    @if($monetizationSettings->sidebar_ad_code)
                    <div class="w-full overflow-hidden rounded-xl shadow-sm">
                        {!! $monetizationSettings->sidebar_ad_code !!}
                    </div>
                    @else
                    {{-- Placeholder jika admin belum memasukkan iklan --}}
                    <div class="w-full h-[250px] bg-slate-50 border border-slate-200 rounded-xl flex flex-col items-center justify-center text-slate-400 font-medium text-sm shadow-inner relative overflow-hidden group">
                        <span class="absolute top-2 right-2 bg-black/20 text-white text-[10px] px-1.5 py-0.5 rounded uppercase tracking-widest z-10">Ad</span>
                        <x-heroicon-o-megaphone class="w-8 h-8 mb-2 opacity-50 group-hover:scale-110 transition-transform" />
                        Ruang Iklan Sidebar
                        <span class="text-xs mt-1 opacity-70">(300 x 250 px)</span>
                    </div>
                    @endif

                    {{-- 3. Newsletter Mini --}}
                    <div class="bg-[#0F2D52] rounded-2xl p-6 text-white text-center shadow-lg relative overflow-hidden">
                        {{-- Efek cahaya/dekorasi SVG di background --}}
                        <svg class="absolute top-0 right-0 opacity-10" width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="80" cy="20" r="60" fill="white" />
                        </svg>

                        <x-heroicon-s-envelope-open class="w-10 h-10 text-[#D4A017] mx-auto mb-3 relative z-10" />
                        <h3 class="text-lg font-heading font-extrabold mb-2 relative z-10">Berlangganan Gratis</h3>
                        <p class="text-xs text-slate-300 mb-4 relative z-10 leading-relaxed">Dapatkan ringkasan berita pilihan mingguan langsung ke email Anda.</p>
                        <input type="email" placeholder="Email Anda..." class="w-full bg-white/10 border border-white/20 rounded-lg px-4 py-2 text-sm text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#D4A017] mb-3 relative z-10">
                        <button class="w-full bg-[#D4A017] text-[#0F2D52] font-bold uppercase tracking-widest text-xs py-2.5 rounded-lg hover:bg-white transition-colors relative z-10 shadow-md">Daftar</button>
                    </div>

                </div>
            </aside>

        </div>
    </div>

    {{-- Script untuk Fungsionalitas Salin Tautan & Toast --}}
    <script>
        function copyCurrentUrl() {
            // Mengambil URL saat ini
            const currentUrl = window.location.href;

            // Membuat elemen input tersembunyi
            const tempInput = document.createElement('input');
            tempInput.setAttribute('value', currentUrl);
            document.body.appendChild(tempInput);

            // Pilih teks di dalam input
            tempInput.select();
            tempInput.setSelectionRange(0, 99999); // Untuk perangkat seluler

            try {
                // Melakukan copy dengan execCommand agar aman dalam iframe
                document.execCommand('copy');

                // Menampilkan Toast Notifikasi
                const toast = document.getElementById('toast-copy');
                toast.classList.remove('translate-y-20', 'opacity-0');
                toast.classList.add('translate-y-0', 'opacity-100');

                // Sembunyikan toast kembali setelah 3 detik
                setTimeout(() => {
                    toast.classList.remove('translate-y-0', 'opacity-100');
                    toast.classList.add('translate-y-20', 'opacity-0');
                }, 3000);
            } catch (err) {
                console.error('Gagal menyalin tautan: ', err);
            } finally {
                // Hapus elemen sementara dari DOM
                document.body.removeChild(tempInput);
            }
        }
    </script>

    {{-- Custom CSS Khusus Halaman Ini --}}
    <style>
        /* Prose Styles untuk Teks Artikel */
        .article-content {
            color: #1e293b;
            /* Slate 800 */
        }

        /* Links in content */
        .article-content a {
            color: #0F2D52;
            text-decoration-line: underline;
            text-decoration-color: #D4A017;
            text-decoration-thickness: 2px;
            text-underline-offset: 4px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .article-content a:hover {
            background-color: #0F2D52;
            color: white;
            text-decoration-color: transparent;
        }

        /* Drop Cap Effect Klasik */
        .article-content>p:first-of-type::first-letter {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 4.5rem;
            font-weight: 800;
            float: left;
            line-height: 0.85;
            margin-right: 0.75rem;
            margin-top: 0.35rem;
            color: #0F2D52;
            text-shadow: 2px 2px 0px rgba(212, 160, 23, 0.2);
            /* Sentuhan shadow Emas */
        }

        /* Images in content */
        .article-content img {
            border-radius: 0.75rem;
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
        }

        /* Blockquotes */
        .article-content blockquote {
            border-left-color: #D4A017;
            border-left-width: 4px;
            background-color: #F5F7FA;
            padding: 1rem 1.5rem;
            border-radius: 0 0.5rem 0.5rem 0;
            font-style: italic;
            color: #0F2D52;
            font-weight: 500;
        }
    </style>
</x-layouts.app>