<section class="main-content-wrapper section_padding_100">
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-9">
                <!-- Gazette Welcome Post -->
                <div class="gazette-welcome-post">
                    <!-- Post Tag -->
                    <div class="gazette-post-tag">
                        <a href="#">Politices</a>
                    </div>
                    <h2 class="font-pt">What's behind the world obsession with gems?</h2>
                    <p class="gazette-post-date">March 29, 2016</p>
                    <!-- Post Thumbnail -->
                    <div class="blog-post-thumbnail my-5">
                        <img src="{{asset('assets/frontend/img/blog-img/1.jpg')}}" alt="post-thumb">
                    </div>
                    <!-- Post Excerpt -->
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ultrices egestas nunc, quis venenatis orci tincidunt id. Fusce commodo blandit eleifend. Nullam viverra tincidunt dolor, at pulvinar dui. Nullam at risus ut ipsum viverra posuere. Aliquam quis convallis enim. Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. Aliquam finibus nulla quam, a iaculis justo finibus non. Suspendisse in fermentum nunc. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ultrices egestas nunc, quis venenatis orci tincidunt id. Fusce commodo blandit eleifend.</p>
                    <!-- Reading More -->
                    <div class="post-continue-reading-share d-sm-flex align-items-center justify-content-between mt-30">
                        <div class="post-continue-btn">
                            <a href="#" class="font-pt">Continue Reading <i class="fa fa-chevron-right" aria-hidden="true"></i></a>
                        </div>
                        <div class="post-share-btn-group">
                            <a href="#"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-linkedin" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>

                <div class="gazette-todays-post section_padding_100_50">
                    <div class="gazette-heading">
                        <h4>today’s most popular</h4>
                    </div>
                    <!-- Single Today Post -->
                    <div class="gazette-single-todays-post d-md-flex align-items-start mb-50">
                        <div class="todays-post-thumb">
                            <img src="{{asset('assets/frontend/img/blog-img/2.jpg')}}" alt="">
                        </div>
                        <div class="todays-post-content">
                            <!-- Post Tag -->
                            <div class="gazette-post-tag">
                                <a href="#">News</a>
                            </div>
                            <h3><a href="#" class="font-pt mb-2">$250-million mansion is most expensive</a></h3>
                            <span class="gazette-post-date mb-2">March 29, 2016</span>
                            <a href="#" class="post-total-comments">3 Comments</a>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Suspendisse ultrices egestas nunc, quis venenatis orci tincidunt id. Fusce commodo blandit eleifend. Nullam viverra tincidunt dolor, at pulvinar dui. Nullam at risus ut ipsum viverra posuere.</p>
                        </div>
                    </div>
                    <!-- Single Today Post -->
                    <div class="gazette-single-todays-post d-md-flex align-items-start mb-50">
                        <div class="todays-post-thumb">
                            <img src="{{asset('assets/frontend/img/blog-img/3.jpg')}}" alt="">
                        </div>
                        <div class="todays-post-content">
                            <!-- Post Tag -->
                            <div class="gazette-post-tag">
                                <a href="#">Life</a>
                            </div>
                            <h3><a href="#" class="font-pt mb-2">Homeless man steals $350,000 </a></h3>
                            <p class="gazette-post-date mb-2">March 29, 2016</p>
                            <a href="#" class="post-total-comments">3 Comments</a>
                            <p>Aliquam quis convallis enim. Nunc pulvinar molestie sem id blandit. Nunc venenatis interdum mollis. Aliquam finibus nulla quam, a iaculis justo finibus non. Suspendisse in fermentum nunc.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-3 col-md-6">
                <div class="sidebar-area">
                    <!-- Breaking News Widget -->
                    <div class="breaking-news-widget">
                        <div class="widget-title">
                            <h5>breaking news</h5>
                        </div>
                        @foreach($breakingNews->shuffle()->take(2) as $news)
                            <div class="single-breaking-news-widget">
                                <img class="img-fluid img-thumbnail" src="{{asset('assets/img/' . $news->photo->path)}}" alt="">
                                <div class="breakingnews-title">
                                    <p>breaking news</p>
                                </div>
                                <div class="breaking-news-heading gradient-background-overlay">
                                    <h5 class="font-pt">{{$news->title}}</h5>
                                </div>
                            </div>
                        @endforeach

                    </div>

                    <!-- Don't Miss Widget -->
                    <div class="donnot-miss-widget">
                        <div class="widget-title">
                            <h5>Don't miss</h5>
                        </div>
                        <!-- Single Don't Miss Post -->
                        <div class="single-dont-miss-post d-flex mb-30">
                            <div class="dont-miss-post-thumb">
                                <img src="{{asset('assets/frontend/img/blog-img/dm-1.jpg')}}" alt="">
                            </div>
                            <div class="dont-miss-post-content">
                                <a href="#" class="font-pt">EU council reunites</a>
                                <span>Nov 29, 2017</span>
                            </div>
                        </div>
                        <!-- Single Don't Miss Post -->
                        <div class="single-dont-miss-post d-flex mb-30">
                            <div class="dont-miss-post-thumb">
                                <img src="{{asset('assets/frontend/img/blog-img/dm-2.jpg')}}" alt="">
                            </div>
                            <div class="dont-miss-post-content">
                                <a href="#" class="font-pt">A new way to travel the world</a>
                                <span>March 29, 2016</span>
                            </div>
                        </div>
                        <!-- Single Don't Miss Post -->
                        <div class="single-dont-miss-post d-flex mb-30">
                            <div class="dont-miss-post-thumb">
                                <img src="img/blog-img/dm-3.jpg" alt="">
                            </div>
                            <div class="dont-miss-post-content">
                                <a href="#" class="font-pt">Why choose a bank?</a>
                                <span>March 29, 2016</span>
                            </div>
                        </div>
                    </div>
                    <!-- Advert Widget -->
                    <div class="advert-widget">
                        <div class="widget-title">
                            <h5>Advert</h5>
                        </div>
                        <div class="advert-thumb mb-30">
                            <a href="#"><img src="{{asset('assets/frontend/img/bg-img/add.png')}}" alt=""></a>
                        </div>
                    </div>
                    <!-- Subscribe Widget -->
                    <div class="subscribe-widget">
                        <div class="widget-title">
                            <h5>subscribe</h5>
                        </div>
                        <div class="subscribe-form">
                            <form action="#">
                                <input type="email" name="email" id="subs_email" placeholder="Your Email">
                                <button type="submit">subscribe</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Main Content Area End -->

    <!-- Catagory Posts Area Start -->
    <div class="gazette-catagory-posts-area">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4">
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <div class="single-catagory-post-thumb mb-15">
                            <img src="{{asset('assets/frontend/img/blog-img/12.jpg')}}" alt="">
                        </div>
                        <!-- Post Tag -->
                        <div class="gazette-post-tag">
                            <a href="#">Video</a>
                        </div>
                        <h5><a href="#" class="font-pt">Save the eniroment with this step</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <h5><a href="#" class="font-pt">Protest to be anounced in January</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <h5><a href="#" class="font-pt">10 Bills that the Congress in voting</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <h5><a href="#" class="font-pt">The narcissism of Donald Trump</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <!-- Single Catagory Post -->
                            <div class="gazette-single-catagory-post">
                                <div class="single-catagory-post-thumb mb-15">
                                    <img src="{{asset('assets/frontend/img/blog-img/14.jpg')}}" alt="">
                                </div>
                                <!-- Post Tag -->
                                <div class="gazette-post-tag">
                                    <a href="#">Others</a>
                                </div>
                                <h5><a href="#" class="font-pt">11 hottest toys for this holiday season</a></h5>
                                <span>Nov 29, 2017</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Single Catagory Post -->
                            <div class="gazette-single-catagory-post">
                                <div class="single-catagory-post-thumb mb-15">
                                    <img src="{{asset('assets/frontend/img/blog-img/15.jpg')}}" alt="">
                                </div>
                                <!-- Post Tag -->
                                <div class="gazette-post-tag">
                                    <a href="#">Video</a>
                                </div>
                                <h5><a href="#" class="font-pt">Get this good feeling about life</a></h5>
                                <span>Nov 29, 2017</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Single Catagory Post -->
                            <div class="gazette-single-catagory-post">
                                <div class="single-catagory-post-thumb mb-15">
                                    <img src="{{asset('assets/frontend/img/blog-img/16.jpg')}}" alt="">
                                </div>
                                <!-- Post Tag -->
                                <div class="gazette-post-tag">
                                    <a href="#">Interview</a>
                                </div>
                                <h5><a href="#" class="font-pt">Get this good feeling about life</a></h5>
                                <span>Nov 29, 2017</span>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <!-- Single Catagory Post -->
                            <div class="gazette-single-catagory-post">
                                <div class="single-catagory-post-thumb mb-15">
                                    <img src="{{asset('assets/frontend/img/blog-img/17.jpg')}}" alt="">
                                </div>
                                <!-- Post Tag -->
                                <div class="gazette-post-tag">
                                    <a href="#">Video</a>
                                </div>
                                <h5><a href="#" class="font-pt">11 hottest toys for this holiday season</a></h5>
                                <span>Nov 29, 2017</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <div class="single-catagory-post-thumb mb-15">
                            <img src="{{asset('assets/frontend/img/blog-img/13.jpg')}}" alt="">
                        </div>
                        <!-- Post Tag -->
                        <div class="gazette-post-tag">
                            <a href="#">Video</a>
                        </div>
                        <h5><a href="#" class="font-pt">10 Bills that the Congress in voting</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <h5><a href="#" class="font-pt">Blair can't save Britain from Brexit</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <h5><a href="#" class="font-pt">Save the eniroment with this step</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                    <!-- Single Catagory Post -->
                    <div class="gazette-single-catagory-post">
                        <h5><a href="#" class="font-pt">Protest to be anounced in January</a></h5>
                        <span>Nov 29, 2017</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
