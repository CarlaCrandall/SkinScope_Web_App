@extends('master')


{{-- Define page title --}}
@section('page-title')

	{{-- If product exists, display it in title --}}
	<?php if(isset($product)) : ?>
		<title>SkinScope: {{ $product->name }} Ingredients</title>
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

		<section id="filter" class="row sixteen columns">
			<h4>Filter by</h4>
			<div class="sel-container">
				<select>
					<option value="" selected>Rating</option>

					{{-- Loop through all ratings to create dropdown list --}}
					@foreach ($ratings as $rating)
						<option value=<?php echo "\"" . $rating . "\"" ?>>{{ $rating }}</option>
					@endforeach

				</select>
			</div>
		</section>

			{{-- If ingredients exist, display them --}}
			<?php if(isset($ingredients)) : ?>

			<section id="ingredients" class="row sixteen columns">	

				{{-- Loop through all ingredients --}}
				@foreach ($ingredients as $key => $ingredient)

					{{-- Create rows containing 3 ingredients --}}
					@if ($key % 3 == 0)
						<div class="row">
					    	<div class="ingredient one-third column alpha">
					@elseif ($key % 3 == 2)
					    	<div class="ingredient one-third column omega">
					@else
							<div class="ingredient one-third column">
					@endif

				    			<h2 class="ingredient-name"><a href=<?php echo "\"../../products/" . $product->id . "/ingredients/" . $ingredient->id . "\"" ?> >{{ $ingredient->name }}</a></h2>

				    			{{-- Change background image depending on rating --}}
				    			@if ($ingredient->rating == "Good")
				    				<div class="rating good">
				    			@elseif($ingredient->rating == "Average")
				    				<div class="rating average">
				    			@elseif($ingredient->rating == "Poor")
				    				<div class="rating poor">
				    			@else
				    				<div class="rating unknown">
				    			@endif

				    					<span class="rating-text">{{ $ingredient->rating }}</span>
				    					<span>Rating</span>
				    				</div>
				    		</div>

				    {{-- End of the row --}}
				    @if ($key % 3 == 2)
				    	</div>
				    @endif

				@endforeach

				{{-- Close final product div, if there's an uneven number of ingredients --}}
				@if (count($ingredients) % 3 != 0)
					</div>
				@endif

			</section>

			{{-- Display error message if no ingredients exist --}}
			<?php else: ?>
				<section id="message" class="row sixteen columns">Ingredients could not be found.</section>
			<?php endif; ?>

		{{-- Display error message if no products exist --}}
		<?php else: ?>
			<section id="message" class="sixteen columns">The selected product does not exist.</section>
		<?php endif; ?>

	</section>
@stop