@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
                        <h4>Rechte der Rolle zuweisen</h4>

			<div class="well well-lg">

					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
                                        {!! Form::open(['route' => ['acl.doListRoleResources'], 'class' => 'form-horizontal']) !!}
                                        {!! Form::hidden('_id', $id) !!}
                                        
                                        <div class="form-group">
                                            <div class="col-md-12">Rechte</div>
                                        </div>  
                                        
                                        @foreach($elements as $key => $value)

                                        <div class="form-group">
                                            {!! Form::label($key, $value[1], ['class' => 'col-sm-4 control-label' ]) !!}
                                            <div class="col-sm-6"> {!! Form::radio($key, 0, ($value[0] == 0) ? true : false ) !!} Verbieten </div>
                                            <div class="col-sm-6"> {!! Form::radio($key, 1, ($value[0] == 1) ? true : false ) !!} Erlauben </div>
                                            {!! Form::hidden('old_' . $key, (int)$value[0]) !!}
                                        </div>
                                        
                                        @endforeach
                                        
                                        <div class="form-group">
                                            <div class='col-sm-6 col-sm-offset-4'>
                                                <div class="col-sm-4">{!! Form::submit('Resourcen zuweisen', ['class' => 'btn btn-primary']) !!}</div>
                                            </div>  
                                        </div>
                                        
                                        @if (Session::get('msg'))
                                            <div class="alert alert-success">{{ Session::get('msg') }}</div>
                                        @endif
                                        
                                        {!! Form::close() !!}
					
				
			</div>
		</div>
	</div>
</div>

@endsection
