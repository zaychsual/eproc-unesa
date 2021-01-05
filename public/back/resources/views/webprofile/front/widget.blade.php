<div id="sidebar" class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
  <div class="widget">
    <div class="title"><h2>
      <h2>kategori</h2>
      <ul class="nav nav-tabs nav-stacked">
        @foreach($categories as $value)
          <li><a class="unesa-link" href="{!! url('category/'.$value->name) !!}">{!! $value->name !!}</a></li>
        @endforeach
      </ul>

      <h2>artikel terkini</h2>
      <ul class="nav nav-tabs nav-stacked">
        @foreach($hot as $value)
          <li><a class="unesa-link" href="{!! url('post/'.$value->slug) !!}">{!! $value->title !!}</a></li>
        @endforeach
      </ul>

      @foreach ($widget_right as $vwidget_right)
      <div class="widget">
        <div class="title">
              <h2>{!! $vwidget_right->title_design !!}</h2>
          </div><!-- end title -->
          {!! $vwidget_right->value_design !!}
      </div><!-- end widget --> 
      @endforeach
    </div>
  </div>
</div>
