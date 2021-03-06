@extends('layouts.master')

@section('title')
    Student Profile
@endsection
@section('content')
    @include('layouts.secondaryTitleBar')
    <div class="container">
        <div class="page-section">
            <div class="row">
                <div class="col-md-9">
                    @include('includes.flash')
                    <div class="panel panel-default">
                        <div class="row yrshare-pad">
                            <div class="col-md-6">

                                <span class="pull-left"><span class="yr-headline">Profile Views:</span>
                                <span class="yr-padwy">{{ Auth::user()->view_counter }}</span></span>
                            </div>
                            <div class="col-md-6">
                            </div>
                        </div>
                    </div>
                    <div class="row" data-toggle="isotope">
                        <div class="item col-xs-12 col-lg-6" style="position: absolute; left: 0px; top: 0px;">
                            <div class="panel panel-default paper-shadow" data-z="0.5">
                                <div class="panel-heading">
                                    <div class="media v-middle">
                                        <div class="media-body">
                                            <h4 class="text-headline margin-none">About</h4>
                                        </div>
                                        <div class="media-right">
                                            <a href="{{ url('/profile/edit') }}"
                                               class="btn btn-white btn-flat"><i class="fa fa-pencil fa-fw"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <ul class="list-group aboutpad">
                                    <div class="media">
                                        <div class="media-left"><i data-toggle="tooltip" data-placement="top"
                                                                   title="Occupation"
                                                                   class="fa fa-fw fa-briefcase fa-lg text-headline"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="yrdetail">{{ Auth::user()->profile->occupation }}</p>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left"><i data-toggle="tooltip" data-placement="top"
                                                                   title="Phone Number"
                                                                   class="fa fa-fw fa-phone-square fa-lg text-headline"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="yrdetail">{{ Auth::user()->phone_no }}</p>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left"><i data-toggle="tooltip" data-placement="top"
                                                                   title="Email Address"
                                                                   class="fa fa-fw fa-at fa-lg text-headline"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="yrdetail">{{ Auth::user()->email }}</p>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left">
                                            <i data-toggle="tooltip" data-placement="top" title="location"
                                               class="fa fa-fw fa-home fa-lg text-headline"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="yrdetail">{{ Auth::user()->profile->country }}</p>
                                        </div>
                                    </div>
                                    <div class="media">
                                        <div class="media-left"><i data-toggle="tooltip" data-placement="top"
                                                                   title="Address"
                                                                   class="fa fa-fw fa-map-marker fa-lg text-headline"></i>
                                        </div>
                                        <div class="media-body">
                                            <p class="yrdetail">{{ Auth::user()->profile->address }}</p>
                                        </div>
                                    </div>
                                    <div class="biopad-up">
                                        <h4 class="text-headline">Bio:</h4>
                                        <p class="biopad">{{ Auth::user()->profile->description }}</p>
                                    </div>
                                </ul>
                            </div>
                        </div>
                        <div class="item col-xs-12 col-lg-6">
                            @foreach($timeline as $post)
                                <div class="modal fade" id="{{$post->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    <span aria-hidden="true">&times;</span>
                                                    <span class="sr-only">Close</span></button>
                                                <div class="mediamodal v-middle">
                                                    <div class="media-left">
                                                        <div class="icon-block half img-circle bg-purple-300">
                                                            <i class="fa fa-star text-white"></i>
                                                        </div>
                                                    </div>
                                                    <div class="media-body">
                                                        <div href="#" class="text-modalusermsg" data-toggle="modal"
                                                             data-target="#myModal">{{$post->header}}
                                                        </div>
                                                        <div class="text-light">
                                                            <div class="shifttwo">{{Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans()}}</div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            @if(!is_null($post->thumbnail))
                                                <div class="modal-image">
                                                    <a href="#">
                                                        <img src="/{{$post->thumbnail}}" alt="news"/>
                                                    </a>
                                                </div>
                                            @endif
                                            <div class="modal-body">
                                                <h4 class="text-modalusermsg">{{$post->header}}</h4>
                                                <p>{{$post->description}}
                                                </p>
                                            </div>
                                            <div class="modal-footer">
                                                <i class="fa fa-fw fa-facebook"></i><i
                                                        class="fa fa-fw fa-twitter"></i><i
                                                        class="fa fa-fw fa-google-plus"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            @endforeach
                            <h4 class="text-headline margin-none">Yearbook Timeline</h4>
                            <p class="text-subhead text-light">Latest updates &amp; events</p>
                            <ul class="list-group relative paper-shadow" data-hover-z="0.5" data-animated="">
                                @forelse($timeline as $post)
                                    <li class="list-group-item paper-shadow">
                                        <div class="media v-middle">
                                            <div class="media-left">
                                                <div class="icon-block half img-circle bg-purple-300">
                                                    <i class="fa fa-star text-white"></i>
                                                </div>
                                            </div>
                                            <div class="media-body">
                                                <a href="#" class="text-subhead link-text-color" data-toggle="modal"
                                                   data-target="#{{$post->id}}">{{ str_limit($post->header, $limit = 30, $end = '...') }}</a>
                                                <div class="text-light">
                                                    By:
                                                    <a href="#">{{$post->postBy->first_name}} {{$post->postBy->last_name}}</a>
                                                </div>
                                            </div>
                                            <div class="media-right">
                                                <div class="width-60 text-right">
                                                    <span class="text-caption text-light">{{Carbon\Carbon::createFromTimeStamp(strtotime($post->created_at))->diffForHumans()}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @empty
                                    <li class="list-group-item paper-shadow">
                                        <p>No post available at this time.</p>
                                    </li>

                                @endforelse

                            </ul>
                            <div class="text-center">

                                {{ $timeline->links() }}
                                {{--<button class="btn btn-primary">LOAD MORE</button>--}}
                            </div>
                        </div>
                    </div>
                    <br/>
                    <br/>
                </div>
                <div class="col-md-3">
                    <div class="modal fade yrfeature" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
                         aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"><span
                                                aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                                    <h4 class="modal-title" id="mySmallModalLabel">Hi, Chidi</h4>
                                </div>
                                <div class="modal-body">
                                    <p> This feature is not yet available for this version of yearbook.
                                        Please expect this feature in our next update.
                                        <br>
                                        Thank you.
                                    </p>
                                </div>
                            </div><!-- /.modal-content -->
                        </div>
                    </div>
                    @include('layouts.sidebarNav')
                </div>
            </div>
        </div>
    </div>
@endsection
