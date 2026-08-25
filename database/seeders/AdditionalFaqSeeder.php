<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class AdditionalFaqSeeder extends Seeder
{
    public function run()
    {
        $faqs = [
            [
                'question_ar' => 'ما هي أوقات تسجيل الدخول والخروج؟',
                'question_en' => 'What are the check-in and check-out times?',
                'answer_ar' => 'عادة ما يكون وقت تسجيل الدخول في الساعة 2:00 مساءً ووقت الخروج في الساعة 12:00 ظهراً. ولكن قد تختلف هذه الأوقات حسب كل شاليه، يرجى التحقق من تفاصيل الشاليه.',
                'answer_en' => 'Usually check-in time is at 2:00 PM and check-out time is at 12:00 PM. However, these times may vary by chalet, please check the chalet details.',
                'category' => 'booking',
                'order' => 7,
            ],
            [
                'question_ar' => 'هل يمكنني إحضار حيوانات أليفة؟',
                'question_en' => 'Can I bring pets?',
                'answer_ar' => 'سياسة الحيوانات الأليفة تختلف من شاليه لآخر. بعض الشاليهات تسمح بالحيوانات الأليفة والبعض الآخر لا يسمح. يرجى التحقق من تفاصيل الشاليه قبل الحجز.',
                'answer_en' => 'Pet policy varies from chalet to chalet. Some chalets allow pets while others do not. Please check the chalet details before booking.',
                'category' => 'general',
                'order' => 8,
            ],
            [
                'question_ar' => 'كيف أحصل على فاتورة الحجز؟',
                'question_en' => 'How do I get my booking invoice?',
                'answer_ar' => 'ستحصل على فاتورة الحجز عبر البريد الإلكتروني بعد إتمام عملية الدفع. كما يمكنك تحميل الفاتورة من حسابك في أي وقت.',
                'answer_en' => 'You will receive the booking invoice via email after completing the payment. You can also download the invoice from your account at any time.',
                'category' => 'payment',
                'order' => 9,
            ],
            [
                'question_ar' => 'هل هناك رسوم إضافية؟',
                'question_en' => 'Are there any additional fees?',
                'answer_ar' => 'قد تكون هناك رسوم إضافية مثل رسوم التنظيف أو التأمين حسب كل شاليه. جميع الرسوم ستكون واضحة قبل إتمام الحجز.',
                'answer_en' => 'There may be additional fees such as cleaning or security deposit depending on each chalet. All fees will be clear before completing the booking.',
                'category' => 'payment',
                'order' => 10,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::create($faq);
        }
    }
}
