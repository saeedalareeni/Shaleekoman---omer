<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run()
    {
        $posts = [
            [
                'title_ar' => 'أفضل الشاليهات في مسقط لقضاء عطلة نهاية الأسبوع',
                'title_en' => 'Best Chalets in Muscat for Shaleek Getaways',
                'slug' => 'best-chalets-muscat-weekend',
                'body_ar' => '<h2>اكتشف أفضل الشاليهات في مسقط</h2>
                <p>تعتبر مسقط واحدة من أجمل المدن في عُمان، وتوفر العديد من الشاليهات الرائعة لقضاء عطلة نهاية أسبوع لا تُنسى. سواء كنت تبحث عن مكان هادئ للاسترخاء أو مساحة واسعة للاحتفالات العائلية، ستجد في مسقط ما يناسبك.</p>
                <h3>أهم المناطق للشاليهات في مسقط:</h3>
                <ul>
                    <li>منطقة السيب - شاليهات بإطلالات بحرية خلابة</li>
                    <li>بوشر - شاليهات عائلية مع حدائق واسعة</li>
                    <li>العامرات - شاليهات فاخرة مع مسابح خاصة</li>
                    <li>القرم - قريبة من المعالم السياحية</li>
                </ul>
                <p>عند اختيارك للشاليه المناسب، تأكد من مراعاة عدد الضيوف، المرافق المطلوبة، والموقع المناسب لخططك. احجز مبكراً خاصة في عطلات نهاية الأسبوع والعطل الرسمية.</p>',
                'body_en' => '<h2>Discover the Best Chalets in Muscat</h2>
                <p>Muscat is one of the most beautiful cities in Oman, offering numerous wonderful chalets for an unforgettable weekend getaway. Whether you are looking for a quiet place to relax or a spacious venue for family celebrations, you will find what suits you in Muscat.</p>
                <h3>Top Areas for Chalets in Muscat:</h3>
                <ul>
                    <li>Al Seeb - Chalets with stunning sea views</li>
                    <li>Bousher - Family chalets with spacious gardens</li>
                    <li>Al Amerat - Luxury chalets with private pools</li>
                    <li>Al Qurum - Close to tourist attractions</li>
                </ul>
                <p>When choosing the right chalet, make sure to consider the number of guests, required facilities, and suitable location for your plans. Book early especially on weekends and public holidays.</p>',
                'image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?w=800&q=80',
                'status' => 1,
                'category' => 'guides',
                'views' => 150,
                'tags' => 'مسقط,شاليهات,عطلة',
                'meta_title_ar' => 'أفضل الشاليهات في مسقط - دليل شامل',
                'meta_title_en' => 'Best Chalets in Muscat - Complete Guide',
            ],
            [
                'title_ar' => 'دليلك الشامل لحجز الشاليهات في صلالة',
                'title_en' => 'Your Complete Guide to Booking Chalets in Salalah',
                'slug' => 'guide-booking-chalets-salalah',
                'body_ar' => '<h2>موسم الخريف في صلالة</h2>
                <p>يعتبر موسم الخريف في صلالة من أجمل الأوقات لزيارة هذه المدينة الساحرة. من يوليو إلى سبتمبر، تتحول صلالة إلى جنة خضراء بفضل الأمطار الموسمية والضباب الكثيف.</p>
                <h3>نصائح لحجز الشاليه المثالي:</h3>
                <ol>
                    <li>احجز مبكراً - موسم الخريف مزدحم جداً</li>
                    <li>اختر موقعاً قريباً من الشلالات والوديان</li>
                    <li>تأكد من توفر التدفئة - الجو قد يكون بارداً</li>
                    <li>ابحث عن شاليهات مع شرفات لمشاهدة الطبيعة</li>
                </ol>
                <p>لا تفوت زيارة وادي دربات، عين رزات، وشاطئ المغسيل أثناء إقامتك.</p>',
                'body_en' => '<h2>Khareef Season in Salalah</h2>
                <p>The Khareef season in Salalah is one of the most beautiful times to visit this enchanting city. From July to September, Salalah transforms into a green paradise thanks to seasonal rains and thick fog.</p>
                <h3>Tips for Booking the Perfect Chalet:</h3>
                <ol>
                    <li>Book early - Khareef season is very busy</li>
                    <li>Choose a location near waterfalls and valleys</li>
                    <li>Make sure heating is available - weather can be cool</li>
                    <li>Look for chalets with balconies for nature viewing</li>
                </ol>
                <p>Don\'t miss visiting Wadi Darbat, Ain Razat, and Al Mughsail Beach during your stay.</p>',
                'image' => 'https://images.unsplash.com/photo-1587974928442-77dc3e0dba72?w=800&q=80',
                'status' => 1,
                'category' => 'tips',
                'views' => 230,
                'tags' => 'صلالة,خريف,حجز',
            ],
            [
                'title_ar' => '10 أنشطة يمكنك القيام بها في الشاليهات العائلية',
                'title_en' => '10 Activities You Can Do in Family Chalets',
                'slug' => '10-activities-family-chalets',
                'body_ar' => '<h2>أنشطة عائلية ممتعة في الشاليه</h2>
                <p>قضاء الوقت في الشاليه مع العائلة فرصة رائعة لخلق ذكريات لا تُنسى. إليك 10 أنشطة مميزة:</p>
                <ol>
                    <li><strong>حفلات الشواء:</strong> استمتع بوجبة شواء في الهواء الطلق</li>
                    <li><strong>السباحة:</strong> قضاء وقت ممتع في المسبح</li>
                    <li><strong>ألعاب جماعية:</strong> كرة الطائرة، كرة القدم</li>
                    <li><strong>جلسات سمر:</strong> حول النار مع القصص والأناشيد</li>
                    <li><strong>مشاهدة الأفلام:</strong> سينما عائلية في الهواء الطلق</li>
                    <li><strong>ألعاب الطاولة:</strong> شطرنج، لودو، كوتشينة</li>
                    <li><strong>الطبخ الجماعي:</strong> إعداد وجبات عائلية</li>
                    <li><strong>التصوير:</strong> جلسات تصوير عائلية</li>
                    <li><strong>الاسترخاء:</strong> قراءة الكتب والاستمتاع بالطبيعة</li>
                    <li><strong>الأنشطة الصباحية:</strong> اليوغا والرياضة</li>
                </ol>',
                'body_en' => '<h2>Fun Family Activities at the Chalet</h2>
                <p>Spending time at a chalet with family is a great opportunity to create unforgettable memories. Here are 10 special activities:</p>
                <ol>
                    <li><strong>BBQ Parties:</strong> Enjoy outdoor grilling</li>
                    <li><strong>Swimming:</strong> Fun time in the pool</li>
                    <li><strong>Group Games:</strong> Volleyball, football</li>
                    <li><strong>Evening Gatherings:</strong> Around the fire with stories</li>
                    <li><strong>Movie Nights:</strong> Outdoor family cinema</li>
                    <li><strong>Board Games:</strong> Chess, Ludo, cards</li>
                    <li><strong>Group Cooking:</strong> Preparing family meals</li>
                    <li><strong>Photography:</strong> Family photo sessions</li>
                    <li><strong>Relaxation:</strong> Reading books and enjoying nature</li>
                    <li><strong>Morning Activities:</strong> Yoga and exercise</li>
                </ol>',
                'image' => 'https://images.unsplash.com/photo-1517457373958-b7bdd4587205?w=800&q=80',
                'status' => 1,
                'category' => 'tips',
                'views' => 180,
                'tags' => 'أنشطة,عائلة,ترفيه',
            ],
            [
                'title_ar' => 'أفضل الأوقات لزيارة الشاليهات في عُمان',
                'title_en' => 'Best Times to Visit Chalets in Oman',
                'slug' => 'best-times-visit-chalets-oman',
                'body_ar' => '<h2>دليل المواسم السياحية في عُمان</h2>
                <h3>الشتاء (نوفمبر - مارس)</h3>
                <p>أفضل وقت لزيارة معظم المناطق في عُمان. الطقس معتدل ومثالي للأنشطة الخارجية. مناسب لجميع المناطق خاصة الصحراوية.</p>
                <h3>الصيف (أبريل - سبتمبر)</h3>
                <p>حار في معظم المناطق، لكنه الوقت المثالي لزيارة صلالة خلال موسم الخريف (يوليو - سبتمبر).</p>
                <h3>عطلات نهاية الأسبوع والأعياد</h3>
                <p>تشهد إقبالاً كبيراً، لذا يُنصح بالحجز المبكر. الأسعار قد تكون أعلى خلال هذه الفترات.</p>
                <h3>شهر رمضان</h3>
                <p>وقت مميز للتجمعات العائلية، مع أجواء روحانية خاصة. العديد من الشاليهات تقدم عروضاً خاصة.</p>',
                'body_en' => '<h2>Tourist Seasons Guide in Oman</h2>
                <h3>Winter (November - March)</h3>
                <p>Best time to visit most areas in Oman. Weather is moderate and perfect for outdoor activities. Suitable for all regions especially desert areas.</p>
                <h3>Summer (April - September)</h3>
                <p>Hot in most areas, but it\'s the perfect time to visit Salalah during Khareef season (July - September).</p>
                <h3>Shaleek and Holidays</h3>
                <p>High demand periods, so early booking is advised. Prices may be higher during these times.</p>
                <h3>Ramadan Month</h3>
                <p>Special time for family gatherings with unique spiritual atmosphere. Many chalets offer special deals.</p>',
                'image' => 'https://images.unsplash.com/photo-1499793983690-e29da59ef1c2?w=800&q=80',
                'status' => 1,
                'category' => 'guides',
                'views' => 120,
                'tags' => 'مواسم,طقس,سياحة',
            ],
        ];

        foreach ($posts as $post) {
            Post::create($post);
        }
    }
}
