<?php

namespace Database\Seeders;

use App\Models\Cafe;
use App\Models\CafePhoto;
use App\Models\CafeSchedule;
use App\Models\Favorite;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ==================== USERS ====================
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@thehearth.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        $owner1 = User::create([
            'name' => 'Marco Rossi',
            'email' => 'marco@thehearth.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        $owner2 = User::create([
            'name' => 'Sari Wijaya',
            'email' => 'sari@thehearth.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        $owner3 = User::create([
            'name' => 'James Chen',
            'email' => 'james@thehearth.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        $owner4 = User::create([
            'name' => 'Ayu Pratiwi',
            'email' => 'ayu@thehearth.com',
            'password' => Hash::make('password'),
            'role' => 'owner',
        ]);

        $user1 = User::create([
            'name' => 'Diana Hartley',
            'email' => 'diana@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user2 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        $user3 = User::create([
            'name' => 'Emily Watson',
            'email' => 'emily@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // ==================== CAFES ====================
        $cafe1 = Cafe::create([
            'user_id' => $owner1->id,
            'name' => 'The Gilded Bean',
            'slug' => 'the-gilded-bean',
            'about' => 'The Gilded Bean is more than just a coffee shop. It\'s a cultural melting pot nestled in the heart of the Creative District, supplying the finest single-origin beans alongside artisanal pastries and light meals. Our space is designed to be a sanctuary for the curious mind, a place for the heart and Soul of Exploration. Step inside and discover a world of carefully curated flavors, from exotic pour-overs to decadent espresso-based creations.',
            'address' => 'Jl. Braga No. 58, Bandung, Jawa Barat',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.60881!3d-6.917464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMDIuOSJTIDEwN8KwMzYnMjAuOSJF!5e0!3m2!1sid!2sid!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'latitude' => -6.917464,
            'longitude' => 107.608810,
            'is_approved' => true,
        ]);

        $cafe2 = Cafe::create([
            'user_id' => $owner2->id,
            'name' => 'Kopi Nusantara',
            'slug' => 'kopi-nusantara',
            'about' => 'Kopi Nusantara merupakan cafe yang mengusung konsep tradisional Indonesia modern. Kami menyajikan kopi-kopi terbaik dari seluruh penjuru nusantara, dari Aceh Gayo hingga Toraja. Suasana yang hangat dengan sentuhan budaya Indonesia akan membuat Anda betah berlama-lama. Nikmati juga aneka kudapan tradisional yang telah kami modernisasi untuk selera masa kini.',
            'address' => 'Jl. Dago No. 123, Bandung, Jawa Barat',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.61881!3d-6.885464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTMnMDcuNyJTIDEwN8KwMzcnMDcuNyJF!5e0!3m2!1sid!2sid!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'latitude' => -6.885464,
            'longitude' => 107.618810,
            'is_approved' => true,
        ]);

        $cafe3 = Cafe::create([
            'user_id' => $owner3->id,
            'name' => 'Brew & Beyond',
            'slug' => 'brew-and-beyond',
            'about' => 'Brew & Beyond is a specialty coffee experience that takes you on a journey through the world of third-wave coffee. Our baristas are trained experts who craft each cup with precision and passion. We source our beans directly from farms on three continents, ensuring that every sip tells a story. The minimalist Scandinavian interior creates the perfect backdrop for focused work or intimate conversations.',
            'address' => 'Jl. Riau No. 45, Bandung, Jawa Barat',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.62881!3d-6.908464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTQnMzAuNSJTIDEwN8KwMzcnNDMuNyJF!5e0!3m2!1sid!2sid!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'latitude' => -6.908464,
            'longitude' => 107.628810,
            'is_approved' => true,
        ]);

        $cafe4 = Cafe::create([
            'user_id' => $owner4->id,
            'name' => 'Rumah Kopi Heritage',
            'slug' => 'rumah-kopi-heritage',
            'about' => 'Rumah Kopi Heritage adalah tempat di mana tradisi bertemu inovasi. Terletak di bangunan heritage yang telah direstorasi dengan penuh cinta, cafe kami menawarkan pengalaman ngopi yang tak terlupakan. Menu kami memadukan resep kopi turun-temurun dengan teknik brewing modern. Setiap sudut ruangan menceritakan kisah sejarah kopi Indonesia yang kaya.',
            'address' => 'Jl. Asia Afrika No. 89, Bandung, Jawa Barat',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.798467107128!2d107.60581!3d-6.921464!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTUnMTcuMyJTIDEwN8KwMzYnMjAuOSJF!5e0!3m2!1sid!2sid!4v1234567890" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
            'latitude' => -6.921464,
            'longitude' => 107.605810,
            'is_approved' => true,
        ]);

        // ==================== CAFE PHOTOS ====================
        $cafePhotos = [
            // The Gilded Bean
            ['cafe_id' => $cafe1->id, 'photo_path' => 'cafe-photos/default1.jpg', 'is_primary' => true],
            ['cafe_id' => $cafe1->id, 'photo_path' => 'cafe-photos/default2.jpg', 'is_primary' => false],
            ['cafe_id' => $cafe1->id, 'photo_path' => 'cafe-photos/default3.jpg', 'is_primary' => false],
            // Kopi Nusantara
            ['cafe_id' => $cafe2->id, 'photo_path' => 'cafe-photos/default4.jpg', 'is_primary' => true],
            ['cafe_id' => $cafe2->id, 'photo_path' => 'cafe-photos/default5.jpg', 'is_primary' => false],
            // Brew & Beyond
            ['cafe_id' => $cafe3->id, 'photo_path' => 'cafe-photos/default6.jpg', 'is_primary' => true],
            ['cafe_id' => $cafe3->id, 'photo_path' => 'cafe-photos/default7.jpg', 'is_primary' => false],
            // Rumah Kopi Heritage
            ['cafe_id' => $cafe4->id, 'photo_path' => 'cafe-photos/default8.jpg', 'is_primary' => true],
            ['cafe_id' => $cafe4->id, 'photo_path' => 'cafe-photos/default9.jpg', 'is_primary' => false],
        ];

        foreach ($cafePhotos as $photo) {
            CafePhoto::create($photo);
        }

        // ==================== CAFE SCHEDULES ====================
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $cafes = [$cafe1, $cafe2, $cafe3, $cafe4];

        $scheduleTemplates = [
            // The Gilded Bean: Mon-Sat 08-22, Sun 09-21
            [
                'weekday' => ['open_time' => '08:00', 'close_time' => '22:00'],
                'saturday' => ['open_time' => '08:00', 'close_time' => '22:00'],
                'sunday' => ['open_time' => '09:00', 'close_time' => '21:00'],
            ],
            // Kopi Nusantara: Mon-Fri 07-23, Sat-Sun 08-00
            [
                'weekday' => ['open_time' => '07:00', 'close_time' => '23:00'],
                'saturday' => ['open_time' => '08:00', 'close_time' => '23:59'],
                'sunday' => ['open_time' => '08:00', 'close_time' => '23:59'],
            ],
            // Brew & Beyond: Tue-Sat 09-21, Sun 10-18, Mon closed
            [
                'weekday' => ['open_time' => '09:00', 'close_time' => '21:00'],
                'saturday' => ['open_time' => '09:00', 'close_time' => '21:00'],
                'sunday' => ['open_time' => '10:00', 'close_time' => '18:00'],
                'closed_days' => ['monday'],
            ],
            // Rumah Kopi Heritage: Mon-Sun 10-22
            [
                'weekday' => ['open_time' => '10:00', 'close_time' => '22:00'],
                'saturday' => ['open_time' => '10:00', 'close_time' => '22:00'],
                'sunday' => ['open_time' => '10:00', 'close_time' => '22:00'],
            ],
        ];

        foreach ($cafes as $index => $cafe) {
            $template = $scheduleTemplates[$index];
            foreach ($days as $day) {
                $isClosed = isset($template['closed_days']) && in_array($day, $template['closed_days']);

                if ($day === 'sunday') {
                    $times = $template['sunday'];
                } elseif ($day === 'saturday') {
                    $times = $template['saturday'];
                } else {
                    $times = $template['weekday'];
                }

                CafeSchedule::create([
                    'cafe_id' => $cafe->id,
                    'day' => $day,
                    'open_time' => $isClosed ? null : $times['open_time'],
                    'close_time' => $isClosed ? null : $times['close_time'],
                    'is_closed' => $isClosed,
                ]);
            }
        }

        // ==================== REVIEWS ====================
        $reviews = [
            // The Gilded Bean reviews
            [
                'user_id' => $user1->id,
                'cafe_id' => $cafe1->id,
                'rating' => 5,
                'comment' => 'This place exceeded every expectation. The single-origin coffee from a smallholding in Ethiopia was mind-blowing — juicy, floral, and incredibly complex. The interior is stunning, and the baristas clearly know their craft. A must-visit for any serious coffee lover.',
            ],
            [
                'user_id' => $user2->id,
                'cafe_id' => $cafe1->id,
                'rating' => 4,
                'comment' => 'Tempatnya sangat nyaman dan estetik. Kopi latte-nya enak banget, tapi harganya agak mahal untuk ukuran Bandung. Overall, worth it untuk pengalaman dan suasananya.',
            ],
            [
                'user_id' => $user3->id,
                'cafe_id' => $cafe1->id,
                'rating' => 5,
                'comment' => 'The croissants here are divine! And the pour-over coffee is perfectly brewed. The staff is friendly and knowledgeable about their beans. Will definitely come back.',
            ],

            // Kopi Nusantara reviews
            [
                'user_id' => $user1->id,
                'cafe_id' => $cafe2->id,
                'rating' => 5,
                'comment' => 'Authentic Indonesian coffee experience! The Toraja blend is incredibly smooth and the traditional snacks pair perfectly. Love the cultural ambiance.',
            ],
            [
                'user_id' => $user2->id,
                'cafe_id' => $cafe2->id,
                'rating' => 4,
                'comment' => 'Kopi Gayo-nya mantap! Suasananya juga enak banget, ada sentuhan tradisional yang bikin betah. Recommended!',
            ],

            // Brew & Beyond reviews
            [
                'user_id' => $user1->id,
                'cafe_id' => $cafe3->id,
                'rating' => 4,
                'comment' => 'Great third-wave coffee spot. The V60 pour-over was exceptional. Clean, minimalist design makes it perfect for working. WiFi is fast too!',
            ],
            [
                'user_id' => $user3->id,
                'cafe_id' => $cafe3->id,
                'rating' => 5,
                'comment' => 'Best specialty coffee in town. The barista took time to explain the flavor notes and brewing method. Such a wonderful experience.',
            ],

            // Rumah Kopi Heritage reviews
            [
                'user_id' => $user2->id,
                'cafe_id' => $cafe4->id,
                'rating' => 5,
                'comment' => 'Tempat yang luar biasa! Bangunan heritage-nya cantik sekali, dan kopi tubruknya enak banget. Bisa merasakan sejarah di setiap tegukan.',
            ],
            [
                'user_id' => $user3->id,
                'cafe_id' => $cafe4->id,
                'rating' => 4,
                'comment' => 'The heritage building is absolutely gorgeous. The traditional coffee recipes are unique and delicious. A true gem in the city.',
            ],
        ];

        foreach ($reviews as $reviewData) {
            Review::create($reviewData);
        }

        // ==================== REVIEW REPLIES ====================
        $reviewReplies = [
            [
                'review_id' => 1,
                'user_id' => $owner1->id,
                'reply' => 'Thank you so much, Diana! We\'re thrilled you enjoyed the Ethiopian single-origin. Our team puts a lot of love into every cup. Hope to see you again soon! ☕',
            ],
            [
                'review_id' => 2,
                'user_id' => $owner1->id,
                'reply' => 'Terima kasih atas review-nya, Budi! Kami appreciate feedbacknya tentang harga. Kami selalu berusaha memberikan kualitas terbaik. Semoga bisa berkunjung lagi!',
            ],
            [
                'review_id' => 4,
                'user_id' => $owner2->id,
                'reply' => 'Terima kasih Diana! Senang sekali Anda menikmati Toraja blend kami. Kopi Indonesia memang luar biasa kekayaannya.',
            ],
            [
                'review_id' => 8,
                'user_id' => $owner4->id,
                'reply' => 'Terima kasih banyak, Budi! Kami bangga bisa menjaga warisan budaya kopi Indonesia melalui tempat ini. Selamat datang kembali kapan saja!',
            ],
        ];

        foreach ($reviewReplies as $replyData) {
            ReviewReply::create($replyData);
        }

        // ==================== FAVORITES ====================
        $favorites = [
            ['user_id' => $user1->id, 'cafe_id' => $cafe1->id],
            ['user_id' => $user1->id, 'cafe_id' => $cafe2->id],
            ['user_id' => $user2->id, 'cafe_id' => $cafe1->id],
            ['user_id' => $user2->id, 'cafe_id' => $cafe4->id],
            ['user_id' => $user3->id, 'cafe_id' => $cafe1->id],
            ['user_id' => $user3->id, 'cafe_id' => $cafe3->id],
        ];

        foreach ($favorites as $favData) {
            Favorite::create($favData);
        }
    }
}
