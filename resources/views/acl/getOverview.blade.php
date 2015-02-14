@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
                        <h4>Ãœbersicht</h4>
			<div class="well well-lg">
                            
                            <div class="col-sm-4">
                                <a href="{!! route('acl.allRoles') !!}"> Rollen </a>
                            </div>

                            <div class="col-sm-4">
                                <a href="{!! route('acl.allResources') !!}"> Resourcen </a>
                            </div>  
                            
                            <div class="col-sm-4">
                                <a href="{!! route('user.all') !!}"> User </a>
                            </div> 

			</div>
		</div>
	</div>
</div>
@endsection
