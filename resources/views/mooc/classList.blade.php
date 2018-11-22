@extends('mooc.layouts.main')

@section('script-extension')
    @parent
                // 選中的學校選單增加active特效
                $("a.school").each(function() {
                    if ($(this).attr("name") == "{{ $school }}") {
                        $(this).addClass("active");
                    }
                });

                // 選中的分類選單增加active特效
                $("a.type").each(function() {                
                    if ($(this).text() == "{{ $type }}") {
                        $(this).addClass("active");
                        $(this).addClass("font-weight-bold");
                    }
                });
@endsection

@section('banner')
    <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="{{ asset('images/banner.jpg') }}" alt="First slide">
            </div>				
        </div>
    </div>
@endsection

@section('content')
    <div class="container my-5 ">

    <!-- 學校選單 -->
        <nav class="nav nav-pills nav-justified my-5">
            <a class="nav-item nav-link btn btn-lg btn-outline-info mr-2 school" href="{{ route('class') }}?school=ntu" name="ntu">{{ __('dictionary.NTU') }}</a>
            <a class="nav-item nav-link btn btn-lg btn-outline-info mr-2 school" href="{{ route('class') }}?school=nthu" name="nthu">{{ __('dictionary.NTHU') }}</a>
            <a class="nav-item nav-link btn btn-lg btn-outline-info mr-2 school" href="{{ route('class') }}?school=nctu" name="nctu">{{ __('dictionary.NCTU') }}</a>
            <a class="nav-item nav-link btn btn-lg btn-outline-secondary mr-2 school disabled" href="#">{{ __('dictionary.Opening soon') }}</a>
        </nav>

    <!-- 分類選單 -->
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link text-dark type" href="{{ route('class') }}?school={{ $school }}&type=熱門課程">熱門課程</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark type" href="{{ route('class') }}?school={{ $school }}&type=理工類">理工類</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-dark type" href="{{ route('class') }}?school={{ $school }}&type=管理類">管理類</a>
            </li>        
        </ul>

    <!-- 課程表 -->
        <div class="my-5">
            <table class="table table-striped">                
                <thead>
                <tr>
                    <th class="text-right text-nowrap">{{ __('dictionary.ClassId') }}:</th>
                    <th class="text-center text-nowrap">{{ __('dictionary.ClassName') }}:</th>
                    <th class="text-center text-nowrap">{{ __('dictionary.Like') }}:</th>
                    <th class="text-center text-nowrap">{{ __('dictionary.School') }}:</th>
                    <th class="text-center text-nowrap">{{ __('dictionary.Teacher') }}:</th>
                    <th class="text-center text-nowrap">{{ __('dictionary.ClassType') }}:</th>
                </tr>
                </thead>
                <tbody>     
                    @foreach ($classes as $class)
                    <tr>                    
                        <td class="text-right">{{ $class->classId }}</td>
                        <td class="pl-3"><a href="{{ route('class') }}?class={{ $class->classId }}" style="display:block;">{{ $class->className }}</a></td>
                    
                        @if ($class->likeCount != '') {
                            <td class="text-center">{{ substr_count($class->likeCount, ',') + 1 }}</td>
                        @else
                            <td class="text-center">0</td>
                        @endif
                                            
                        <td class="text-center">{{ $class->school }}</td>
                        <td class="text-center">{{ $class->teacher }}</td>
                        <td>{{ $class->type }}</td>                    
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    <!-- 課程頁數 -->
        <div class="w-100">
            <div class="mx-auto">
                @if (isset($school) || isset($type))
                    {{ $classes->appends(['school' => $school, 'type' => $type])->links() }}
                @else
                    {{ $classes->links() }}
                @endif
            </div>
        </div>

    </div>
@endsection