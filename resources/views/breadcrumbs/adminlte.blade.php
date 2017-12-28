@if ($breadcrumbs)
    <ol class="breadcrumb" style="text-align: right">
        @foreach ($breadcrumbs as $breadcrumb)
            @if($breadcrumb->first)
                <li><a href="{{ $breadcrumb->url }}"><i class="fa fa-home fa-lg"></i> </a></li>
            @elseif ($breadcrumb->url && !$breadcrumb->last)
                <li><a href="{{ $breadcrumb->url }}">{{ $breadcrumb->title }}</a></li>
            @else
                <li class="active">{{ $breadcrumb->title }}</li>
            @endif
        @endforeach
    </ol>
@endif