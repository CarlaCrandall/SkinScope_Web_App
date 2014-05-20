<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>SkinScope: Ingredients</title>

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

							{{-- Every other product starts a new row (each row contains two products) --}}
							@if ($key % 3 == 0)
								<div class="row">
							    	<div class="ingredient one-third column alpha">
							@elseif ($key % 3 == 2)
							    	<div class="ingredient one-third column omega">
							@else
									<div class="ingredient one-third column">
							@endif

						    			<h2 class="ingredient-name"><a href=<?php echo "\"../../ingredients/" . $ingredient->id . "\"" ?> >{{ $ingredient->name }}</a></h2>

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

					{{-- Display error message if no products exist --}}
					<?php else: ?>
						<section id="message" class="row sixteen columns">Ingredients could not be found.</section>
					<?php endif; ?>

				{{-- Display error message if no products exist --}}
				<?php else: ?>
					<section id="message" class="sixteen columns">The selected product does not exist.</section>
				<?php endif; ?>

		</section>
	</div>
	

	<footer class="row">
		<p class="sixteen columns">Copyright &copy; 2014 <a href="http://carlacrandall.com/">Carla Crandall</a></p>
	</footer>
</body>
</html>
