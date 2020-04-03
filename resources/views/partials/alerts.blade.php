@if(session('success'))   
    <div class="alert alert-success" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <b>Mensaje: </b>{{ session('success') }} 
    </div>
@endif

@if(session('error'))   
    <div class="alert alert-danger" role="alert">
	    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	    <b>Error: </b>{{ session('error') }} 
    </div>
@endif

