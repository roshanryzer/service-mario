<!--
<div class="dropdown dropdown-hover">
    <a href="javascript:void(0);">{{ $title }}
        <i class="fa fa-angle-right"></i>
    </a>
    <div class="dropdown-content">
        @foreach ($links as $link)
            {{ $link }}
        @endforeach
    </div>
</div>-->
<div class="dropdown">
    <div class="dropdown-menu-right">
        @foreach ($links as $link)
            {{ $link }}
        @endforeach
    </div>
</div>
