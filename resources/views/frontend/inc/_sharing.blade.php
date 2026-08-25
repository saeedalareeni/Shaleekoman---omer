<div class="dropdown">
    <p class="" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-share-alt"></i> مشاركة
    </p>
    <ul class="dropdown-menu">
        <li>
            <a class="dropdown-item" target="_blank"
                href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('showChalet', $chalet->slug)) }}">
                <i class="fab fa-facebook me-2"></i> Facebook
            </a>
        </li>
        <li>
            <a class="dropdown-item" target="_blank"
                href="https://twitter.com/intent/tweet?url={{ urlencode(route('showChalet', $chalet->slug)) }}">
                <i class="fab fa-twitter me-2"></i> Twitter
            </a>
        </li>
        <li>
            <a class="dropdown-item" target="_blank"
                href="https://wa.me/?text={{ urlencode(route('showChalet', $chalet->slug)) }}">
                <i class="fab fa-whatsapp me-2"></i> WhatsApp
            </a>
        </li>
        <li>
            <a class="dropdown-item" target="_blank"
                href="https://t.me/share/url?url={{ urlencode(route('showChalet', $chalet->slug)) }}">
                <i class="fab fa-telegram me-2"></i> Telegram
            </a>
        </li>
        <li>
            <button class="dropdown-item" onclick="copyToClipboard('{{ route('showChalet', $chalet->slug) }}')">
                <i class="fas fa-copy me-2"></i> نسخ الرابط
            </button>
        </li>
    </ul>
</div>
