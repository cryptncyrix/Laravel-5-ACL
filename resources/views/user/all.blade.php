@extends('app')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
                    <div class="well well-lg">
                        <div class='table-responsive'>
                            @if(!$dbUser->isEmpty())
                            <table class="table table-hover">
                                <caption> Alle User</caption>
                                <thead>
                                    <tr>
                                        <th class="text-center">Id</th>
                                        <th class="text-center">Name</th>
                                        @if(in_array('acl.listUserResources', $acl) || in_array('acl.listUserRoles', $acl))
                                            <th class="text-center">Bearbeiten</th>
                                        @endif
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($dbUser as $value)
                                        <tr class="text-center">
                                            <td>{!! $value->id !!}</td>
                                            <td>{!! $value->name !!}</td>                                           
                                                <td>
                                                    @if(in_array('acl.listUserResources', $acl))
                                                        <a href="{!! route('acl.listUserResources', $value->id) !!}">User Rechte hinzufÃ¼gen </a>
                                                    @endif
                                                    @if(in_array('acl.listUserRoles', $acl))
                                                        <a href="{!! route('acl.listUserRoles', $value->id) !!}">User Rollen hinzufÃ¼gen </a>
                                                    @endif
                                                </td>                                            
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> 
                        {!! $dbUser->render() !!}
                        @else
                        <div class="alert alert-danger">
                            <h2>Whoops!</h2>
                            <p>
                                Es wurden keine User gefunden
                            </p>
                        </div>
                        @endif
                        </div>
                    </div>
                </div>
        </div>
</div>
 
@endsection
