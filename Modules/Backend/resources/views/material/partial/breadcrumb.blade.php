<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="{{route('app.backend')}}">Home</a></li>
                    @if (count($breadcrumb) > 0)
                        @foreach ($breadcrumb as $val)
                            @if($val['active'])
                                <li class="breadcrumb-item active">{{ $val['title'] }}</li>
                            @else
                                <li class="breadcrumb-item"><a href="{{ $val['url'] }}">{{ $val['title'] }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                </ol>
            </div>
            <h4 class="page-title">{{$title_sub}}</h4>
        </div>
    </div>
</div>
<!-- end page title -->
