<footer class="footer">
    <div class="footer__left">
        <ul class="footer__list">
            <li class="footer__heading">
                <span>OUR SERVICES</span>
            </li>
            <li class="footer__item">
                <a href="#" target="_blank">Forum</a>
            </li>
        </ul>

        <ul class="footer__list">
            <li class="footer__heading">
                <span>SUPPORT</span>
            </li>
            <li class="footer__item">
                <a href="#" target="_blank">FAQ</a>
            </li>
            <li class="footer__item">
                <a href="{{ route('policy.show') }}" target="_blank">Private Policy</a>
            </li>
        </ul>
    </div>

    <div class="footer__right">
        <ul class="footer__list">
            <li class="footer__heading">
                <span>OUR SERVICES</span>
            </li>
            <li class="footer__item">
                <span class="d-flex justify-content-center">
                    <svg class="footer__list__icon mr-4 icon-social-media" data-social-href="https://www.facebook.com/">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-facebook2')}}"></use>
                    </svg>
                    <svg class="footer__list__icon icon-social-media" data-social-href="https://www.instagram.com/tutorspaceusc/">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-instagram')}}"></use>
                    </svg>
                </span>
            </li>
        </ul>

        <ul class="footer__list mr-0">
            <li class="footer__heading">
                <span>CONTACT US</span>
            </li>
            <li class="footer__item">
                <a href="mailto:tutorspaceusc@gmail.com" class="contact-email">
                    <svg class="footer__list__icon">
                        <use xlink:href="{{asset('assets/sprite.svg#icon-mail')}}"></use>
                    </svg>
                    <span>tutorspaceusc@gmail.com</span>
                </a>
            </li>
        </ul>

        <div class="footer__subscribe">
            <p class="footer__heading">SUBSCRIBE</p>
            <form class="form" method="POST" action="{{ route('subscription.store') }}" id="footer__form-subscribe">
                @csrf
                <svg class="input-icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-mail')}}"></use>
                </svg>
                <input type="email" class="form-control" placeholder="Enter your email" name="email">
                <button class="btn btn-subscribe" type="submit">Subscribe</button>
            </form>
        </div>
    </div>

</footer>

<footer class="footer-sm">
    <ul class="footer-sm__list">
        <li class="footer-sm__heading">
            <span>OUR SERVICES</span>
        </li>
        <li class="footer-sm__item">
            <a href="#" target="_blank">Forum</a>
        </li>
    </ul>

    <ul class="footer-sm__list">
        <li class="footer-sm__heading">
            <span>SUPPORT</span>
        </li>
        <li class="footer-sm__item">
            <a href="#" target="_blank">FAQ</a>
        </li>
        <li class="footer-sm__item">
            <a href="{{ route('policy.show') }}" target="_blank">Private Policy</a>
        </li>
    </ul>

    <ul class="footer-sm__list">
        <li class="footer-sm__heading">
            <span>OUR SERVICES</span>
        </li>
        <li class="footer-sm__item">
            <span class="d-flex justify-content-center">
                <svg class="footer-sm__list__icon mr-4 icon-social-media" data-social-href="https://www.facebook.com/">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-facebook2')}}"></use>
                </svg>
                <svg class="footer-sm__list__icon icon-social-media" data-social-href="https://www.instagram.com/tutorspaceusc/">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-instagram')}}"></use>
                </svg>
            </span>
        </li>
    </ul>

    <ul class="footer-sm__list mr-0">
        <li class="footer-sm__heading">
            <span>CONTACT US</span>
        </li>
        <li class="footer-sm__item">
            <a href="mailto:tutorspaceusc@gmail.com" class="contact-email">
                <svg class="footer-sm__list__icon">
                    <use xlink:href="{{asset('assets/sprite.svg#icon-mail')}}"></use>
                </svg>
                tutorspaceusc@gmail.com
            </a>
        </li>
    </ul>

    <div class="footer-sm__subscribe">
        <p class="footer-sm__heading">SUBSCRIBE</p>
        <form class="form" method="POST" action="{{ route('subscription.store') }}">
            <svg class="input-icon">
                <use xlink:href="{{asset('assets/sprite.svg#icon-mail')}}"></use>
            </svg>
            <input type="email" class="form-control" placeholder="Enter your email">
            <button class="btn btn-subscribe" type="submit">Subscribe</button>
        </form>
    </div>

</footer>
