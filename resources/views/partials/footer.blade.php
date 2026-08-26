<footer class="footer">
    <div class="footer-inner">
        <div class="footer-col">
            <div class="footer-col-title">Fragrances</div>
            <ul>
                <li><a href="{{ route('fragrances.index') }}">Fragrances</a></li>
                <li><a href="{{ route('brands.index') }}">Brands</a></li>
                <li><a href="{{ route('notes.index') }}">Notes</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Privacy Policy</div>
            <ul>
                <li><a href="#">Terms and Conditions</a></li>
                <li><a href="#">Cookies Policy</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Contact</div>
            <p>Parfum.in@gmail.com</p>
        </div>
        <div class="footer-col">
            <div class="footer-col-title">Follow us at</div>
            <a href="#" class="footer-instagram" title="Instagram">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                    <circle cx="12" cy="12" r="4"/>
                    <circle cx="17.5" cy="6.5" r="0.8" fill="currentColor"/>
                </svg>
            </a>
        </div>
    </div>
    <div class="footer-bottom">
        <span class="footer-logo">PARFUM.IN</span>
        <span class="footer-bottom-text">© {{ date('Y') }} Parfum.in. All rights reserved.</span>
    </div>
</footer>
