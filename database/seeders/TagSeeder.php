<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Tag;
use App\Models\Site;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $siteId = Site::first()?->id;

        $tags = [

            // Politik
            'Presiden',
            'Wakil Presiden',
            'Kabinet',
            'DPR RI',
            'DPD RI',
            'MPR RI',
            'Pemilu',
            'Pilkada',
            'Partai Politik',
            'KPU',
            'Bawaslu',

            // Hukum
            'Mahkamah Agung',
            'Mahkamah Konstitusi',
            'Kejaksaan',
            'Polri',
            'KPK',
            'Korupsi',
            'Penyidikan',
            'Persidangan',
            'Kriminal',
            'Hukum',

            // Ekonomi
            'Ekonomi',
            'Investasi',
            'UMKM',
            'Perbankan',
            'Pasar Modal',
            'Saham',
            'IHSG',
            'Inflasi',
            'Pajak',
            'Keuangan',

            // Pendidikan
            'Pendidikan',
            'Sekolah',
            'Universitas',
            'Mahasiswa',
            'Guru',
            'Beasiswa',
            'Kampus',
            'Kurikulum',
            'Literasi',
            'Merdeka Belajar',

            // Kesehatan
            'Kesehatan',
            'Rumah Sakit',
            'Dokter',
            'BPJS',
            'Vaksin',
            'Gizi',
            'Kesehatan Mental',
            'Penyakit Menular',
            'COVID-19',
            'Layanan Kesehatan',

            // Teknologi
            'Teknologi',
            'Artificial Intelligence',
            'AI',
            'Startup',
            'Cyber Security',
            'Internet',
            'Aplikasi',
            'Digitalisasi',
            'Data Center',
            'Cloud Computing',

            // Bisnis
            'Bisnis',
            'Industri',
            'Perdagangan',
            'Ekspor',
            'Impor',
            'BUMN',
            'Energi',
            'Pertambangan',
            'Manufaktur',
            'Properti',

            // Nasional
            'Nasional',
            'Pemerintah',
            'Kementerian',
            'ASN',
            'Pelayanan Publik',
            'Infrastruktur',
            'Transportasi',
            'Pembangunan',
            'Desa',
            'Daerah',

            // Sosial
            'Masyarakat',
            'Kemiskinan',
            'Bantuan Sosial',
            'Disabilitas',
            'Perempuan',
            'Anak',
            'Pemuda',
            'Komunitas',
            'Budaya',
            'Sosial',

            // Lingkungan
            'Lingkungan',
            'Perubahan Iklim',
            'Banjir',
            'Longsor',
            'Gempa Bumi',
            'Kebakaran Hutan',
            'Cuaca Ekstrem',
            'Konservasi',
            'Energi Terbarukan',
            'Sampah',

            // Olahraga
            'Sepak Bola',
            'Liga 1',
            'Timnas Indonesia',
            'PSSI',
            'Bulutangkis',
            'Basket',
            'Voli',
            'MotoGP',
            'Formula 1',
            'Olimpiade',

            // Internasional
            'Internasional',
            'ASEAN',
            'Amerika Serikat',
            'China',
            'Jepang',
            'Eropa',
            'Timur Tengah',
            'PBB',
            'Diplomasi',
            'Geopolitik',

            // Lifestyle
            'Gaya Hidup',
            'Kuliner',
            'Pariwisata',
            'Fashion',
            'Kecantikan',
            'Kesehatan Keluarga',
            'Travel',
            'Hobi',
            'Inspirasi',
            'Komunitas',

            // Hiburan
            'Hiburan',
            'Film',
            'Musik',
            'Selebriti',
            'Artis',
            'Konser',
            'Serial TV',
            'Festival',
            'Konten Kreator',
            'Media Sosial',
        ];

        foreach ($tags as $tag) {
            Tag::firstOrCreate(
                [
                    'slug' => Str::slug($tag),
                ],
                [
                    'site_id' => $siteId,
                    'name' => $tag,
                ]
            );
        }
    }
}
