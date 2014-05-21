@extends('master')


{{-- Define page title --}}
@section('page-title')
	
	{{-- If ingredient exists, display it in title --}}
	<?php if(isset($ingredient) && isset($product)) : ?>
		<title>SkinScope: {{ $product->name }}: {{ $ingredient->name }}</title>
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

			<h2 class="product-name"><a href=<?php echo "\"../../../products/" . $product->id . "\"" ?> >{{ $product->name }}</a></h2>
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


			{{-- If ingredients exists, display them --}}
			<?php if(isset($ingredients)) : ?>

			<section id="ingredient-list" class="four columns">
				<ul>
					{{-- If ingredient exists, display it as the active list item --}}
					<?php if(isset($ingredient)) : ?>

						{{-- Loop through ingredients to create a list --}}
						@foreach ($ingredients as $listIngredient)
							@if ($listIngredient->id == $ingredient->id)
								<li class="active"><a href=<?php echo "\"../../../products/" . $product->id . "/ingredients/" . $listIngredient->id . "\"" ?> >{{ $listIngredient->name }}</a></li>
							@else
								<li><a href=<?php echo "\"../../../products/" . $product->id . "/ingredients/" . $listIngredient->id . "\"" ?> >{{ $listIngredient->name }}</a></li>
							@endif
						@endforeach

					{{-- Else there is no active list item --}}
					<?php else: ?>

						{{-- Loop through ingredients to create a list --}}
						@foreach ($ingredients as $listIngredient)
							<li><a href=<?php echo "\"../../../products/" . $product->id . "/ingredients/" . $listIngredient->id . "\"" ?> >{{ $listIngredient->name }}</a></li>
						@endforeach
						
					<?php endif; ?>

				</ul>
			</section>


				{{-- If ingredient exists, display it --}}
				<?php if(isset($ingredient)) : ?>

				<section id="ingredient" class="twelve columns">	
					<h2 class="ingredient-name">{{ $ingredient->name }}</h2>
					<p class="ingredient-function">{{ $ingredient->function }}</p>

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

					@if ($ingredient->irr != null)
						<p class="ingredient-irr"><strong>Irritancy:</strong> {{ $ingredient->irr }}/5</p>
					@else
						<p class="ingredient-irr"><strong>Irritancy:</strong> ?/5</p>
					@endif

					@if ($ingredient->com != null)
						<p class="ingredient-com"><strong>Comedogenicity:</strong> {{ $ingredient->com }}/5</p>
					@else
						<p class="ingredient-com"><strong>Comedogenicity:</strong> ?/5</p>
					@endif

					<p class="ingredient-desc">{{ $ingredient->description }}</p>
				</section>


				{{-- Display error message if ingredient does not exist --}}
				<?php else: ?>
					<section id="message" class="twelve columns">The selected ingredient does not exist.</section>
				<?php endif; ?>


			{{-- Display error message if ingredients do not exist --}}
			<?php else: ?>
				<section id="message" class="row sixteen columns">Ingredients could not be found.</section>
			<?php endif; ?>


		{{-- Display error message if product does not exist --}}
		<?php else: ?>
			<section id="message" class="sixteen columns">The selected product does not exist.</section>
		<?php endif; ?>

	</section>
@stop