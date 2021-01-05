@foreach ($menu as $value)
  @if(!$value->parent)
    @if($value->url)
      <li><a href="{!! url((string)$value->url) !!}">{!! $value->name !!}</a></li>
    @else
      <li class="dropdown"><a href="#" data-toggle="dropdown" class="dropdown-toggle">{!! $value->name !!} <div class="arrow-up"></div></a>
          <ul class="dropdown-menu" role="menu">
          @foreach ($menu as $valuec)
            @if($valuec->parent == $value->id)
              @if($valuec->url)
                <li><a href="{!! url((string)$valuec->url) !!}">{!! $valuec->name !!}</a></li>
              @else
                <li class="dropdown-submenu">
                  <a href="#">{!! $valuec->name !!}</a>
                  <ul class="dropdown-menu">
                    @foreach ($menu as $valuec2)
                      @if($valuec2->parent == $valuec->id)
                        <li><a href="{!! url((string)$valuec2->url) !!}">{!! $valuec2->name !!}</a></li>
                      @endif
                    @endforeach

                  </ul>
                </li>
              @endif
            @endif
          @endforeach
          </ul>

      </li>
    @endif

  @endif
  
@endforeach
<li><a href="{!! url('#') !!}">FAQ</a></li>