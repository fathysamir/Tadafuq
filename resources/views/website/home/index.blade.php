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
            <div class="justify-content-between d-flex align-items-center w-100">
              <h3 class="card-title font-weight-bold">Posts</h3>
              <div class="d-flex align-items-center">
                <form class=" mx-2 my-0" id="search_categories" method="post" action="{{ route('home') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="input-group">
                    <input type="search" style="height: 40px; font-size: 15px;" name="search" class="form-control form-control-lg"
                      placeholder="Type your keywords here">
                    <div class="input-group-append">
                      <button type="submit" style="height: 40px; font-size: 15px;" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                      </button>
                    </div>
                  </div>
                </form>
                @can('post-create')
                <a href="{{route('add.post')}}" class="btn btn-primary">Create Post<i class="bi bi-plus"></i> </a>
                @endcan
              </div>
            </div>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
              <div id="jsGrid1" class="jsgrid" style="position: relative; height: 100%; width: 100%;">
                <div class="jsgrid-grid-header jsgrid-header-scrollbar">
                  <table class="jsgrid-table">
                    <tr class="jsgrid-header-row">
                      <th class="jsgrid-header-cell jsgrid-align-center jsgrid-header-sortable" style="width: 70px;">Titel</th>
                      <th class="jsgrid-header-cell jsgrid-align-center jsgrid-header-sortable" style="width: 150px;">Description</th>
                      <th class="jsgrid-header-cell jsgrid-align-center jsgrid-header-sortable" style="width: 30px;">Action</th>
                    </tr>
                  </table>
                </div>
  
                <div class="jsgrid-grid-body" style="max-height: 816.8px;">
                  <table class="jsgrid-table">
                    <tbody>
                      @if(!empty($all_posts) && $all_posts->count())
                        @foreach($all_posts as $post)
                          <tr class="jsgrid-row">
                            <td class="jsgrid-cell jsgrid-align-center" style="width: 70px;">{{$post->title}}</td>
                            <td class="jsgrid-cell jsgrid-align-left" style="width: 150px;">
                              @if(strlen($post->description)>512)
                               {{substr($post->description,0,512)}}...
                              @else
                              {{$post->description}}
                              @endif
                            </td>
                            
                            
                            <td class="jsgrid-cell jsgrid-align-center" style="width: 30px;">
                              <a href="{{url('/post/view/'.$post->id)}}" style="margin-right: 1rem;">
                                <span  class="bi bi-eye" style="font-size: 1rem; color: rgb(0,0,255);"></span>
                              </a>
                              @if(auth()->user()->id==$post->user_id)
                              @can('post-edit')
                              <a href="{{url('/post/edit/'.$post->id)}}" style="margin-right: 1rem;">
                                <span  class="bi bi-pen" style="font-size: 1rem; color: rgb(0,255,0);"></span>
                              </a>
                              @endcan
                              @can('post-delete')
                              <a href="{{url('/post/delete/'.$post->id)}}">
                                <span class="bi bi-trash" style="font-size: 1rem; color: rgb(255,0,0);"></span>
                              </a>
                              @endcan
                              @endif
                            </td>
                          </tr>
                        @endforeach
                      @else
                          <tr>
                            <td colspan="10" class="text-center py-3">There are no posts.</td>
                          </tr>
                      @endif
                    </tbody>
                  </table>
                  {!! $all_posts->links("pagination::bootstrap-4") !!}
                </div>
              </div>
  
           
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </section>
  @endsection
