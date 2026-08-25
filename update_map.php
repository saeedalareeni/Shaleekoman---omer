<?php
require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\Chalet;

$chalet = Chalet::where('slug', 'chalet-10-1758984757593')->first();

if ($chalet) {
    // تحديث رابط الخريطة بخريطة حقيقية للدمام
    $chalet->map_link = '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d114584.73684395!2d50.0134!3d26.3927!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3e361d3f0641c38f%3A0x8f4e3c20e2b10432!2sDammam%20Saudi%20Arabia!5e0!3m2!1sen!2ssa!4v1698321456789!5m2!1sen!2ssa" width="100%" height="450" style="border:0; border-radius: 12px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
    
    $chalet->save();
    
    echo "تم تحديث رابط الخريطة بنجاح!\n";
    echo "الرابط الجديد:\n";
    echo $chalet->map_link . "\n";
} else {
    echo "لم يتم العثور على الشاليه\n";
}
