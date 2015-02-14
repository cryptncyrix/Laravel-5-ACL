@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
                    <div class="well well-lg">
                        <div class='table-responsive'>
                            @if(!$dbResource->isEmpty())
                            <table class="table table-hover">
                                <caption> Alle Resourcen</caption>
                                <thead>
                                    <tr>
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Name</th>
                                        <th class="text-center">Standardrecht</th>
                                        <th class="text-center">Bearbeiten</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dbResource as $value)
                                        <tr class="text-center">
                                            <td>{!! $value->id !!}</td>
                                            <td>{!! $value->name !!}</td>
                                            <td>{!! $value->default_access !!}</td>
                                            <td><a href="{{ route('acl.editResource', $value->name) }}">Bearbeiten</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                        {!! $dbResource->render() !!}
                        @else
                        <div class="alert alert-danger">
                            <h2>Whoops!</h2>
                            <p>
                                Es wurden keine Resourcen gefunden
                            </p>
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
        </div>
</div>
 
@endsection
