@extends('app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
                        <h4>Resource Anlegen</h4>

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
                                        {!! Form::open(['route' => ['acl.doResource'], 'class' => 'form-horizontal']) !!}
                                        
                                        <div class="form-group">
                                            {!! Form::label('name', 'Resource', ['class' => 'col-sm-4 control-label' ]) !!}
                                            <div class="col-sm-6">{!! Form::text('name', old('name'), ['class' => 'form-control',
                                                                                                         'placeholder' => 'Resource']) !!}</div>
                                        </div>
                                        
                                        <div class="form-group">
                                            {!! Form::label('rights', 'Standardrecht', ['class' => 'col-sm-4 control-label' ]) !!}
                                            <div class="col-sm-6"> {!! Form::radio('rights', 0) !!} Verbieten </div>
                                            <div class="col-sm-6"> {!! Form::radio('rights', 1) !!} Erlauben </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <div class='col-sm-6 col-sm-offset-4'>
                                                <div class="col-sm-4">{!! Form::submit('Rolle anlegen', ['class' => 'btn btn-primary']) !!}</div>
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
