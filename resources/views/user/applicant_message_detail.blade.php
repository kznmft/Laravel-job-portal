@extends('layouts.app')

@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 

<!-- Inner Page Title start --> 
<!-- @include('includes.inner_page_title', ['page_title'=>__('My Messages')])  -->
<!-- Inner Page Title end -->

<div class="listpgWraper">
<div class="container">
  <div class="row"> @include('includes.user_dashboard_menu')
    <div class="col-md-9 col-sm-8">
      <div class="myads">
        <h2>{{__('My Messages')}}</h2>
        <div class="panel-group"> 
          <!-- job start --> 
          @if(isset($message))
          <div class="panel panel-info">
            <div class="panel-body">
              <p class="text-left">
              <table>
                <tr>
                  <td>{{__('Dated')}} : </td>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>{{$message->created_at->format('M d,Y')}}</td>
                </tr>
                <tr>
                  <td>{{__('From')}} : </td>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>{{$message->from_name}} - {{$message->from_email}}</td>
                </tr>
                <tr>
                  <td>{{__('Subject')}} : </td>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>{{$message->subject}}</td>
                </tr>
                <tr>
                  <td>{{__('Message')}} : </td>
                  <td>&nbsp;&nbsp;&nbsp;</td>
                  <td>{{$message->message_txt}}</td>
                </tr>
              </table>
              </p>
            </div>
          </div>
          <!-- job end --> 
          @endif </div>
      </div>
    </div>
  </div>
</div>
@include('includes.footer')
@endsection
@push('scripts')
@include('includes.immediate_available_btn')
@endpush