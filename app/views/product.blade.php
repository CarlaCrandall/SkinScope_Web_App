<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SkinScope: {{ $product->name }}</title>

	{{ HTML::style('css/base.css'); }}
	{{ HTML::style('css/skeleton.css'); }}
	{{ HTML::style('css/styles.css'); }}

	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'); }}
	{{ HTML::script('js/script.js'); }}

</head>
<body>
	<header class="row">
		<div class="container">
			<h1 class="eight columns"><a href="/">SkinScope</a></h1>
			<div class="eight columns">
				<form id="search">
					<input type="text" value="Search" />
					<input type="submit" value=" " />
				</form>
			</div>
		</div>
	</header>

	<div class="container">
		<section id="content">

			{{-- If product exists, display it --}}
			<?php if(isset($product)) : ?>

				<section id="product" class="sixteen columns">	

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
	</div>
	

	<footer class="row">
		<p class="sixteen columns">Copyright &copy; 2014 <a href="http://carlacrandall.com/">Carla Crandall</a></p>
	</footer>
</body>
</html>
