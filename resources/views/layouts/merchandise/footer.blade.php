<footer id="footerStore">
    <div class="wrapper">
        <div class="information">
            <img src="{{ url('./assets/img/icons/logo-blues.png') }}" alt="">
            <p>+6281-8765-0634</p>
            <p>bluesclues@gmail.com</p>
        </div>
        <div class="links">
            <h5>Quick Links</h5>
            <div class="nav-link">
                <a href="" class="link-item">Home</a>
                <a href="" class="link-item">About</a>
                <a href="" class="link-item">Videos</a>
                <a href="" class="link-item">Musics</a>
                <a href="" class="link-item">Event</a>
                <a href="" class="link-item">News & Articles</a>
            </div>
        </div>
        <div class="contact">
            <h5>Get In The Know</h5>
            <form method="post">
                @csrf
                <div class="mb-3">
                    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                        placeholder="Enter Email">
                </div>
                <div class="checkbox">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">
                        <p>
                            I agree to receive personalized updates and marketing messages about ONE OK ROCK based
                            on my information, interests, activities, website visits and device data.
                        </p>
                        <p>
                            For more information about how we use your personal information, please see our Privacy
                            Policy.
                        </p>
                    </label>
                </div>
                <button type="submit" class="btn btn-primary">Subscribe</button>
            </form>
        </div>
    </div>
</footer>

{{-- <footer>
    <div class="f-store">
        <div class="row">
            <div class="col-md-2">
                <h5>Company Info</h5>
                <ul>
                    <li>About Us</li>
                    <li>Latest Post</li>
                    <li>Contact Us</li>
                    <li>Shop</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5>Help Links</h5>
                <ul>
                    <li>Tracking</li>
                    <li>Order Status</li>
                    <li>Delivery</li>
                    <li>Shipping Info</li>
                    <li>FAQ</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h5>Useful Links</h5>
                <ul>
                    <li>Special Offers</li>
                    <li>Gift Cards</li>
                    <li>Advesting</li>
                    <li>Terms of Use</li>
                </ul>
            </div>
            <div class="col-md-6">
                <h5>Get In The Know</h5>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3 checkbox">
                        <input type="checkbox" class="form-check-input" id="exampleCheck1">
                        <label class="form-check-label" for="exampleCheck1">
                            <p>
                                I agree to receive personalized updates and marketing messages about ONE OK ROCK based
                                on my information, interests, activities, website visits and device data.
                            </p>
                            <p>
                                For more information about how we use your personal information, please see our Privacy
                                Policy.
                            </p>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary">Subscribe</button>
                </form>
            </div>
        </div>
        <hr>
        <div class="ftr">
            <div>
                <p class="cpy">&#169; 2023 BluesClues eCommerce</p>
                <p>Privacy Policy Terms & Conditions</p>
            </div>
            <div class="f-icon">
                <a href="#"><img src="{{ url('./assets/img/icons/facebook-b.svg') }}" alt=""></a>
                <a href="#"><img src="{{ url('./assets/img/icons/instagram-b.svg') }}" alt=""></a>
                <a href="#"><img src="{{ url('./assets/img/icons/youtube-b.svg') }}" alt=""></a>
                <a href="#"><img src="{{ url('./assets/img/icons/Spotify-b.svg') }}" alt=""></a>
                <a href="#"><img src="{{ url('./assets/img/icons/apple-b.svg') }}" alt=""></a>

            </div>
        </div>


    </div>
</footer> --}}
