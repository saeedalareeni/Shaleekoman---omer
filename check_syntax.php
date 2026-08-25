<?php
$file = __DIR__ . '/resources/views/owners/dashboard.blade.php';
$content = file_get_contents($file);

// عد الأقواس
$open_parentheses = substr_count($content, '(');
$close_parentheses = substr_count($content, ')');
$open_braces = substr_count($content, '{');
$close_braces = substr_count($content, '}');
$open_brackets = substr_count($content, '[');
$close_brackets = substr_count($content, ']');

echo "File analysis:\n";
echo "Open parentheses ( : $open_parentheses\n";
echo "Close parentheses ) : $close_parentheses\n";
echo "Difference: " . ($open_parentheses - $close_parentheses) . "\n\n";

echo "Open braces { : $open_braces\n";
echo "Close braces } : $close_braces\n";
echo "Difference: " . ($open_braces - $close_braces) . "\n\n";

echo "Open brackets [ : $open_brackets\n";
echo "Close brackets ] : $close_brackets\n";
echo "Difference: " . ($open_brackets - $close_brackets) . "\n\n";

// البحث عن أقواس زائدة
$lines = explode("\n", $content);
$paren_count = 0;
$brace_count = 0;

foreach ($lines as $line_num => $line) {
    $line_num++; // 1-indexed
    
    // عد الأقواس في كل سطر
    $open_in_line = substr_count($line, '(');
    $close_in_line = substr_count($line, ')');
    $paren_count += $open_in_line - $close_in_line;
    
    if ($close_in_line > $open_in_line && $paren_count < 0) {
        echo "Possible extra closing parenthesis at line $line_num: " . trim($line) . "\n";
    }
    
    // عد الأقواس المعقوفة
    $open_brace_in_line = substr_count($line, '{');
    $close_brace_in_line = substr_count($line, '}');
    $brace_count += $open_brace_in_line - $close_brace_in_line;
    
    if ($close_brace_in_line > $open_brace_in_line && $brace_count < 0) {
        echo "Possible extra closing brace at line $line_num: " . trim($line) . "\n";
    }
}
