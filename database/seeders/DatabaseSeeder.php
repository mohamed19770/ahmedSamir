<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Destination;
use App\Models\TourismPackage;
use App\Models\Activity;
use App\Models\BlogPost;
use App\Models\Testimonial;
use App\Models\Gallery;
use App\Models\Slider;
use App\Models\Faq;
use App\Models\Partner;
use App\Models\SeoSetting;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@designation2go.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        $this->seedDestinations();
        $this->seedPackages();
        $this->seedActivities();
        $this->seedBlogPosts($admin);
        $this->seedTestimonials();
        $this->seedSliders();
        $this->seedFaqs();
        $this->seedSeoSettings();
    }

    private function seedDestinations(): void
    {
        $destinations = [
            [
                'name' => ['en' => 'Santorini, Greece', 'ar' => 'سانتوريني، اليونان', 'hr' => 'Santorini, Grčka'],
                'slug' => ['en' => 'santorini-greece', 'ar' => 'santorini-greece', 'hr' => 'santorini-grcka'],
                'description' => ['en' => 'Experience the stunning sunsets and white-washed architecture of this iconic Greek island.', 'ar' => 'استمتع بغروب الشمس المذهل والهندسة المعمارية البيضاء لهذه الجزيرة اليونانية الشهيرة.', 'hr' => 'Doživite zadivljujuće zalaske sunca i bijelu arhitekturu ovog ikoničnog grčkog otoka.'],
                'short_description' => ['en' => 'Iconic Greek island paradise', 'ar' => 'جنة الجزيرة اليونانية الشهيرة', 'hr' => 'Ikonski grčki otok raj'],
                'country' => 'Greece', 'city' => 'Santorini', 'image' => 'https://images.unsplash.com/photo-1613395877344-13d4a8e0d49e?w=800',
                'is_featured' => true, 'is_active' => true,
            ],
            [
                'name' => ['en' => 'Bali, Indonesia', 'ar' => 'بالي، إندونيسيا', 'hr' => 'Bali, Indonezija'],
                'slug' => ['en' => 'bali-indonesia', 'ar' => 'bali-indonesia', 'hr' => 'bali-indonezija'],
                'description' => ['en' => 'Discover tropical paradise with ancient temples, rice terraces, and world-class beaches.', 'ar' => 'اكتشف الجنة الاستوائية مع المعابد القديمة ومدرجات الأرز والشواطئ العالمية.', 'hr' => 'Otkrijte tropski raj s drevnim hramovima, rižinim terasama i plažama svjetske klase.'],
                'short_description' => ['en' => 'Tropical paradise with ancient culture', 'ar' => 'جنة استوائية مع ثقافة عريقة', 'hr' => 'Tropski raj s drevnom kulturom'],
                'country' => 'Indonesia', 'city' => 'Bali', 'image' => 'https://images.unsplash.com/photo-1537996194471-e657df975ab4?w=800',
                'is_featured' => true, 'is_active' => true,
            ],
            [
                'name' => ['en' => 'Dubai, UAE', 'ar' => 'دبي، الإمارات', 'hr' => 'Dubai, UAE'],
                'slug' => ['en' => 'dubai-uae', 'ar' => 'dubai-uae', 'hr' => 'dubai-uae'],
                'description' => ['en' => 'A city of superlatives offering luxury shopping, ultramodern architecture, and desert adventures.', 'ar' => 'مدينة التفوق تقدم تسوقاً فاخراً وهندسة معمارية حديثة ومغامرات صحراوية.', 'hr' => 'Grad superlativa koji nudi luksuznu kupovinu, ultramodernu arhitekturu i pustinjske avanture.'],
                'short_description' => ['en' => 'Ultra-luxury modern city', 'ar' => 'مدينة حديثة فائقة الفخامة', 'hr' => 'Ultra-luksuzni moderni grad'],
                'country' => 'UAE', 'city' => 'Dubai', 'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800',
                'is_featured' => true, 'is_active' => true,
            ],
        ];

        foreach ($destinations as $data) {
            Destination::create($data);
        }
    }

    private function seedPackages(): void
    {
        $packages = [
            [
                'destination_id' => 1,
                'title' => ['en' => 'Desert Safari Adventure', 'ar' => 'مغامرة سفاري الصحراء', 'hr' => 'Pustinjska safari avantura'],
                'slug' => ['en' => 'desert-safari-adventure', 'ar' => 'desert-safari-adventure', 'hr' => 'pustinjska-safari-avantura'],
                'description' => ['en' => '<p>Experience the ultimate desert adventure with our premium safari package. Includes dune bashing, camel riding, traditional BBQ dinner, and overnight camping under the stars.</p>', 'ar' => '<p>استمتع بمغامرة الصحراء المطلقة مع باقة السفاري المتميزة لدينا. تشمل قيادة الكثبان وركوب الجمال وعشاء شواء تقليدي والتخييم تحت النجوم.</p>', 'hr' => '<p>Doživite ultimativnu pustinjsku avanturu s našim premium safari paketom.</p>'],
                'short_description' => ['en' => 'Experience the thrill of desert safari with luxury camping under the stars.', 'ar' => 'استمتع بإثارة رحلات السفاري الصحراوية مع التخييم الفاخر تحت النجوم.', 'hr' => 'Doživite uzbuđenje pustinjskog safarija s luksuznim kampiranjem pod zvijezdama.'],
                'duration_days' => 3, 'duration_nights' => 2, 'price' => 799, 'sale_price' => 599,
                'currency' => 'USD', 'max_guests' => 15, 'min_guests' => 2, 'category' => 'adventure',
                'included' => ['4x4 desert drive', 'Camel riding', 'Traditional dinner', 'Overnight camping', 'Breakfast', 'Photography'],
                'excluded' => ['International flights', 'Travel insurance', 'Personal expenses', 'Tips'],
                'itinerary' => [
                    ['title' => 'Arrival & Desert Drive', 'description' => 'Arrive at the meeting point and begin your thrilling dune bashing experience.'],
                    ['title' => 'Cultural Experience', 'description' => 'Enjoy camel riding, henna painting, and traditional entertainment.'],
                    ['title' => 'Sunrise & Return', 'description' => 'Wake up to a beautiful desert sunrise, enjoy breakfast, and return to the city.'],
                ],
                'image' => 'https://images.unsplash.com/photo-1451337516015-6b6e9a44a8a3?w=800',
                'is_featured' => true, 'is_active' => true, 'difficulty_level' => 'moderate',
            ],
            [
                'destination_id' => 2,
                'title' => ['en' => 'Tropical Beach Getaway', 'ar' => 'إجازة الشاطئ الاستوائي', 'hr' => 'Tropski odmor na plaži'],
                'slug' => ['en' => 'tropical-beach-getaway', 'ar' => 'tropical-beach-getaway', 'hr' => 'tropski-odmor-na-plazi'],
                'description' => ['en' => '<p>Escape to paradise with our tropical beach package. Crystal clear waters, white sand beaches, and luxury beachfront accommodation await you.</p>', 'ar' => '<p>اهرب إلى الجنة مع باقة الشاطئ الاستوائي لدينا.</p>', 'hr' => '<p>Pobjegnite u raj s našim tropskim paketom.</p>'],
                'short_description' => ['en' => 'Relax on pristine beaches with crystal clear waters and white sand.', 'ar' => 'استرخِ على شواطئ نقية مع مياه صافية ورمال بيضاء.', 'hr' => 'Opustite se na netaknutim plažama s kristalno čistom vodom.'],
                'duration_days' => 7, 'duration_nights' => 6, 'price' => 2199, 'sale_price' => 1899,
                'currency' => 'USD', 'max_guests' => 8, 'min_guests' => 2, 'category' => 'beach',
                'included' => ['Luxury resort accommodation', 'All meals', 'Snorkeling equipment', 'Island hopping tour', 'Airport transfers', 'Spa session'],
                'excluded' => ['Flights', 'Travel insurance', 'Alcoholic beverages', 'Tips'],
                'itinerary' => [],
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=800',
                'is_featured' => true, 'is_active' => true, 'difficulty_level' => 'easy',
            ],
            [
                'destination_id' => 3,
                'title' => ['en' => 'Luxury Dubai Experience', 'ar' => 'تجربة دبي الفاخرة', 'hr' => 'Luksuzno Dubai iskustvo'],
                'slug' => ['en' => 'luxury-dubai-experience', 'ar' => 'luxury-dubai-experience', 'hr' => 'luksuzno-dubai-iskustvo'],
                'description' => ['en' => '<p>Immerse yourself in the opulence of Dubai with our luxury experience package.</p>', 'ar' => '<p>انغمس في فخامة دبي مع باقة التجربة الفاخرة لدينا.</p>', 'hr' => '<p>Uronite u raskoš Dubaija s našim luksuznim paketom.</p>'],
                'short_description' => ['en' => 'Experience Dubai like royalty with our premium luxury package.', 'ar' => 'استمتع بدبي كالملوك مع باقتنا الفاخرة المتميزة.', 'hr' => 'Doživite Dubai kao kraljevstvo s našim premium luksuznim paketom.'],
                'duration_days' => 5, 'duration_nights' => 4, 'price' => 3499, 'sale_price' => null,
                'currency' => 'USD', 'max_guests' => 6, 'min_guests' => 2, 'category' => 'luxury',
                'included' => ['5-star hotel', 'Private chauffeur', 'Desert safari', 'Burj Khalifa VIP', 'Yacht cruise', 'Shopping tour'],
                'excluded' => ['Flights', 'Personal shopping', 'Tips'],
                'itinerary' => [],
                'image' => 'https://images.unsplash.com/photo-1512453979798-5ea266f8880c?w=800',
                'is_featured' => true, 'is_active' => true, 'difficulty_level' => 'easy',
            ],
        ];

        foreach ($packages as $data) {
            TourismPackage::create($data);
        }
    }

    private function seedActivities(): void
    {
        $activities = [
            ['title' => ['en' => 'Desert Safari', 'ar' => 'سفاري الصحراء', 'hr' => 'Pustinjski safari'], 'slug' => ['en' => 'desert-safari', 'ar' => 'desert-safari', 'hr' => 'pustinjski-safari'], 'description' => ['en' => 'Thrilling dune bashing and cultural desert experience.', 'ar' => 'تجربة مثيرة في قيادة الكثبان الرملية.', 'hr' => 'Uzbudljivo voženje po dinama i kulturno pustinjsko iskustvo.'], 'short_description' => ['en' => 'Thrilling desert experience', 'ar' => 'تجربة صحراوية مثيرة', 'hr' => 'Uzbudljivo pustinjsko iskustvo'], 'price' => 150, 'duration' => '6 Hours', 'category' => 'desert-safari', 'location' => 'Dubai', 'image' => 'https://images.unsplash.com/photo-1451337516015-6b6e9a44a8a3?w=800', 'is_featured' => true, 'is_active' => true],
            ['title' => ['en' => 'Scuba Diving', 'ar' => 'غوص السكوبا', 'hr' => 'Ronjenje'], 'slug' => ['en' => 'scuba-diving', 'ar' => 'scuba-diving', 'hr' => 'ronjenje'], 'description' => ['en' => 'Explore vibrant coral reefs and marine life.', 'ar' => 'استكشف الشعاب المرجانية النابضة بالحياة.', 'hr' => 'Istražite živopisne koraljne grebene.'], 'short_description' => ['en' => 'Explore underwater wonders', 'ar' => 'استكشف عجائب تحت الماء', 'hr' => 'Istražite podvodna čuda'], 'price' => 200, 'duration' => '4 Hours', 'category' => 'diving', 'location' => 'Red Sea', 'image' => 'https://images.unsplash.com/photo-1544551763-46a013bb70d5?w=800', 'is_featured' => true, 'is_active' => true],
            ['title' => ['en' => 'Historical Tour', 'ar' => 'جولة تاريخية', 'hr' => 'Povijesna tura'], 'slug' => ['en' => 'historical-tour', 'ar' => 'historical-tour', 'hr' => 'povijesna-tura'], 'description' => ['en' => 'Walk through ancient civilizations with expert guides.', 'ar' => 'تجول في الحضارات القديمة مع مرشدين خبراء.', 'hr' => 'Prošetajte kroz drevne civilizacije s vodičima stručnjacima.'], 'short_description' => ['en' => 'Discover ancient history', 'ar' => 'اكتشف التاريخ القديم', 'hr' => 'Otkrijte drevnu povijest'], 'price' => 85, 'duration' => '8 Hours', 'category' => 'historical', 'location' => 'Cairo', 'image' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=800', 'is_featured' => true, 'is_active' => true],
        ];

        foreach ($activities as $data) {
            Activity::create($data);
        }
    }

    private function seedBlogPosts($author): void
    {
        $posts = [
            [
                'author_id' => $author->id,
                'title' => ['en' => '10 Hidden Gems in Southeast Asia', 'ar' => '10 جواهر مخفية في جنوب شرق آسيا', 'hr' => '10 skrivenih dragulja jugoistočne Azije'],
                'slug' => ['en' => '10-hidden-gems-southeast-asia', 'ar' => '10-hidden-gems-southeast-asia', 'hr' => '10-skrivenih-dragulja-jugoistocne-azije'],
                'content' => ['en' => '<p>Discover the most breathtaking hidden destinations in Southeast Asia that most travelers miss...</p>', 'ar' => '<p>اكتشف أروع الوجهات المخفية في جنوب شرق آسيا...</p>', 'hr' => '<p>Otkrijte najzadivljujuće skrivene destinacije u jugoistočnoj Aziji...</p>'],
                'excerpt' => ['en' => 'Discover untouched paradises that most travelers miss.', 'ar' => 'اكتشف جنات لم تمسها أيدي معظم المسافرين.', 'hr' => 'Otkrijte netaknute rajeve koje većina putnika propusti.'],
                'image' => 'https://images.unsplash.com/photo-1552733407-5d5c46c3bb3b?w=800',
                'category' => 'destinations', 'tags' => ['asia', 'hidden gems', 'adventure'],
                'is_published' => true, 'published_at' => now(), 'views_count' => 1250,
            ],
        ];

        foreach ($posts as $data) {
            BlogPost::create($data);
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            ['name' => 'Sarah Johnson', 'email' => 'sarah@example.com', 'rating' => 5, 'content' => ['en' => 'An absolutely incredible experience! The team made every moment magical.', 'ar' => 'تجربة رائعة بشكل مطلق! جعل الفريق كل لحظة سحرية.', 'hr' => 'Apsolutno nevjerojatno iskustvo! Tim je svaki trenutak učinio čarobnim.'], 'designation' => 'Travel Enthusiast', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Ahmed Al-Rashid', 'email' => 'ahmed@example.com', 'rating' => 5, 'content' => ['en' => 'Professional service from start to finish. Exceeded all expectations.', 'ar' => 'خدمة احترافية من البداية إلى النهاية. تجاوزت كل التوقعات.', 'hr' => 'Profesionalna usluga od početka do kraja. Premašili su sva očekivanja.'], 'designation' => 'Business Executive', 'is_featured' => true, 'is_active' => true],
            ['name' => 'Maria Kovačević', 'email' => 'maria@example.com', 'rating' => 5, 'content' => ['en' => 'Our honeymoon was absolutely magical. Every detail was perfectly planned.', 'ar' => 'كان شهر العسل سحرياً بشكل مطلق. كل تفصيل كان مخططاً بشكل مثالي.', 'hr' => 'Naš medeni mjesec bio je apsolutno čaroban. Svaki detalj savršeno isplaniran.'], 'designation' => 'Honeymoon Traveler', 'is_featured' => true, 'is_active' => true],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create($data);
        }
    }

    private function seedSliders(): void
    {
        $slides = [
            [
                'title' => ['en' => 'Discover Paradise', 'ar' => 'اكتشف الجنة', 'hr' => 'Otkrijte raj'],
                'subtitle' => ['en' => 'Your Gateway to Extraordinary Journeys', 'ar' => 'بوابتك نحو رحلات استثنائية', 'hr' => 'Vaša vrata u izvanredna putovanja'],
                'image' => 'https://images.unsplash.com/photo-1506929562872-bb421503ef21?w=1920&q=80',
                'sort_order' => 1,
            ],
            [
                'title' => ['en' => 'Tropical Escapes', 'ar' => 'ملاذات استوائية', 'hr' => 'Tropski bijeg'],
                'subtitle' => ['en' => 'Crystal waters & golden sunsets', 'ar' => 'مياه صافية وغروب ذهبي', 'hr' => 'Kristalno more i zlatni zalasci'],
                'image' => 'https://images.unsplash.com/photo-1507525428034-b723cf961d3e?w=1920&q=80',
                'sort_order' => 2,
            ],
            [
                'title' => ['en' => 'Mountain Adventures', 'ar' => 'مغامرات جبلية', 'hr' => 'Planinske avanture'],
                'subtitle' => ['en' => 'Breathtaking peaks await', 'ar' => 'قمم خلابة بانتظارك', 'hr' => 'Zadivljujući vrhovi čekaju'],
                'image' => 'https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?w=1920&q=80',
                'sort_order' => 3,
            ],
            [
                'title' => ['en' => 'Historic Wonders', 'ar' => 'عجائب تاريخية', 'hr' => 'Povijesna čuda'],
                'subtitle' => ['en' => 'Culture & heritage tours', 'ar' => 'جولات ثقافة وتراث', 'hr' => 'Kultura i baština'],
                'image' => 'https://images.unsplash.com/photo-1539650116574-75c0c6d73f6e?w=1920&q=80',
                'sort_order' => 4,
            ],
            [
                'title' => ['en' => 'Desert Dreams', 'ar' => 'أحلام الصحراء', 'hr' => 'Pustinjski snovi'],
                'subtitle' => ['en' => 'Luxury under the stars', 'ar' => 'فخامة تحت النجوم', 'hr' => 'Luksuz pod zvijezdama'],
                'image' => 'https://images.unsplash.com/photo-1451337516015-6b6e9a44a8a3?w=1920&q=80',
                'sort_order' => 5,
            ],
        ];

        foreach ($slides as $slide) {
            Slider::create(array_merge($slide, [
                'description' => ['en' => 'Experience luxury travel like never before.', 'ar' => 'استمتع بالسفر الفاخر كما لم تعهده من قبل.', 'hr' => 'Doživite luksuzno putovanje kao nikad prije.'],
                'button_text' => ['en' => 'Explore Packages', 'ar' => 'استكشف الباقات', 'hr' => 'Istraži pakete'],
                'button_url' => '/en/packages',
                'is_active' => true,
            ]));
        }
    }

    private function seedFaqs(): void
    {
        $faqs = [
            ['question' => ['en' => 'How do I book a tourism package?', 'ar' => 'كيف أحجز باقة سياحية؟', 'hr' => 'Kako rezervirati turistički paket?'], 'answer' => ['en' => 'You can book directly through our website by selecting a package and filling out the booking form.', 'ar' => 'يمكنك الحجز مباشرة من خلال موقعنا عن طريق اختيار باقة وملء نموذج الحجز.', 'hr' => 'Možete rezervirati izravno putem naše web stranice.'], 'category' => 'booking', 'sort_order' => 1, 'is_active' => true],
            ['question' => ['en' => 'What is your cancellation policy?', 'ar' => 'ما هي سياسة الإلغاء الخاصة بكم؟', 'hr' => 'Koja je vaša politika otkazivanja?'], 'answer' => ['en' => 'We offer free cancellation up to 48 hours before the trip start date.', 'ar' => 'نقدم إلغاء مجاني حتى 48 ساعة قبل تاريخ بدء الرحلة.', 'hr' => 'Nudimo besplatno otkazivanje do 48 sati prije početka putovanja.'], 'category' => 'booking', 'sort_order' => 2, 'is_active' => true],
        ];

        foreach ($faqs as $data) {
            Faq::create($data);
        }
    }

    private function seedSeoSettings(): void
    {
        $pages = ['home', 'about', 'packages', 'activities', 'hotels', 'blog', 'contact', 'gallery', 'faq'];
        foreach ($pages as $page) {
            SeoSetting::create([
                'page_identifier' => $page,
                'meta_title' => ['en' => ucfirst($page) . ' - Designation 2 Go', 'ar' => ucfirst($page) . ' - Designation 2 Go', 'hr' => ucfirst($page) . ' - Designation 2 Go'],
                'meta_description' => ['en' => 'Designation 2 Go - Your Gateway to Extraordinary Journeys. Premium tourism services.', 'ar' => 'Designation 2 Go - بوابتك نحو رحلات استثنائية.', 'hr' => 'Designation 2 Go - Vaša vrata u izvanredna putovanja.'],
            ]);
        }
    }
}
