@if ($mediaImageVideoTotal == 1)

	@foreach ($mediaImageVideo as $media)

		@if ($media->image != '')

	@php

	if ($media->img_type == 'gif') {
		$urlImg =  Helper::getFile(config('path.images').$media->image);
	} else {
		$urlImg =  url("files/storage", $response->id).'/'.$media->image;
	}
	@endphp

	<a href="{{ $urlImg }}" class="glightbox w-100" data-gallery="gallery{{$response->id}}">
		<img src="{{$urlImg}}?w=130&h=100" {!! $media->width ? 'width="'. $media->width .'"' : null !!} {!! $media->height ? 'height="'. $media->height .'"' : null !!} data-src="{{$urlImg}}?w=960&h=980" class="img-fluid lazyload d-inline-block w-100 post-image" alt="{{ e($response->description) }}">
	</a>
	@endif


	@if ($media->video != '')
	<video id="video-{{$media->id}}" class="js-player w-100 @if (!request()->ajax())invisible @endif" controls @if ($media->video_poster) poster="{{ Helper::getFile(config('path.videos').$media->video_poster) }}" preload="none" @endif>
		<source src="{{ url('file/media/video', $media->id ).'/'.$media->video }}" type="video/mp4" />
	</video>
	@endif

 @endforeach

@endif

@if ($mediaImageVideoTotal >= 2)
<div class="container-post-media">

<div class="media-grid-{{ $mediaImageVideoTotal > 5 ? 5 : $mediaImageVideoTotal }}">

@foreach ($mediaImageVideo as $media)
	@php

	if ($media->type == 'video') {
		$urlMedia =  url('file/media/video', $media->id ).'/'.$media->video;
		$videoPoster = $media->video_poster ? Helper::getFile(config('path.videos').$media->video_poster) : false;
	} else {
		$urlMedia =  url("files/storage", $response->id).'/'.$media->image;
		$videoPoster = null;
	}

		$nth++;
	@endphp

		@if ($media->type == 'image' || $media->type == 'video')

			<a href="{{ $urlMedia }}" class="media-wrapper rounded-0 glightbox" data-gallery="gallery{{$response->id}}" style="background-image: url('{{ $videoPoster ?? $urlMedia}}?w=960&h=980')">

				@if ($nth == 5 && $mediaImageVideoTotal > 5)
		        <span class="more-media">
							<h2>+{{ $mediaImageVideoTotal - 5 }}</h2>
						</span>
		    @endif

				@if ($media->type == 'video')
					<span class="button-play">
						<i class="bi bi-play-circle-fill"></i>
					</span>
				@endif

					<img src="{{ $videoPoster ?? $urlMedia }}?w=960&h=980" {!! $media->width ? 'width="'. $media->width .'"' : null !!} {!! $media->height ? 'height="'. $media->height .'"' : null !!} class="post-img-grid">
			</a>

		@endif

@endforeach

</div><!-- img-grid -->

</div><!-- container-post-media -->

@endif
