<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	
	@yield('page-title')

	{{ HTML::style('css/base.css'); }}
	{{ HTML::style('css/skeleton.css'); }}
	{{ HTML::style('css/styles.css'); }}

	{{ HTML::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js'); }}
	{{ HTML::script('js/script.js'); }}

</head>
<body>
	<header class="row">
		<div class="container">
			<h1 class="eight columns"><a href="http://localhost:8888/SkinScope/public/products">SkinScope</a></h1>
			<div class="eight columns">
				<form id="search">
					<input type="text" value="Search" />
					<input type="submit" value=" " />
				</form>
			</div>
		</div>
	</header>

	<div class="container">
		@yield('content')
	</div>

	<footer class="row">
		<p class="sixteen columns">Copyright &copy; 2014 <a href="http://carlacrandall.com/">Carla Crandall</a></p>
	</footer>
</body>
</html>
