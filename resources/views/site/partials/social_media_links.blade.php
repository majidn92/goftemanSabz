<ul class="d-flex social-box px-4 mb-1" style="direction: ltr;list-style-type: none;">
    {{-- <li>
        <a class="facebook social-btn" href="" target="_blank"><i class="icon-facebook"></i></a>
    </li> --}}
    <li>
        <a class="twitter social-btn" href="" target="_blank"><i class="icon-twitter"></i></a>
    </li>
    {{-- <li>
        <a class="instagram social-btn" href="" target="_blank"><i class="icon-instagram"></i></a>
    </li> --}}
    <li>
        <a class="linkedin social-btn" href="" target="_blank"><i class="icon-linkedin"></i></a>
    </li>
    <li>
        <a class="telegram social-btn" href="" target="_blank"><i class="icon-telegram"></i></a>
    </li>
    <li>
        <a class="whatsapp social-btn" href="https://api.whatsapp.com/send?text={{ route('article.detail', ['id' => $post->slug]) }}" target="_blank"><i class="icon-whatsapp"></i></a>
    </li>
    {{-- <li>
        <a class="rss social-btn" href=""><i class="icon-rss"></i></a>
    </li> --}}
    <li>
        <a class="print social-btn" href=""><i class="icon-print"></i></a>
    </li>
</ul>
