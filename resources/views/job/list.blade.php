@extends('layouts.app')



@section('content') 

<!-- Header start --> 

@include('includes.header') 

<!-- Header end --> 



<!-- Inner Page Title start --> 

<!-- @include('includes.inner_page_title', ['page_title'=>__('Job Listing')])  -->

<!-- Inner Page Title end -->



<div class="listpgWraper">

  <div class="container">

  @include('flash::message')

    <form action="{{route('job.list')}}" method="get">

      <!-- Page Title start -->

      <div class="pageSearch">

        <div class="row">

          <div class="col-md-3">

          @if(Auth::guard('company')->check())

          <a style="border-radius:0.5em" href="{{ route('post.job') }}" class="btn"><i class="fa fa-file-text" aria-hidden="true"></i> {{__('Post Job')}}</a>

          @else

          <a style="border-radius:0.5em" href="{{url('my-profile#cvs')}}" class="btn"><i class="fa fa-file-text" aria-hidden="true"></i> {{__('Upload Your Resume')}}</a>

          @endif

          

          </div>

          <div class="col-md-9">

            <div class="searchform">

              <div class="row">

                <div class="col-md-{{((bool)$siteSetting->country_specific_site)? 7:5}}">

                  <input type="text" name="search" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Enter Skills or job title')}}" />

                </div>

                <!-- <div class="col-md-2"> {!! Form::select('functional_area_id[]', ['' => __('Select Functional Area')]+$functionalAreas, Request::get('functional_area_id', null), array('class'=>'form-control', 'id'=>'functional_area_id')) !!} </div> -->

                

                

                @if((bool)$siteSetting->country_specific_site)

                {!! Form::hidden('country_id[]', Request::get('country_id[]', $siteSetting->default_country_id), array('id'=>'country_id')) !!}

                @else

                <div class="col-md-2">

                {!! Form::select('country_id[]', ['' => __('Select Country')]+$countries, Request::get('country_id', $siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')) !!}

                </div>

                @endif

                

                <div class="col-md-2">

                <span id="state_dd">

                {!! Form::select('state_id[]', ['' => __('Select State')], Request::get('state_id', null), array('class'=>'form-control', 'id'=>'state_id')) !!}

                </span>

                </div>

                <div class="col-md-2">

                <span id="city_dd">

                {!! Form::select('city_id[]', ['' => __('Select City')], Request::get('city_id', null), array('class'=>'form-control', 'id'=>'city_id')) !!}

                </span>

                </div>

                <div class="col-md-1">

                  <button style="border-radius:0.5em" type="submit" class="btn"><i class="fa fa-search" aria-hidden="true"></i></button>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

      <!-- Page Title end -->

    </form>

    <form action="{{route('job.list')}}" method="get">

      <!-- Search Result and sidebar start -->

      <div class="row"> 
 
        <!-- <div class="col-md-3 col-sm-6 pull-right"> -->

          <!-- Sponsord By -->

          <!-- <div class="sidebar">

            <h4 class="widget-title">{{__('Sponsord By')}}</h4>

            <div class="gad">{!! $siteSetting->listing_page_vertical_ad !!}</div>

          </div>

        </div> -->

        <div class="col-md-12 col-sm-12"> 

          <!-- Search List -->

          <ul class="searchList">

            <!-- job start --> 

            @if(isset($jobs) && count($jobs))

            @foreach($jobs as $job)

            @php $company = $job->getCompany(); @endphp

            @if(null !== $company)

            <li>

              <div class="row">

                <div class="col-md-10 col-sm-10">

                  <div class="jobimg">{{$company->printCompanyImage()}}</div>

                  <div class="jobinfo">

                    <h3><a href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">{{$job->title}}</a></h3>

                    <div class="companyName"><a href="{{route('company.detail', $company->slug)}}" title="{{$company->name}}">{{$company->name}}</a></div>

                    <div class="location">
					 <label class="fulltime" title="{{$job->getJobType('job_type')}}">{{$job->getJobType('job_type')}}</label>
                      - <span>{{$job->getCity('city')}}</span></div>

                  </div>

                  <div class="clearfix"></div>

                </div>

                <div class="col-md-2 col-sm-2">

                  <div class="listbtn"><a href="{{route('job.detail', [$job->slug])}}">{{__('View Details')}}</a></div>

                </div>

              </div>

              <p>{{str_limit(strip_tags($job->description), 150, '...')}}</p>

            </li>

            <!-- job end --> 

            @endif

            @endforeach

            @endif

          </ul>

          

          <!-- Pagination Start -->

          <div class="pagiWrap">

            <div class="row">

              <div class="col-md-5">

                <div class="showreslt">

                {{__('Showing Pages')}} : {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }} {{__('Total')}} {{ $jobs->total() }}

                </div>

              </div>

              <div class="col-md-7 text-right">

              @if(isset($jobs) && count($jobs))

                {{ $jobs->appends(request()->query())->links() }}

              @endif

              </div>

            </div>

          </div>

          <!-- Pagination end --> 

          <!-- <div class=""><br />{!! $siteSetting->listing_page_horizontal_ad !!}</div> -->

                

        </div>

      </div>

    </form>

  </div>

</div>

@include('includes.footer')

@endsection

@push('styles')

<style type="text/css">

.searchList li .jobimg {

    min-height: 80px;

}

.hide_vm_ul{

	height:100px;

	overflow:hidden;

}

.hide_vm{

	display:none !important;

}

.view_more{

	cursor:pointer;

}

</style>

@endpush

@push('scripts') 

<script>

    $(document).ready(function ($) {

        $("form").submit(function () {

            $(this).find(":input").filter(function () {

                return !this.value;

            }).attr("disabled", "disabled");

            return true;

        });

        $("form").find(":input").prop("disabled", false);

				

		$( ".view_more_ul" ).each(function() {

		  	if($( this ).height() > 100)

			{

				$( this ).addClass('hide_vm_ul');

				$( this ).next().removeClass('hide_vm');

			}

		});



		$('.view_more').on('click', function(e){

			e.preventDefault();

			$( this ).prev().removeClass('hide_vm_ul');

			$( this ).addClass('hide_vm');

		});

	

	});

</script>

@include('includes.country_state_city_js')

@endpush