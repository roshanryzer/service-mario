@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Carousel')

@section('content')
{{-- Basic Carousel And Optional Carousel start --}}
<section id="basic-carousel">
    <div class="row">
      <div class="col-12 mt-1 mb-1">
        <div class="alert alert-info">
          <p> <i class="feather icon-info mr-1 align-middle"></i> Nested carousels are not supported.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Basic Example</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                  <li data-target="#carousel-example-generic" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/02.jpg') }}" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/03.jpg') }}" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/01.jpg') }}" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-example-generic" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-example-generic" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Optional captions</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div id="carousel-example-caption" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-example-caption" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-example-caption" data-slide-to="1"></li>
                  <li data-target="#carousel-example-caption" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/04.jpg') }}" alt="First slide">
                    <div class="carousel-caption">
                      <h3>First Slide Label</h3>
                      <p>Donut jujubes I love topping I love sweet. Jujubes I love brownie gummi bears I love donut sweet
                        chocolate. Tart chocolate marshmallow.Tart carrot cake muffin.</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/06.jpg') }}" alt="Second slide">
                    <div class="carousel-caption">
                      <h3>Second Slide Label</h3>
                      <p>Tart macaroon marzipan I love soufflé apple pie wafer. Chocolate bar jelly caramels jujubes
                        chocolate cake gummies. Cupcake cake I love cake danish carrot cake.</p>
                    </div>
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/05.jpg') }}" alt="Third slide">
                    <div class="carousel-caption">
                      <h3>Third Slide Label</h3>
                      <p>Pudding sweet pie gummies. Chocolate bar sweet tiramisu cheesecake chocolate cotton candy pastry
                        muffin. Marshmallow cake powder icing.</p>
                    </div>
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-example-caption" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-example-caption" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Basic Carousel And Optional Carousel start end --}}


  {{-- Carousel Options start --}}
  <section id="carousel-options">
    <div class="row match-height">
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Interval Option</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>The amount of time to delay between automatically cycling an item. If false, carousel will not
                automatically cycle.Options can be passed via data attributes or JavaScript. For data attributes, append
                the option name to <code>data-</code>, as in <code>data-interval=""</code>.</p>

              <div id="carousel-interval" class="carousel slide" data-ride="carousel" data-interval="5000">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-interval" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-interval" data-slide-to="1"></li>
                  <li data-target="#carousel-interval" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/01.jpg') }}" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/03.jpg') }}" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/02.jpg') }}" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-interval" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-interval" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Pause Option</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>If set to <code>"hover"</code>, pauses the cycling of the carousel on <code>mouseenter</code> and resumes
                the cycling of the carousel on <code>mouseleave</code>. If set to <code>null</code>, hovering over the
                carousel won't pause it.</p>
              <div id="carousel-pause" class="carousel slide" data-ride="carousel" data-pause="hover">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-pause" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-pause" data-slide-to="1"></li>
                  <li data-target="#carousel-pause" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/06.jpg') }}" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/04.jpg') }}" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/05.jpg') }}" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-pause" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-pause" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Wrap Option</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>Whether the carousel should cycle continuously or have hard stops. Default: true</p>
              <div id="carousel-wrap" class="carousel slide" data-ride="carousel" data-wrap="false">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-wrap" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-wrap" data-slide-to="1"></li>
                  <li data-target="#carousel-wrap" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/02.jpg') }}" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/04.jpg') }}" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/01.jpg') }}" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-wrap" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-wrap" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Keyboard Option</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>Whether the carousel should react to keyboard events. Default: false</p>
              <div id="carousel-keyboard" class="carousel slide" data-keyboard="true">
                <ol class="carousel-indicators">
                  <li data-target="#carousel-keyboard" data-slide-to="0" class="active"></li>
                  <li data-target="#carousel-keyboard" data-slide-to="1"></li>
                  <li data-target="#carousel-keyboard" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                  <div class="carousel-item active">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/03.jpg') }}" alt="First slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/06.jpg') }}" alt="Second slide">
                  </div>
                  <div class="carousel-item">
                    <img class="img-fluid" src="{{ asset('admin/images/slider/01.jpg') }}" alt="Third slide">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carousel-keyboard" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carousel-keyboard" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Carousel Options end --}}


  {{-- CrossFade Carousel Start --}}
  <section id="carousel-crossfade">
    <div class="row">
      <div class="col-md-6 col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Crossfade</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>
                Add <code>.carousel-fade</code> to your carousel to animate slides with a fade transition instead of a
                slide.
              </p>
              <div id="carouselExampleFade" class="carousel slide carousel-fade" data-ride="carousel">
                <div class="carousel-inner">
                  <div class="carousel-item active">
                    <img src="{{ asset('admin/images/slider/06.jpg') }}" class="img-fluid d-block w-100" alt="cf-img-1">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('admin/images/slider/02.jpg') }}" class="img-fluid d-block w-100" alt="cf-img-2">
                  </div>
                  <div class="carousel-item">
                    <img src="{{ asset('admin/images/slider/05.jpg') }}" class="img-fluid d-block w-100" alt="cf-img-3">
                  </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="sr-only">Next</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- CrossFade Carousel End --}}
  @endsection
