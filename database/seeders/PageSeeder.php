<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Site;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kita menautkannya ke website utama yang sudah ada
        $site = Site::firstOrCreate(
            ['domain' => 'nusaaksara.com'],
            ['name' => 'NusaAksara Pusat', 'is_active' => true]
        );

        $pages = [
            [
                'title' => 'Tentang Kami',
                'slug' => 'tentang-kami',
                'content' => '
                    <p><strong>NusaAksara CMS</strong> lahir dari semangat untuk memberikan informasi yang faktual, independen, dan terpercaya bagi seluruh masyarakat Indonesia. Kami hadir sebagai pilar ke-4 demokrasi yang menjunjung tinggi etika jurnalistik.</p>
                    <p>Visi kami adalah menjadi portal berita rujukan utama yang mencerahkan bangsa melalui karya jurnalistik berkualitas, tajam, dan berimbang.</p>
                    <h3>Misi Kami</h3>
                    <ul>
                        <li>Menyajikan berita secara <em>real-time</em> dengan tingkat akurasi tinggi.</li>
                        <li>Menjadi wadah aspirasi publik.</li>
                        <li>Mengembangkan jurnalisme yang berpusat pada data (<em>data-driven journalism</em>).</li>
                    </ul>
                ',
            ],
            [
                'title' => 'Susunan Redaksi',
                'slug' => 'susunan-redaksi',
                'content' => '
                    <p>Berita yang akurat bermula dari tim yang kuat. Berikut adalah susunan dewan redaksi NusaAksara CMS:</p>
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <td class="font-bold border-b py-2">Pemimpin Umum / Redaksi</td>
                                <td class="border-b py-2">Budi Santoso</td>
                            </tr>
                            <tr>
                                <td class="font-bold border-b py-2">Redaktur Pelaksana</td>
                                <td class="border-b py-2">Ahmad Hidayat</td>
                            </tr>
                            <tr>
                                <td class="font-bold border-b py-2">Editor Senior</td>
                                <td class="border-b py-2">Siti Aminah, Reza Rahadian</td>
                            </tr>
                            <tr>
                                <td class="font-bold border-b py-2">IT & Web Development</td>
                                <td class="border-b py-2">Tim NusaAksara Tech</td>
                            </tr>
                        </tbody>
                    </table>
                ',
            ],
            [
                'title' => 'Pedoman Media Siber',
                'slug' => 'pedoman-media-siber',
                'content' => '
                    <p>Kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers adalah hak asasi manusia yang dilindungi Pancasila, Undang-Undang Dasar 1945, dan Deklarasi Universal Hak Asasi Manusia PBB. Keberadaan media siber di Indonesia juga merupakan bagian dari kemerdekaan berpendapat, kemerdekaan berekspresi, dan kemerdekaan pers.</p>
                    <p>Media siber memiliki karakter khusus sehingga memerlukan pedoman agar pengelolaannya dapat dilaksanakan secara profesional, memenuhi fungsi, hak, dan kewajibannya sesuai Undang-Undang Nomor 40 Tahun 1999 tentang Pers dan Kode Etik Jurnalistik.</p>
                    <p><strong>NusaAksara CMS</strong> tunduk pada peraturan Dewan Pers dan Pedoman Pemberitaan Media Siber di Indonesia.</p>
                ',
            ],
            [
                'title' => 'Disclaimer',
                'slug' => 'disclaimer',
                'content' => '
                    <p>Semua informasi yang disediakan di situs ini bertujuan untuk keperluan informasi semata. <strong>NusaAksara CMS</strong> berusaha senantiasa menyajikan informasi seakurat mungkin, namun kami tidak bertanggung jawab atas segala kesalahan dan keterlambatan dalam memperbarui data atau informasi, atau segala kerugian yang timbul karena tindakan yang berkaitan dengan penggunaan informasi yang disajikan/ditampilkan di situs ini.</p>
                    <p>Komentar sepenuhnya menjadi tanggung jawab pembaca sebagaimana diatur dalam Undang-Undang Informasi dan Transaksi Elektronik (UU ITE).</p>
                ',
            ],
        ];

        foreach ($pages as $page) {
            Page::firstOrCreate(
                ['slug' => $page['slug'], 'site_id' => $site->id],
                [
                    'title' => $page['title'],
                    'content' => $page['content'],
                    'layout' => 'default', // Pastikan menggunakan layout default (teks statis)
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('Halaman Statis (Tentang Kami, Redaksi, dll) berhasil dibuat!');
    }
}