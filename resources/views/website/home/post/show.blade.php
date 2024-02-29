@extends('layouts.app')
@section('title', 'Posts')
<style>
    .pagination {
      justify-content: center !important;
      margin: 20px 0 !important;
    }
    .flex {
      margin-top: 20px;
    text-align: center;
    }
    .leading-5{
       margin-top: 10px;
    }
  </style>
  @section('content')
      <!-- Main content -->
      <section class="content">
        <div class="card">
          <div class="card-header">
            <div class="justify-content-between  align-items-center w-100">
              <h3 class="card-title font-weight-bold" style="float: none;">{{ucwords($post->user->name)}}</h3>
              <h6 class="card-title font-weight"style="float: none;">{{date('F d,Y',strtotime($post->created_at))}}</h6>
              <div class="d-flex align-items-center">
                
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            @if($post->image)
              <div>
                <img style="width:100%;height: 300px; " src="{{asset($post->image)}}">
              </div>
              @endif
              <div style="text-align: center;">
                <h2>{{$post->title}}</h2>
              </div>
               <div>
                <p>{{$post->description}}</p>
              </div>
               <div style="margin-top: 3rem;">
                <h5>phone number for conect: <span style="font-weight: bold;">{{$post->phone}}</span></h5>
              </div>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
  @endsection
