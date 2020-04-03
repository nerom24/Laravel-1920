<!-- Paginado de Clientes -->
<hr>
<div class="container clearfix">
	<div class="float-left">
		 Página {{$users->currentPage()}} / {{$users->lastPage()}}
	</div>
	<div class="float-right">
		 {{$users->render()}}
	</div>
</div>