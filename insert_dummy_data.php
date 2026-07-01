<?php
use Illuminate\Support\Str;
use Carbon\Carbon;

\Illuminate\Database\Eloquent\Model::unguard();

$dummyDriveId = '1Cur2mISU8cwkWcyBuiwv9aGYNTxsZMPo';

// 1. Jumbotron
\App\Models\Jumbotron::truncate();
\App\Models\Jumbotron::create([
    'title' => 'Selamat Datang di LDK Syahid',
    'subtitle' => 'Mari Bertumbuh Bersama dalam Kebaikan',
    'sentence' => 'Lembaga Dakwah Kampus UIN Syarif Hidayatullah Jakarta siap menebar manfaat bagi semua.',
    'btnname' => 'Bergabung Sekarang',
    'btnlink' => '/register',
    'textalign' => 'center',
    'picture' => 'dummy.jpg',
    'gdrive_id' => $dummyDriveId
]);

// 2. Articles
\App\Models\Article::truncate();
for($i=1; $i<=3; $i++) {
    \App\Models\Article::create([
        'title' => 'Artikel Menarik ' . $i,
        'slug' => Str::slug('Artikel Menarik ' . $i),
        'theme' => 'Dakwah & Inspirasi',
        'dateevent' => Carbon::now()->subDays($i)->format('Y-m-d'),
        'writer' => 'Tim Media',
        'editor' => 'Admin',
        'poster' => 'dummy.jpg',
        'embedpdf' => 'dummy.pdf',
        'gdrive_id' => $dummyDriveId
    ]);
}

// 3. News
\App\Models\News::truncate();
for($i=1; $i<=4; $i++) {
    \App\Models\News::create([
        'title' => 'Berita Terkini LDK ' . $i,
        'slug' => Str::slug('Berita Terkini LDK ' . $i),
        'datepublish' => Carbon::now()->subDays($i)->format('Y-m-d'),
        'publisher' => 'Humas LDK',
        'reporter' => 'Divisi Syiar',
        'editor' => 'Admin',
        'picture' => 'dummy.jpg',
        'descpicture' => 'Gambar dummy',
        'body' => 'Ini adalah liputan kegiatan dakwah terbaru di lingkungan UIN Syarif Hidayatullah Jakarta.',
        'gdrive_id' => $dummyDriveId
    ]);
}

// 4. Events
\App\Models\Event::truncate();
for($i=1; $i<=4; $i++) {
    \App\Models\Event::create([
        'title' => 'Kegiatan Besar LDK ' . $i,
        'slug' => Str::slug('Kegiatan Besar LDK ' . $i),
        'dateevent' => Carbon::now()->addDays($i)->format('Y-m-d'),
        'start' => Carbon::now()->addDays($i)->format('Y-m-d H:i:s'),
        'finished' => Carbon::now()->addDays($i)->addHours(4)->format('Y-m-d H:i:s'),
        'poster' => 'dummy.jpg',
        'broadcast' => 'dummy',
        'linkembedgform' => 'dummy',
        'tag' => 'dummy',
        'closeRegist' => Carbon::now()->addDays($i+1)->format('Y-m-d'),
        'linkRegist' => 'dummy',
        'location' => 'dummy',
        'linkLocation' => 'dummy',
        'place' => 'dummy',
        'linkDoc' => 'dummy',
        'linkPresent' => 'dummy',
        'cntctPrsn1' => 'dummy',
        'cntctPrsn2' => 'dummy',
        'nameCntctPrsn1' => 'dummy',
        'nameCntctPrsn2' => 'dummy',
        'division' => 'dummy',
        'gdrive_id' => $dummyDriveId
    ]);
}

// 5. Gallery
\App\Models\Gallery::truncate();
\App\Models\Gallery::create([
    'eventName' => 'Gema Tarbiyah 2026',
    'eventTheme' => 'Menyemai Kebaikan',
    'eventDescription' => 'Dokumentasi kegiatan Gema Tarbiyah di UIN Jakarta.',
    'linkEmbedYoutube' => 'https://www.youtube.com/watch?v=123456',
    'groupPhoto' => 'dummy',
    'photo1' => 'dummy',
    'photo2' => 'dummy',
    'photo3' => 'dummy',
    'photo4' => 'dummy',
    'photo5' => 'dummy',
    'photo6' => 'dummy',
    'photo7' => 'dummy',
    'photo8' => 'dummy',
    'photo9' => 'dummy',
    'photo10' => 'dummy',
    'photo11' => 'dummy',
    'photo12' => 'dummy',
    'linkDoc' => 'dummy',
    'gdrive_id' => $dummyDriveId,
    'gdrive_id_1' => $dummyDriveId,
    'gdrive_id_2' => $dummyDriveId,
    'gdrive_id_3' => $dummyDriveId,
    'gdrive_id_4' => $dummyDriveId
]);

// 6. Schedule
\App\Models\Schedule::truncate();
\App\Models\Schedule::create([
    'month' => 'Juli',
    'year' => '2026',
    'title' => 'Jadwal Bulan Ini',
    'picture' => 'dummy.jpg',
    'gdrive_id' => $dummyDriveId
]);

// 7. Testimony
\App\Models\Testimony::truncate();
for($i=1; $i<=3; $i++) {
    \App\Models\Testimony::create([
        'name' => 'Alumni Inspiratif ' . $i,
        'profession' => 'Profesional Muda',
        'testimony' => 'LDK Syahid sangat membantu saya bertumbuh.',
        'picture' => 'dummy.jpg',
        'gdrive_id' => '1Cur2mISU8cwkWcyBuiwv9aGYNTxsZMPo' // hardcoded
    ]);
}

// 8. Books
try {
    \App\Models\MsCatalogBook::truncate();
    for($i=1; $i<=4; $i++) {
        \App\Models\MsCatalogBook::create([
            'bookID' => 'BOOK-00' . $i,
            'slug' => 'buku-inspiratif-' . $i,
            'titleBook' => 'Buku Inspiratif ' . $i,
            'authorName' => 'Penulis Terkenal',
            'year' => '2024',
            'pages' => 200,
            'flagActive' => 1, // integer
            'createdDate' => Carbon::now()->format('Y-m-d H:i:s'),
            'createdBy' => 'Admin',
            'coverImageGdriveID' => $dummyDriveId
        ]);
    }
} catch (\Exception $e) {
    echo "Error inserting books: " . $e->getMessage() . "\n";
}

echo "Database seeded successfully!\n";
