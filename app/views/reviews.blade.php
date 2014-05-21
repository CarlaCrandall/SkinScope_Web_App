@extends('master')


{{-- Define page title --}}
@section('page-title')

	{{-- If product exists, display it in title --}}
	<?php if(isset($product)) : ?>
		<title>SkinScope: {{ $product->name }} Reviews</title>
	<?php else: ?>
		<title>SkinScope: Error</title>
	<?php endif; ?>

@stop


{{-- Define content --}}
@section('content')
	<section id="content">

		{{-- If product exists, display it --}}
		<?php if(isset($product)) : ?>

		<section id="product" class="row sixteen columns">	

			<h2 class="product-name"><a href=<?php echo "\"../../products/" . $product->id . "\"" ?> >{{ $product->name }}</a></h2>
			<h3 class="product-brand">{{ $product->brand }}</h3>

			{{-- Change background image depending on rating --}}
			@if ($product->rating == "Good")
				<div class="rating good">
			@elseif($product->rating == "Average")
				<div class="rating average">
			@elseif($product->rating == "Poor")
				<div class="rating poor">
			@else
				<div class="rating unknown">
			@endif

			<span class="rating-text">{{ $product->rating }}</span>
			    <span>Rating</span>
			</div>
			    
		</section>

		<section id="skinTypes" class="four columns">
			<h4>Browse by Skin Type</h4>
			<ul>
			
				{{-- List all skin types --}}
				@foreach ($skinTypes as $skinType)

					@if (Input::get('skin_type') == $skinType)
						<li class="active">
					@else
						<li>
					@endif

					@if ($skinType == "All Skin Types")
						<a id="clear-skin-types" href="">{{ $skinType }}</a>
					@else
						<a href=<?php echo "\"" . "?skin_type=" . $skinType . "\"" ?> >{{ $skinType }}</a>
					@endif

					</li>					
					
				@endforeach

			</ul>
		</section>

			{{-- If reviews exist, display them --}}
			<?php if(isset($reviews)) : ?>

			<section id="reviews" class="twelve columns">	

				{{-- Loop through all reviews --}}
				@foreach ($reviews as $key => $review)

						<div class="row">
					    	<div class="review twelve columns">
				    			<h2 class="user-name">{{ $review->user->username }}</h2>
				    			<p class="user-skin-type">{{ $review->user->skin_type }}</p>
				    			<p class="review-text">{{ $review->review }}</p>
				    		</div>
				    	</div>
				   
				@endforeach

			</section>

			{{-- Display error message if no reviews exist --}}
			<?php else: ?>
				<section id="message" class="twelve columns">Reviews could not be found.</section>
			<?php endif; ?>

		{{-- Display error message if no products exist --}}
		<?php else: ?>
			<section id="message" class="sixteen columns">The selected product does not exist.</section>
		<?php endif; ?>

	</section>
@stop