<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Chalet;
use App\Models\ChaletImage;

class UpdateChaletDetailsSeeder extends Seeder
{
    public function run()
    {
        // تحديث الشاليه المحدد
        $chalet = Chalet::where('slug', 'chalet-10-1758984757593')->first();
        
        if ($chalet) {
            // تحديث البيانات الأساسية
            $chalet->update([
                'chalet_name_ar' => 'شاليه نخيل الدمام الفاخر',
                'chalet_name_en' => 'Luxury Palm Dammam Chalet',
                
                'short_description_ar' => 'شاليه فاخر مع مسبح خاص وحديقة واسعة، مثالي للعائلات والمناسبات الخاصة في قلب الدمام',
                'short_description_en' => 'Luxury chalet with private pool and spacious garden, perfect for families and special occasions in the heart of Dammam',
                
                'long_description_ar' => 'استمتع بإقامة لا تُنسى في شاليه نخيل الدمام الفاخر، حيث يجتمع الفخامة مع الراحة في مكان واحد. يتميز الشاليه بتصميم عصري أنيق مع لمسات تقليدية سعودية، ويضم مسبحاً خاصاً كبيراً مع منطقة للأطفال، وحديقة واسعة مع منطقة شواء مجهزة بالكامل. الشاليه مكيف بالكامل ومجهز بأحدث الأجهزة والمرافق. يحتوي على صالة استقبال واسعة، وصالة طعام تتسع لـ 20 شخص، ومطبخ مجهز بالكامل، و4 غرف نوم فاخرة مع حمامات خاصة. كما يتوفر مجلس خارجي مع جلسات عربية تقليدية، وملعب للأطفال، ومواقف سيارات خاصة تتسع لـ 8 سيارات.',
                'long_description_en' => 'Enjoy an unforgettable stay at the Luxury Palm Dammam Chalet, where luxury meets comfort in one place. The chalet features a modern elegant design with traditional Saudi touches, and includes a large private swimming pool with children area, and a spacious garden with fully equipped BBQ area. The chalet is fully air-conditioned and equipped with the latest appliances and facilities. It contains a spacious reception hall, dining room for 20 people, fully equipped kitchen, and 4 luxury bedrooms with private bathrooms. There is also an outdoor majlis with traditional Arabic seating, playground for children, and private parking for 8 cars.',
                
                'location' => 'الدمام - حي الشاطئ الغربي، شارع الأمير محمد بن فهد',
                'map_link' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3577.8961!2d50.0891!3d26.3667!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjbCsDIyJzAwLjEiTiA1MMKwMDUnMjAuOCJF!5e0!3m2!1sen!2ssa!4v1695701928359!5m2!1sen!2ssa" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
                
                // معلومات المساحة والسعة
                'area_size' => 1200, // 1200 متر مربع
                'max_guests' => 30,
                'bedrooms' => 4,
                'bathrooms' => 6,
                
                // المرافق والخدمات
                'amenities' => json_encode([
                    'pool' => ['مسبح خاص كبير', 'Large private pool'],
                    'pool_kids' => ['مسبح أطفال', 'Kids pool'],
                    'garden' => ['حديقة واسعة', 'Spacious garden'],
                    'bbq' => ['منطقة شواء مجهزة', 'Equipped BBQ area'],
                    'parking' => ['مواقف سيارات خاصة (8 سيارات)', 'Private parking (8 cars)'],
                    'ac' => ['تكييف مركزي', 'Central AC'],
                    'wifi' => ['واي فاي عالي السرعة', 'High-speed WiFi'],
                    'tv' => ['شاشات ذكية في جميع الغرف', 'Smart TVs in all rooms'],
                    'kitchen' => ['مطبخ مجهز بالكامل', 'Fully equipped kitchen'],
                    'majlis' => ['مجلس خارجي', 'Outdoor majlis'],
                    'playground' => ['ملعب أطفال', 'Kids playground'],
                    'football' => ['ملعب كرة قدم صغير', 'Small football field'],
                    'volleyball' => ['ملعب كرة طائرة', 'Volleyball court'],
                    'sound_system' => ['نظام صوتي', 'Sound system'],
                    'security' => ['نظام أمني متكامل', 'Complete security system'],
                    'privacy' => ['خصوصية تامة', 'Complete privacy'],
                    'games_room' => ['غرفة ألعاب', 'Games room'],
                    'billiard' => ['طاولة بلياردو', 'Billiard table'],
                    'ping_pong' => ['طاولة تنس طاولة', 'Ping pong table']
                ]),
                
                // الأماكن القريبة
                'nearby_places' => json_encode([
                    ['name_ar' => 'كورنيش الدمام', 'name_en' => 'Dammam Corniche', 'distance' => '5 كم'],
                    ['name_ar' => 'مجمع الراشد مول', 'name_en' => 'Al Rashid Mall', 'distance' => '3 كم'],
                    ['name_ar' => 'مطار الملك فهد الدولي', 'name_en' => 'King Fahd International Airport', 'distance' => '25 كم'],
                    ['name_ar' => 'جزيرة المرجان', 'name_en' => 'Marjan Island', 'distance' => '7 كم'],
                    ['name_ar' => 'قرية الدولفين الترفيهية', 'name_en' => 'Dolphin Village', 'distance' => '10 كم'],
                    ['name_ar' => 'مستشفى الملك فهد التخصصي', 'name_en' => 'King Fahd Specialist Hospital', 'distance' => '8 كم']
                ]),
                
                // أوقات الدخول والخروج
                'check_in_time' => '15:00',
                'check_out_time' => '13:00',
                
                // القواعد والشروط
                'rules_ar' => '• يُسمح بالدخول من الساعة 3:00 مساءً والخروج حتى الساعة 1:00 ظهراً
• ممنوع التدخين داخل المباني المغلقة
• يجب المحافظة على نظافة المكان
• ممنوع إقامة الحفلات الصاخبة بعد الساعة 12:00 منتصف الليل
• يجب الالتزام بالعدد المحدد للضيوف
• أي أضرار في الممتلكات يتحملها المستأجر
• يجب إيقاف الموسيقى الصاخبة بعد الساعة 11:00 مساءً احتراماً للجيران
• يُطلب دفع تأمين قابل للاسترداد قدره 1000 ريال',
                
                'rules_en' => '• Check-in from 3:00 PM and check-out until 1:00 PM
• No smoking inside closed buildings
• Must maintain cleanliness of the place
• No loud parties after 12:00 midnight
• Must adhere to the specified number of guests
• Any damage to property is the responsibility of the tenant
• Loud music must be stopped after 11:00 PM out of respect for neighbors
• A refundable deposit of 1000 SAR is required',
                
                'whatsapp_number' => '+966501234567',
                
                // التقييم
                'rating' => 4.8,
                'total_reviews' => 127,
                
                // تحديث الأسعار
                'default_day_price' => 1500.00,
                'holiday_day_price' => 2800.00,
                'half_day_price' => 900.00,
                'stay_price' => 2200.00,
            ]);
            
            // حذف الصور القديمة
            ChaletImage::where('chalet_id', $chalet->id)->delete();
            
            // إضافة صور جديدة واقعية
            $images = [
                ['image' => 'https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=800', 'is_main' => true],
                ['image' => 'https://images.unsplash.com/photo-1572120360610-d971b9d7767c?w=800', 'is_main' => false],
                ['image' => 'https://images.unsplash.com/photo-1575517111478-7f6afd0973db?w=800', 'is_main' => false],
                ['image' => 'https://images.unsplash.com/photo-1561753757-d8880c5a3551?w=800', 'is_main' => false],
                ['image' => 'https://images.unsplash.com/photo-1576013551627-0cc20b96c2a7?w=800', 'is_main' => false],
                ['image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800', 'is_main' => false],
                ['image' => 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?w=800', 'is_main' => false],
                ['image' => 'https://images.unsplash.com/photo-1600566753190-17f0baa2a6c3?w=800', 'is_main' => false],
            ];
            
            foreach ($images as $image) {
                ChaletImage::create([
                    'chalet_id' => $chalet->id,
                    'image_path' => $image['image'],
                    'is_main' => $image['is_main'] ?? false
                ]);
            }
            
            echo "تم تحديث بيانات الشاليه بنجاح!\n";
        } else {
            echo "لم يتم العثور على الشاليه\n";
        }
    }
}
