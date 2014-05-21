@extends('master')


{{-- Define page title --}}
@section('page-title')
	
	{{-- If product exists, display it in title --}}
	<?php if(isset($product)) : ?>
		<title>SkinScope: {{ $product->name }}</title>
	<?php else: ?>
		<title>SkinScope: Error</title>
	<?php endif; ?>

@stop


{{-- Define content --}}
@section('content')
	<section id="content">

		{{-- If product exists, display it --}}
		<?php if(isset($product)) : ?>

			<section id="product" class="sixteen columns">	

				<h2 class="product-name"><a href=<?php echo "\"../products/" . $product->id . "\"" ?> >{{ $product->name }}</a></h2>
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

			<div class="row">
				<section id="product-ingredients" class="eight columns">
					<h4>Product Ingredients:</h4>
					<p>{{ $product->numIngredients }} Ingredients</p>
					<p>{{ $product->numIrritants }} Irritants</p>
					<p>{{ $product->numComedogenics }} Comedogenics</p>

					<a class="button-secondary" href=<?php echo "\"" . $product->id . "/ingredients\"" ?> >View Ingredients</a>
				</section>

				<section id="product-reviews" class="eight columns">
					<h4>Product Reviews:</h4>
					<p>{{ $product->numReviews }} Reviews</p>

					<a class="button-secondary" href=<?php echo "\"" . $product->id . "/reviews\"" ?> >View Reviews</a>
				</section>
			</div>


		{{-- Display error message if product doesn't exist --}}
		<?php else: ?>
			<section id="message" class="row">The selected product does not exist.</section>
		<?php endif; ?>

	</section>
@stop