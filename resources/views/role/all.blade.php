@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
                    <div class="well well-lg">
                        <div class='table-responsive'>
                            @if(!$dbRole->isEmpty())
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
                                    @foreach($dbRole as $value)
                                        <tr class="text-center">
                                            <td>{!! $value->id !!}</td>
                                            <td>{!! $value->name !!}</td>
                                            <td>{!! $value->default_access !!}</td>
                                            <td>@if(hasResource('acl.editRole'))
                                                <a href="{!! route('acl.editRole', $value->name) !!}">Bearbeiten</a>
                                                @endif
                                                @if(hasResource('acl.listRoleResources'))
                                                <a href="{!! route('acl.listRoleResources', $value->id) !!}">Resourcen der Rolle hinzufügen</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                        {!! $dbRole->render() !!}
                        @else
                        <div class="alert alert-danger">
                            <h2>Whoops!</h2>
                            <p>
                                Es wurden keine Rollen gefunden
                            </p>
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
        </div>
</div>
 
@endsection
