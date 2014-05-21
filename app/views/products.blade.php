@extends('master')


{{-- Define page title --}}
@section('page-title')
	<title>SkinScope: Products</title>
@stop


{{-- Define content --}}
@section('content')
	<section id="content">

		<section id="sidebar" class="four columns">
			<h4>Browse by Category</h4>
			<ul>
				{{-- Loop through all categories to create list --}}
				@foreach ($categories as $category)

					@if (Input::get('category') == $category)
						<li class="active"><a href=<?php echo "\"" . "?category=" . $category . "\"" ?> >{{ $category }}</a></li>
					@else
						<li><a href=<?php echo "\"" . "?category=" . $category . "\"" ?> >{{ $category }}</a></li>
					@endif

				@endforeach
			</ul>
			<a class="button" href="products/create">Add a Product</a>
		</section>

		<section id="filter" class="twelve columns omega">
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

		{{-- If products exist, display them --}}
		<?php if(isset($products)) : ?>

			<section id="products" class="twelve columns omega">	

				{{-- Loop through all products --}}
				@foreach ($products as $key => $product)

					{{-- Every other product starts a new row (each row contains two products) --}}
					@if ($key % 2 == 0)
						<div class="row">
					    	<div class="product six columns alpha">
					@else
					    	<div class="product six columns omega">
					@endif

				    			<h2 class="product-name"><a href=<?php echo "\"" . "products/" . $product->id . "\"" ?> >{{ $product->name }}</a></h2>
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

				    			<div class="product-links">
				    				<p class="product-ingredients"><a href=<?php echo "\"" . "products/" . $product->id . "/ingredients\"" ?> >{{ $product->numIngredients }} Ingredients</a></p>
				    				<p class="product-reviews"><a href=<?php echo "\"" . "products/" . $product->id . "/reviews\"" ?> >{{ $product->numReviews }} Reviews</a></p>
				    			</div>
				    		</div>

				    {{-- End of the row --}}
				    @if ($key % 2 == 1)
				    	</div>
				    @endif

				@endforeach

				{{-- Close final product div, if there's an uneven number of products --}}
				@if (count($products) % 2 == 1)
						</div>
				@endif

			</section>

		{{-- Display error message if no products exist --}}
		<?php else: ?>
			<section id="message" class="twelve columns omega">No products match your selection.</section>
		<?php endif; ?>

	</section>
@stop	