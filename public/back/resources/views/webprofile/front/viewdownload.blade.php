@extends('webprofile.layouts.front.master')

@section('content')
  <section class="post-wrapper-top jt-shadow clearfix">
    <div class="container">
      <div class="col-lg-12">
          <h2>Download</h2>
      </div>
    </div>
  </section><!-- end post-wrapper-top -->

  <section class="blog-wrapper">
    <div class="container">
        <div class="row">
          <div id="main-content" class="col-md-12" role="main" align="justify">
            <table class="table table-bordered">
				<thead>
				<tr>
					<th style="width: 5%;">No</th>
					<th>Nama Dokumen</th>
					<th style="width: 15%;">Tanggal Publikasi</th>
					<th style="width: 10%;">Option</th>
				</tr>
				</thead>
				<tbody>
				@foreach ($categoriesFile as $value)
				<tr>
					<td colspan="4" style="font-weight: bold;">KATEGORI : {{ $value->name }}</td>
				</tr>
					@php
						$no = 1;
					@endphp
					@foreach ($value->rFile as $item)
					<tr>
						<td style="text-align: center; color: black;">{{ $no++ }}</td>
						<td style="color: black;">{{ $item->title }}</td>
						<td style="text-align: center; color: black;">{{ InseoHelper::tgl($item->created_at) }}</td>
						<td style="text-align: center;">
							<a href="{{ url('downloadlink/'.$item->id) }}" class="btn btn-info"><i class="fa fa-download"> Download</i></a>
						</td>
					</tr>
					@endforeach
				@endforeach
				</tbody>
			</table>
          </div>
        </div>
      </div><!-- end title -->
    </div><!-- end container -->
  </section><!--end white-wrapper -->

@endsection
