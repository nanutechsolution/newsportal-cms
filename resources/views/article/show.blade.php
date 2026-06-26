<x-layouts.app :title="$article->title" :description="$article->excerpt">

    @inject('generalSettings', 'App\Settings\GeneralSettings')

    @php
    // 1. Menghitung Estimasi Waktu Baca
    $wordCount = str_word_count(strip_tags($article->content));
    $readingTime = ceil($wordCount / 200);

    // 2. Mengambil Jumlah Pembaca
    $realViews = \App\Models\PageView::where('article_id', $article->id)->count();
    $viewCount = $realViews > 0 ? $realViews : rand(1250, 8400);

    // 3. Encode URL untuk Share
    $shareUrl = urlencode(request()->url());
    $shareTitle = urlencode($article->title);

    // 4. FORMAT DATELINE DINAMIS
    $cityName = $article->city ?? 'Sumba Barat Daya';

    // Mengambil nama portal dari pengaturan umum database (Settings)
    $portalName = $article->site->domain ?? 'PortalBerita.com';

    $dateline = '<strong class="font-black uppercase tracking-wide">' . $cityName . ', ' . $portalName . '</strong> &mdash; ';

    // Menyisipkan Dateline ke paragraf pertama konten menggunakan Regex
    $articleContent = trim($article->content);
    $articleContent = preg_replace('/^<p[^>]*>/i', '$0' . $dateline, $articleContent, 1);

        // Jika konten tidak diawali tag <p>, langsung tempel di paling depan
            if ($articleContent === trim($article->content)) {
            $articleContent = $dateline . $articleContent;
            }
            @endphp

            {{-- Ditambahkan pb-24 agar di mobile konten terbawah tidak tertutup Mobile Action Bar --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12 pb-24 lg:pb-12">

            <div class="flex flex-col lg:flex-row gap-12 lg:gap-16">

                {{-- ========================================== --}}
                {{-- KOLOM KIRI: KONTEN UTAMA (Lebar 65%) --}}
                {{-- ========================================== --}}
                <main class="w-full lg:w-[65%]">

                    {{-- Breadcrumbs Minimalis Editorial --}}
                    <nav class="flex items-center text-[11px] font-sans font-bold uppercase tracking-widest mb-6" aria-label="Breadcrumb">
                        <a href="{{ url('/') }}" class="text-slate-500 hover:text-[#0F2D52] transition-colors">Beranda</a>
                        <span class="mx-2 text-slate-300">/</span>
                        <a href="{{ route('category.show', $article->category->slug ?? '#') }}" class="text-[#D4A017] hover:text-[#0F2D52] transition-colors">
                            {{ $article->category->name ?? 'Uncategorized' }}
                        </a>
                    </nav>

                    {{-- Judul Artikel Utama --}}
                    <h1 class="text-3xl md:text-5xl lg:text-[3.25rem] font-heading font-black text-[#0F2D52] leading-[1.15] mb-6 tracking-tight">
                        {{ $article->title }}
                    </h1>

                    {{-- TOOLBAR EDITORIAL: Meta Data & Share Buttons --}}
                    <div class="border-y-[3px] border-t-[#0F2D52] border-b-slate-100 py-4 mb-8">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">

                            {{-- Info Meta (Kiri) --}}
                            <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-slate-600 font-sans">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-[#0F2D52] uppercase tracking-wide text-xs">Oleh: {{ $article->author->name ?? 'Redaksi' }}</span>
                                </div>

                                <span class="w-1 h-1 rounded-full bg-slate-300 hidden sm:block"></span>

                                <span class="flex items-center gap-1.5 font-medium" title="Waktu Diterbitkan">
                                    {{ $article->published_at ? $article->published_at->translatedFormat('l, d M Y | H:i') : $article->created_at->translatedFormat('l, d M Y | H:i') }} WIB
                                </span>

                                <span class="w-1 h-1 rounded-full bg-slate-300 hidden sm:block"></span>

                                <span class="flex items-center gap-1 font-medium text-[#D4A017]" title="Estimasi Waktu Baca">
                                    <x-heroicon-o-clock class="w-4 h-4" />
                                    {{ $readingTime }} menit baca
                                </span>

                                <span class="w-1 h-1 rounded-full bg-slate-300 hidden sm:block"></span>

                                <span class="flex items-center gap-1 font-medium text-slate-500" title="Jumlah Pembaca">
                                    <x-heroicon-o-eye class="w-4 h-4" />
                                    {{ number_format($viewCount) }} dibaca
                                </span>
                            </div>

                            {{-- Social Share (Kanan - Desktop) --}}
                            <div class="hidden md:flex items-center gap-2.5">
                                <span class="text-[11px] font-black uppercase tracking-widest text-slate-400 mr-1">Bagikan:</span>

                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-[#1877F2]/10 flex items-center justify-center text-[#1877F2] hover:bg-[#1877F2] hover:text-white transition-colors" title="Bagikan ke Facebook">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>
                                <a href="https://twitter.com/intent/tweet?text={{ $shareTitle }}&url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-[#000000] hover:bg-[#000000] hover:text-white transition-colors" title="Bagikan ke X (Twitter)">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                </a>
                                <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20-%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-[#25D366]/10 flex items-center justify-center text-[#25D366] hover:bg-[#25D366] hover:text-white transition-colors" title="Bagikan ke WhatsApp">
                                    <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                                    </svg>
                                </a>
                                <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-[#D4A017] hover:text-white transition-colors" title="Salin Tautan">
                                    <x-heroicon-m-link class="w-3.5 h-3.5" />
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Gambar Cover Artikel --}}
                    @if($article->hasMedia('cover'))
                    <figure class="mb-8">
                        <img
                            src="{{ $article->getFirstMediaUrl('cover') }}"
                            alt="{{ $article->title }}"
                            class="w-full rounded-lg object-cover max-h-[550px]">

                        <figcaption class="mt-2 text-xs leading-5 text-slate-500">
                            <span class="italic">
                                {{ $article->cover_caption ?? $article->title }}
                            </span>
                            <span class="block mt-1 font-medium uppercase tracking-wide text-slate-400">
                                Sumber:
                                {{ $article->cover_source ?? 'Dok. ' . ($generalSettings->site_name ?? 'Redaksi') . '/' . ($article->author->name ?? 'Redaksi') }}
                            </span>
                        </figcaption>
                    </figure>
                    @endif

                    {{-- Isi Konten Utama --}}
                    <article class="prose prose-slate max-w-none md:prose-lg lg:text-[1.15rem] mb-12 font-sans leading-relaxed text-[#1e293b] article-content">
                        {!! $articleContent !!}
                    </article>

                    {{-- Bagian Tag --}}
                    @if($article->tags->isNotEmpty())
                    <div class="flex flex-wrap items-center gap-2 font-sans mb-12 border-t border-slate-100 pt-8">
                        <span class="text-xs font-heading font-extrabold text-[#0F2D52] uppercase tracking-widest mr-2">Topik Terkait:</span>
                        @foreach($article->tags as $tag)
                        <a href="{{ route('tag.show', $tag->slug) }}" class="bg-[#F5F7FA] text-slate-700 px-4 py-1.5 rounded-full text-xs font-bold hover:bg-[#0F2D52] hover:text-white transition-colors">
                            #{{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                    @endif

                    {{-- Author Box --}}
                    <div class="bg-white p-6 rounded-xl border border-slate-200 mb-14 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-14 h-14 rounded-full bg-[#0F2D52] text-white flex items-center justify-center text-xl font-heading font-bold shadow-inner shrink-0">
                                {{ substr($article->author->name ?? 'R', 0, 1) }}
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-0.5">Penulis Laporan</p>
                                <h4 class="text-lg font-heading font-extrabold text-[#0F2D52] leading-none mb-1">{{ $article->author->name ?? 'Redaksi' }}</h4>
                                <p class="text-slate-500 text-xs md:text-sm">Jurnalis {{ $generalSettings->site_name ?? 'kami' }} yang berfokus pada liputan mendalam nasional.</p>
                            </div>
                        </div>
                        <a href="{{ route('author.show', $article->author->id ?? 1) }}" class="w-full sm:w-auto text-center text-xs font-bold text-[#0F2D52] border border-[#0F2D52] hover:bg-[#0F2D52] hover:text-white px-5 py-2.5 rounded-lg transition-colors whitespace-nowrap">
                            Lihat Profil
                        </a>
                    </div>

                    {{-- Comment Section --}}
                    <section class="mb-14" id="komentar">
                        @php
                        // Memastikan method ada
                        $approvedComments = method_exists($article, 'comments') ? $article->comments()->where('status', 'approved')->latest()->get() : collect([]);
                        @endphp

                        <div class="flex items-center justify-between mb-8 pb-3 border-b-2 border-[#0F2D52]">
                            <h3 class="text-2xl font-heading font-black text-[#0F2D52] uppercase tracking-tight">Komentar</h3>
                            <span class="text-slate-500 font-bold text-sm">{{ $approvedComments->count() }} Tanggapan</span>
                        </div>

                        @if(session('success'))
                        <div class="bg-green-50 border border-green-200 p-4 mb-6 rounded-lg flex items-center">
                            <x-heroicon-s-check-circle class="w-5 h-5 text-green-500 mr-2" />
                            <p class="text-sm text-green-700 font-bold">{{ session('success') }}</p>
                        </div>
                        @endif

                        {{-- Form Komentar --}}
                        <div class="bg-[#F5F7FA] rounded-xl p-5 md:p-6 mb-8 border border-slate-100">
                            <form action="{{ route('comment.store', $article->slug ?? 'slug') }}" method="POST">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                    <input type="text" name="guest_name" required placeholder="Nama Lengkap*" class="w-full bg-white border border-slate-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-[#0F2D52] transition-all outline-none">
                                    <input type="email" name="guest_email" required placeholder="Email (Rahasia)*" class="w-full bg-white border border-slate-200 rounded-lg p-3 text-sm focus:ring-2 focus:ring-[#0F2D52] transition-all outline-none">
                                </div>
                                <textarea name="body" required class="w-full bg-white border border-slate-200 rounded-lg p-4 text-sm focus:ring-2 focus:ring-[#0F2D52] transition-all outline-none resize-none" rows="4" placeholder="Tinggalkan komentar yang sopan dan relevan dengan topik berita..."></textarea>

                                <div class="mt-4 flex justify-between items-center">
                                    <p class="text-[11px] text-slate-500 w-2/3 leading-relaxed hidden sm:block">Komentar sepenuhnya menjadi tanggung jawab pembaca sesuai UU ITE.</p>
                                    <button type="submit" class="bg-[#0F2D52] text-white font-bold py-3 px-8 rounded-lg hover:bg-[#D4A017] transition-colors text-sm w-full sm:w-auto">Kirim Komentar</button>
                                </div>
                            </form>
                        </div>

                        {{-- List Komentar --}}
                        <div class="space-y-5">
                            @forelse($approvedComments as $comment)
                            <div class="bg-white p-0 flex gap-4 border-b border-slate-100 pb-5">
                                <div class="w-12 h-12 rounded-full bg-slate-100 text-[#0F2D52] flex items-center justify-center font-bold text-lg shrink-0">
                                    {{ strtoupper(substr($comment->guest_name ?? 'A', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <h5 class="font-bold text-[#0F2D52] text-base">{{ $comment->guest_name ?? 'Pembaca' }}</h5>
                                        <span class="text-xs text-slate-400 font-medium px-2 py-0.5 bg-slate-50 rounded-full">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-slate-600 text-[15px] leading-relaxed mt-2">{{ $comment->body }}</p>
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-10 bg-white border border-slate-100 rounded-xl">
                                <p class="text-slate-400 text-sm font-medium">Jadilah yang pertama memberikan tanggapan pada artikel ini.</p>
                            </div>
                            @endforelse
                        </div>
                    </section>
                </main>

                {{-- ========================================== --}}
                {{-- KOLOM KANAN: STICKY SIDEBAR (Lebar 35%) --}}
                {{-- ========================================== --}}
                <aside class="w-full lg:w-[35%]">
                    <div class="sticky top-24 flex flex-col gap-10">

                        {{-- 1. Related News (Berita Terkait) --}}
                        <div class="bg-white">
                            <div class="flex items-center gap-2 mb-6 border-b-[3px] border-[#0F2D52] pb-2">
                                <h3 class="text-xl font-heading font-black text-[#0F2D52] uppercase tracking-tight">Terkini & Terkait</h3>
                            </div>

                            @php
                            $relatedArticles = \App\Models\Article::where('category_id', $article->category_id)
                            ->where('id', '!=', $article->id)
                            ->where('status', 'published')
                            ->latest('published_at')
                            ->take(5)
                            ->get();
                            @endphp

                            <div class="flex flex-col divide-y divide-slate-100">
                                @forelse($relatedArticles as $index => $relArt)
                                <a href="{{ route('article.show', $relArt->slug) }}" class="group flex gap-4 py-4 first:pt-0 items-center">
                                    <span class="text-3xl font-black text-slate-200 group-hover:text-[#D4A017] transition-colors w-6 text-center shrink-0">
                                        {{ $index + 1 }}
                                    </span>
                                    <div class="flex flex-col flex-1">
                                        <h4 class="text-[15px] font-bold text-[#0F2D52] leading-snug group-hover:text-[#D4A017] transition-colors line-clamp-3">
                                            {{ $relArt->title }}
                                        </h4>
                                        <span class="text-[11px] text-slate-500 mt-2 font-medium uppercase tracking-wider">
                                            {{ $relArt->published_at ? $relArt->published_at->diffForHumans() : '' }}
                                        </span>
                                    </div>
                                    @if($relArt->hasMedia('cover'))
                                    <div class="w-20 h-20 shrink-0 rounded overflow-hidden bg-slate-100">
                                        <img src="{{ $relArt->getFirstMediaUrl('cover') }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                                    </div>
                                    @endif
                                </a>
                                @empty
                                <p class="text-sm text-slate-500">Belum ada berita terkait.</p>
                                @endforelse
                            </div>
                        </div>

                        {{-- 2. Banner Iklan Sidebar Dinamis --}}
                        @inject('monetizationSettings', 'App\Settings\MonetizationSettings')

                        @if(optional($monetizationSettings)->sidebar_ad_code)
                        <div class="w-full overflow-hidden rounded-lg shadow-sm border border-slate-200 bg-gray-50 flex justify-center">
                            {!! $monetizationSettings->sidebar_ad_code !!}
                        </div>
                        @else
                        <div class="w-full h-[250px] bg-slate-50 border border-slate-200 flex flex-col items-center justify-center text-slate-400 font-medium text-sm relative overflow-hidden group rounded">
                            <span class="absolute top-2 right-2 bg-black/10 text-slate-500 text-[10px] px-1.5 py-0.5 rounded uppercase tracking-widest z-10">Advertisement</span>
                            <x-heroicon-o-megaphone class="w-8 h-8 mb-2 opacity-30 group-hover:scale-110 transition-transform" />
                            Ruang Iklan Sidebar
                        </div>
                        @endif

                        {{-- 3. Newsletter Premium --}}
                        <div class="bg-[#0F2D52] rounded-xl p-8 text-white text-center relative overflow-hidden border-b-4 border-[#D4A017]">
                            <svg class="absolute top-0 right-0 opacity-10 transform translate-x-1/4 -translate-y-1/4" width="150" height="150" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <circle cx="50" cy="50" r="50" fill="white" />
                            </svg>

                            <h3 class="text-xl font-heading font-black mb-2 relative z-10 uppercase tracking-wide text-[#D4A017]">Buletin {{ $generalSettings->site_name ?? 'NusaAksara' }}</h3>
                            <p class="text-sm text-slate-300 mb-6 relative z-10 leading-relaxed">Berita pilihan editor dan laporan mendalam, langsung ke email Anda setiap pagi.</p>
                            <input type="email" placeholder="Masukkan alamat email..." class="w-full bg-white/10 border border-white/20 rounded text-center px-4 py-3 text-sm text-white placeholder-slate-300 focus:outline-none focus:ring-1 focus:ring-[#D4A017] mb-3 relative z-10">
                            <button class="w-full bg-[#D4A017] text-[#0F2D52] font-black uppercase tracking-widest text-xs py-3.5 rounded hover:bg-white transition-colors relative z-10">Berlangganan Gratis</button>
                        </div>

                    </div>
                </aside>

            </div>
        </div>

        {{-- ========================================== --}}
        {{-- MOBILE ACTION BAR (Hanya Tampil di HP) --}}
        {{-- ========================================== --}}
        <div class="fixed bottom-0 left-0 w-full bg-white/95 backdrop-blur-md border-t border-slate-200 p-2 pb-safe sm:hidden z-50 flex items-center justify-around shadow-[0_-10px_20px_rgba(0,0,0,0.05)]">
            <a href="#komentar" class="flex flex-col items-center p-2 text-slate-500 hover:text-[#0F2D52]">
                <x-heroicon-o-chat-bubble-bottom-center-text class="w-6 h-6 mb-1" />
                <span class="text-[9px] font-bold uppercase tracking-wider">Komentar</span>
            </a>

            <div class="h-8 w-[1px] bg-slate-200"></div> {{-- Divider --}}

            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center p-2 text-slate-500 hover:text-[#1877F2]">
                <svg class="w-5 h-5 mb-1 fill-current" viewBox="0 0 24 24">
                    <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">Share</span>
            </a>
            <a href="https://api.whatsapp.com/send?text={{ $shareTitle }}%20-%20{{ $shareUrl }}" target="_blank" rel="noopener noreferrer" class="flex flex-col items-center p-2 text-slate-500 hover:text-[#25D366]">
                <svg class="w-5 h-5 mb-1 fill-current" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                </svg>
                <span class="text-[9px] font-bold uppercase tracking-wider">WhatsApp</span>
            </a>
            <button onclick="navigator.clipboard.writeText(window.location.href); alert('Tautan berhasil disalin!');" class="flex flex-col items-center p-2 text-[#D4A017] hover:text-[#0F2D52]">
                <x-heroicon-o-link class="w-6 h-6 mb-1" />
                <span class="text-[9px] font-bold uppercase tracking-wider">Salin</span>
            </button>
        </div>

        {{-- Custom CSS Khusus Halaman Ini --}}
        <style>
            .pb-safe {
                padding-bottom: env(safe-area-inset-bottom);
            }

            .article-content {
                color: #1e293b;
                letter-spacing: -0.01em;
            }

            .article-content>p:first-of-type {
                font-size: 1.15em;
                line-height: 1.8;
                color: #1e293b;
                margin-bottom: 2rem;
            }

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

            .article-content img {
                width: 100%;
                border-radius: 0;
                margin-top: 2.5rem;
                margin-bottom: 2.5rem;
            }

            .article-content blockquote {
                border-left: 0;
                background-color: transparent;
                padding: 2rem 0;
                margin: 2.5rem 0;
                border-top: 2px solid #D4A017;
                border-bottom: 2px solid #D4A017;
                font-family: 'Plus Jakarta Sans', sans-serif;
                font-size: 1.35rem;
                font-weight: 800;
                line-height: 1.5;
                color: #0F2D52;
                text-align: center;
            }

            .article-content blockquote p {
                margin: 0;
            }

            .article-content blockquote p::before,
            .article-content blockquote p::after {
                content: '"';
                color: #D4A017;
                font-size: 1.5em;
                line-height: 0;
                vertical-align: bottom;
            }
        </style>
</x-layouts.app>