<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PagesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('pages')->insert([
            [

                'name_ar' => 'الشروط والأحكام',
                'name_en' => 'Terms and Conditions',
                'slug' => Str::slug('terms-and-conditions'),
                'body_ar' => 'محتوى الشروط والأحكام باللغة العربية.',
                'body_en' => 'Content of terms and conditions in English.',
                'meta_keywords_ar' => 'شروط, أحكام',
                'meta_keywords_en' => 'terms, conditions',
                'meta_description_ar' => 'صفحة الشروط والأحكام للموقع.',
                'meta_description_en' => 'The website terms and conditions page.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
               
                'name_ar' => 'سياسة الخصوصية',
                'name_en' => 'Privacy Policy',
                'slug' => Str::slug('privacy-policy'),
                'body_ar' => '<h2>سياسة الخصوصية</h2>
<p>نحن ملتزمون بحماية خصوصيتك. توضح هذه السياسة كيفية جمع واستخدام وحماية بيانات الموقع الخاصة بك.</p>

<h3>1. جمع البيانات</h3>
<p>نقوم بجمع المعلومات التي تقدمها طواعية عند التسجيل أو إجراء عملية حجز أو التواصل معنا. تشمل هذه المعلومات:
<ul>
<li>الاسم والبريد الإلكتروني</li>
<li>رقم الهاتف</li>
<li>معلومات الحجز والدفع</li>
<li>ملاحظاتك وتعليقاتك</li>
</ul>
</p>

<h3>2. استخدام البيانات</h3>
<p>نستخدم بيانات الموقع لـ:
<ul>
<li>معالجة طلبات الحجز الخاصة بك</li>
<li>إرسال تأكيدات الحجز وإشعارات التحديثات</li>
<li>تحسين تجربة المستخدم</li>
<li>الرد على استفساراتك</li>
</ul>
</p>

<h3>3. حماية البيانات</h3>
<p>نتخذ تدابير أمنية مناسبة لحماية بيانات الموقع من الوصول غير المصرح به والتعديل والحذف.</p>

<h3>4. مشاركة البيانات</h3>
<p>لن نشارك بيانات الموقع مع أطراف ثالثة دون موافقتك، إلا إذا كان ذلك مطلوباً بموجب القانون.</p>

<h3>5. حقوقك</h3>
<p>لديك الحق في الوصول إلى بيانات الموقع الخاصة بك وتصحيحها أو حذفها بناءً على طلبك.</p>

<h3>6. التواصل</h3>
<p>إذا كان لديك أي أسئلة أو مخاوف بشأن سياسة الخصوصية هذه، يرجى التواصل معنا.</p>',
                'body_en' => '<h2>Privacy Policy</h2>
<p>We are committed to protecting your privacy. This policy explains how we collect, use, and protect your website data.</p>

<h3>1. Data Collection</h3>
<p>We collect information that you voluntarily provide when registering, making a booking, or contacting us. This includes:
<ul>
<li>Name and email address</li>
<li>Phone number</li>
<li>Booking and payment information</li>
<li>Your comments and messages</li>
</ul>
</p>

<h3>2. Data Usage</h3>
<p>We use your data for:
<ul>
<li>Processing your booking requests</li>
<li>Sending booking confirmations and updates</li>
<li>Improving user experience</li>
<li>Responding to your inquiries</li>
</ul>
</p>

<h3>3. Data Protection</h3>
<p>We take appropriate security measures to protect your data from unauthorized access, modification, or deletion.</p>

<h3>4. Data Sharing</h3>
<p>We will not share your data with third parties without your consent, unless required by law.</p>

<h3>5. Your Rights</h3>
<p>You have the right to access, correct, or delete your data upon request.</p>

<h3>6. Contact Us</h3>
<p>If you have any questions or concerns about this privacy policy, please contact us.</p>',
                'meta_keywords_ar' => 'خصوصية, بيانات, حماية, سياسة',
                'meta_keywords_en' => 'privacy, data, protection, policy',
                'meta_description_ar' => 'سياسة الخصوصية الخاصة بنا تشرح كيفية جمع واستخدام وحماية بيانات المستخدمين.',
                'meta_description_en' => 'Our privacy policy explains how we collect, use, and protect user data.',
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
