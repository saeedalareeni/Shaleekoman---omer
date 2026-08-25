<?php

namespace Database\Seeders;

use App\Models\Term;
use Illuminate\Database\Seeder;

class TermsSeeder extends Seeder
{
    public function run()
    {
        $terms = [
            [
                'title_ar' => 'الشروط والأحكام العامة',
                'title_en' => 'General Terms and Conditions',
                'content_ar' => '<h3>1. القبول بالشروط</h3>
                <p>باستخدامك لموقع شاليك عُمان، فإنك توافق على الالتزام بهذه الشروط والأحكام. إذا كنت لا توافق على أي من هذه الشروط، يرجى عدم استخدام الموقع.</p>
                
                <h3>2. التسجيل والحساب</h3>
                <ul>
                <li>يجب أن يكون عمرك 18 عاماً أو أكثر للتسجيل</li>
                <li>يجب تقديم معلومات صحيحة ودقيقة</li>
                <li>أنت مسؤول عن الحفاظ على سرية كلمة المرور</li>
                <li>أنت مسؤول عن جميع الأنشطة التي تحدث تحت حسابك</li>
                </ul>
                
                <h3>3. استخدام الخدمة</h3>
                <p>يجب استخدام الموقع للأغراض المشروعة فقط وبطريقة لا تنتهك حقوق الآخرين أو تقيد أو تمنع استخدامهم للموقع.</p>
                
                <h3>4. الحجوزات</h3>
                <ul>
                <li>جميع الحجوزات تخضع للتوافر والتأكيد</li>
                <li>يجب دفع المبلغ المطلوب لتأكيد الحجز</li>
                <li>نحتفظ بالحق في رفض أو إلغاء أي حجز</li>
                </ul>
                
                <h3>5. المدفوعات</h3>
                <p>جميع المدفوعات آمنة ومشفرة. نقبل البطاقات الائتمانية والتحويل البنكي. الأسعار شاملة الضرائب ما لم يُذكر خلاف ذلك.</p>
                
                <h3>6. الإلغاء والاسترداد</h3>
                <p>تخضع سياسة الإلغاء والاسترداد للشروط المحددة لكل شاليه. يرجى مراجعة شروط الإلغاء قبل إتمام الحجز.</p>',
                
                'content_en' => '<h3>1. Acceptance of Terms</h3>
                <p>By using Shaleek Oman website, you agree to comply with these terms and conditions. If you do not agree to any of these terms, please do not use the website.</p>
                
                <h3>2. Registration and Account</h3>
                <ul>
                <li>You must be 18 years or older to register</li>
                <li>You must provide accurate and truthful information</li>
                <li>You are responsible for maintaining password confidentiality</li>
                <li>You are responsible for all activities under your account</li>
                </ul>
                
                <h3>3. Use of Service</h3>
                <p>The website must be used for lawful purposes only and in a way that does not infringe the rights of others or restrict or prevent their use of the website.</p>
                
                <h3>4. Bookings</h3>
                <ul>
                <li>All bookings are subject to availability and confirmation</li>
                <li>Payment must be made to confirm booking</li>
                <li>We reserve the right to refuse or cancel any booking</li>
                </ul>
                
                <h3>5. Payments</h3>
                <p>All payments are secure and encrypted. We accept credit cards and bank transfers. Prices include taxes unless otherwise stated.</p>
                
                <h3>6. Cancellation and Refund</h3>
                <p>Cancellation and refund policy is subject to the specific terms of each chalet. Please review cancellation terms before completing your booking.</p>',
                
                'type' => 'terms',
                'order' => 1,
                'is_active' => true,
                'effective_date' => now(),
                'version' => '1.0'
            ],
            [
                'title_ar' => 'سياسة الخصوصية',
                'title_en' => 'Privacy Policy',
                'content_ar' => '<h3>1. المعلومات التي نجمعها</h3>
                <p>نجمع المعلومات التالية:</p>
                <ul>
                <li>المعلومات الشخصية (الاسم، البريد الإلكتروني، رقم الهاتف)</li>
                <li>معلومات الحجز والدفع</li>
                <li>معلومات الاستخدام وملفات تعريف الارتباط</li>
                </ul>
                
                <h3>2. كيف نستخدم معلوماتك</h3>
                <ul>
                <li>لمعالجة الحجوزات والمدفوعات</li>
                <li>للتواصل معك بخصوص حجوزاتك</li>
                <li>لتحسين خدماتنا</li>
                <li>لإرسال العروض والتحديثات (بموافقتك)</li>
                </ul>
                
                <h3>3. حماية المعلومات</h3>
                <p>نستخدم تدابير أمنية متقدمة لحماية معلوماتك الشخصية من الوصول غير المصرح به أو الكشف عنها.</p>
                
                <h3>4. مشاركة المعلومات</h3>
                <p>لا نبيع أو نؤجر معلوماتك الشخصية لأطراف ثالثة. قد نشارك معلوماتك مع مقدمي الخدمات الموثوقين لمعالجة المدفوعات وتقديم الخدمات.</p>',
                
                'content_en' => '<h3>1. Information We Collect</h3>
                <p>We collect the following information:</p>
                <ul>
                <li>Personal information (name, email, phone number)</li>
                <li>Booking and payment information</li>
                <li>Usage information and cookies</li>
                </ul>
                
                <h3>2. How We Use Your Information</h3>
                <ul>
                <li>To process bookings and payments</li>
                <li>To communicate with you about your bookings</li>
                <li>To improve our services</li>
                <li>To send offers and updates (with your consent)</li>
                </ul>
                
                <h3>3. Information Protection</h3>
                <p>We use advanced security measures to protect your personal information from unauthorized access or disclosure.</p>
                
                <h3>4. Information Sharing</h3>
                <p>We do not sell or rent your personal information to third parties. We may share your information with trusted service providers to process payments and provide services.</p>',
                
                'type' => 'privacy',
                'order' => 1,
                'is_active' => true,
                'effective_date' => now(),
                'version' => '1.0'
            ],
            [
                'title_ar' => 'سياسة الاسترداد والإلغاء',
                'title_en' => 'Refund and Cancellation Policy',
                'content_ar' => '<h3>شروط الإلغاء</h3>
                <ul>
                <li><strong>الإلغاء قبل 48 ساعة:</strong> استرداد كامل المبلغ</li>
                <li><strong>الإلغاء قبل 24 ساعة:</strong> استرداد 50% من المبلغ</li>
                <li><strong>الإلغاء في نفس اليوم:</strong> لا يوجد استرداد</li>
                </ul>
                
                <h3>الحالات الاستثنائية</h3>
                <p>قد نقدم استرداداً كاملاً في الحالات التالية:</p>
                <ul>
                <li>إذا كان الشاليه غير متاح بسبب ظروف خارجة عن إرادتنا</li>
                <li>إذا كانت المرافق المعلن عنها غير متوفرة</li>
                <li>في حالة الظروف القاهرة (كوارث طبيعية، أوامر حكومية)</li>
                </ul>
                
                <h3>عملية الاسترداد</h3>
                <p>يتم معالجة طلبات الاسترداد خلال 5-7 أيام عمل. سيتم إرجاع المبلغ إلى نفس طريقة الدفع المستخدمة.</p>',
                
                'content_en' => '<h3>Cancellation Terms</h3>
                <ul>
                <li><strong>Cancellation 48 hours before:</strong> Full refund</li>
                <li><strong>Cancellation 24 hours before:</strong> 50% refund</li>
                <li><strong>Same day cancellation:</strong> No refund</li>
                </ul>
                
                <h3>Exceptional Cases</h3>
                <p>We may provide a full refund in the following cases:</p>
                <ul>
                <li>If the chalet is unavailable due to circumstances beyond our control</li>
                <li>If advertised facilities are not available</li>
                <li>In case of force majeure (natural disasters, government orders)</li>
                </ul>
                
                <h3>Refund Process</h3>
                <p>Refund requests are processed within 5-7 business days. The amount will be refunded to the same payment method used.</p>',
                
                'type' => 'refund',
                'order' => 1,
                'is_active' => true,
                'effective_date' => now(),
                'version' => '1.0'
            ]
        ];

        foreach ($terms as $term) {
            Term::create($term);
        }
    }
}
