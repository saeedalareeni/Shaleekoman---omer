<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question_ar' => 'كيف يمكنني حجز شاليه؟',
                'question_en' => 'How can I book a chalet?',
                'answer_ar' => 'يمكنك حجز شاليه بسهولة من خلال البحث عن الشاليه المناسب، اختيار التواريخ المطلوبة، ثم إكمال عملية الحجز والدفع عبر الموقع.',
                'answer_en' => 'You can easily book a chalet by searching for the suitable chalet, selecting the required dates, then completing the booking and payment process through the website.',
                'category' => 'booking',
                'order' => 1,
            ],
            [
                'question_ar' => 'ما هي طرق الدفع المتاحة؟',
                'question_en' => 'What payment methods are available?',
                'answer_ar' => 'نوفر عدة طرق دفع آمنة تشمل البطاقات الائتمانية، البطاقات المصرفية، والتحويل البنكي المباشر.',
                'answer_en' => 'We provide several secure payment methods including credit cards, debit cards, and direct bank transfer.',
                'category' => 'payment',
                'order' => 2,
            ],
            [
                'question_ar' => 'هل يمكنني إلغاء الحجز؟',
                'question_en' => 'Can I cancel my booking?',
                'answer_ar' => 'نعم، يمكنك إلغاء الحجز وفقاً لسياسة الإلغاء الخاصة بكل شاليه. يرجى مراجعة شروط الإلغاء قبل إتمام الحجز.',
                'answer_en' => 'Yes, you can cancel your booking according to each chalet\'s cancellation policy. Please review the cancellation terms before completing your booking.',
                'category' => 'cancellation',
                'order' => 3,
            ],
            [
                'question_ar' => 'كيف يمكنني التواصل مع المالك؟',
                'question_en' => 'How can I contact the owner?',
                'answer_ar' => 'بعد إتمام الحجز، ستحصل على معلومات الاتصال بالمالك. كما يمكنك التواصل معه من خلال نظام الرسائل في حسابك.',
                'answer_en' => 'After completing the booking, you will receive the owner\'s contact information. You can also communicate with them through the messaging system in your account.',
                'category' => 'owner',
                'order' => 4,
            ],
            [
                'question_ar' => 'هل الموقع آمن للدفع الإلكتروني؟',
                'question_en' => 'Is the site secure for online payment?',
                'answer_ar' => 'نعم، نستخدم أحدث تقنيات التشفير والحماية لضمان أمان جميع المعاملات المالية على الموقع.',
                'answer_en' => 'Yes, we use the latest encryption and security technologies to ensure the safety of all financial transactions on the site.',
                'category' => 'payment',
                'order' => 5,
            ],
            [
                'question_ar' => 'كيف يمكنني تسجيل شاليهي على الموقع؟',
                'question_en' => 'How can I register my chalet on the site?',
                'answer_ar' => 'يمكنك التسجيل كمالك من خلال صفحة التسجيل الخاصة بالملاك، ثم إضافة تفاصيل شاليهك وصوره.',
                'answer_en' => 'You can register as an owner through the owner registration page, then add your chalet details and photos.',
                'category' => 'owner',
                'order' => 6,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
