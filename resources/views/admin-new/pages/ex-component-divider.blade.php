@extends('admin/layouts/contentLayoutMaster')

@section('title', 'Divider')

@section('content')
{{-- Default Divider Starts --}}
<section id="default-divider">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Default</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>You can add a line to divide your section using <code>&lt;hr&gt;</code></p>
              <p>
                Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
                consequat.
                Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.
                Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est
                laborum.
              </p>
              <hr>
              <p>
                Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et
                dolore magna aliqua.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Default Divider Ends --}}
  {{-- Basic Divider Starts --}}
  <section id="basic-divider">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Text</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>Use class <code>.divider</code> as wrapper for <code>.divider-text</code> to create a divider text</p>
              <div class="divider">
                <div class="divider-text">My Text</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Basic Divider Ends --}}
  {{-- Divider Text Position Starts --}}
  <section id="divider-text-position">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Text Position</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>
                Use class <code>.divider-{left | left-center | right | right-center}</code> with <code>.divider</code>
                to set text position.
              </p>
              <div class="divider divider-left">
                <div class="divider-text">Left</div>
              </div>
              <div class="divider divider-left-center">
                <div class="divider-text">Left Center</div>
              </div>
              <div class="divider">
                <div class="divider-text">Center(Default)</div>
              </div>
              <div class="divider divider-right-center">
                <div class="divider-text">Right Center</div>
              </div>
              <div class="divider divider-right">
                <div class="divider-text">Right</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Divider Text Position Ends --}}

  {{-- Divider Colors Starts --}}
  <section id="divider-colors">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Colors</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>
                Use class <code>.divider-{color-name}</code> to change color of divider
              </p>
              <div class="divider">
                <div class="divider-text">Default</div>
              </div>
              <div class="divider divider-primary">
                <div class="divider-text">Primary</div>
              </div>
              <div class="divider divider-success">
                <div class="divider-text">Success</div>
              </div>
              <div class="divider divider-danger">
                <div class="divider-text">Danger</div>
              </div>
              <div class="divider divider-info">
                <div class="divider-text">Info</div>
              </div>
              <div class="divider divider-warning">
                <div class="divider-text">Warning</div>
              </div>
              <div class="divider divider-dark">
                <div class="divider-text">Dark</div>
              </div>
              <div class="divider divider-light">
                <div class="divider-text">Light</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Divider Colors Ends --}}

  {{-- Divider Icons Starts --}}
  <section id="divider-icons">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Icons</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <div class="divider divider-left">
                <div class="divider-text"><i class="feather icon-arrow-down"></i></div>
              </div>
              <div class="divider divider-left-center">
                <div class="divider-text"><i class="feather icon-star"></i></div>
              </div>
              <div class="divider">
                <div class="divider-text"><i class="feather icon-check"></i></div>
              </div>
              <div class="divider divider-right-center">
                <div class="divider-text"><i class="feather icon-x-circle"></i></div>
              </div>
              <div class="divider divider-right">
                <div class="divider-text"><i class="feather icon-clock"></i></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  {{-- Divider Icons Ends --}}

  {{-- Divider Style Starts --}}
  <section id="divider-style">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header">
            <h4 class="card-title">Style</h4>
          </div>
          <div class="card-content">
            <div class="card-body">
              <p>
                use class
                <code>.divider-{dotted | dashed}</code> to change divider style. solid is default style you don't have to
                add any class for it.
              </p>
              <div class="divider divider-dotted">
                <div class="divider-text">Dotted</div>
              </div>
              <div class="divider divider-dashed">
                <div class="divider-text">Dashed</div>
              </div>

              <div class="divider">
                <div class="divider-text">Solid</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
{{-- Divider Style Ends --}}
@endsection
