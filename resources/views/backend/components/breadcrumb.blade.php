@if (count($breadcrumbs) > 0)
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>{{$title}}</h2>
        <ol class="breadcrumb">
            <li>
                <a href="">Dashboard</a>
            </li>
          @foreach ($breadcrumbs as $breadcrumb)
            <li>
                <a @if($breadcrumb["active"]) class="active" @endif href="{{$breadcrumb["url"]}}">@if($breadcrumb["active"]) <strong>{{$breadcrumb["name"]}}</strong> @else {{$breadcrumb["name"]}}  @endif</a>
            </li>
          @endforeach
        </ol>
    </div>
</div> 
@else

@endif
