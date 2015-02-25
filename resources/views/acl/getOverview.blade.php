@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
                        <h4>Übersicht</h4>
			<div class="well well-lg text-center">
                            
                            @if(hasResource('acl.allRoles')) 
                            <div class="col-sm-4">
                                <a href="{!! route('acl.allRoles') !!}"> Rollen </a>
                            </div>
                            @endif
                            @if(hasResource('acl.allResources'))
                            <div class="col-sm-4">
                                <a href="{!! route('acl.allResources') !!}"> Resourcen </a>
                            </div> 
                            @endif
                            @if(hasResource('user.all'))
                            <div class="col-sm-4">
                                <a href="{!! route('user.all') !!}"> User </a>
                            </div> 
                            @endif
			</div>
		</div>
	</div>
</div>
@endsection
