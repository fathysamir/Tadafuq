@extends('layouts.app')
@section('title', 'Create Post')
@section('content')
<!-- Main content -->
<style>
  .text-error{
    font-size: 0.9rem;
  }

</style>
<!-- Main content -->
<section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- jquery validation -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Create New Post</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form id="quickForm" method="post" action="{{route('create.post')}}" enctype="multipart/form-data">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Titel</label>
                  <input type="text" name="title" class="form-control"  placeholder="Enter Title"value="{{ old('title') }}">
                  @if ($errors->has('title'))
                      <p class="text-error more-info-err" style="color: red;">
                          {{ $errors->first('title') }}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                 
                  <textarea style="height: 200px;" class="form-control" name="description" placeholder="Enter Description">@if(old('description')){{old('description')}}@endif</textarea>
                  @if ($errors->has('description'))
                      <p class="text-error more-info-err" style="color: red;">
                          {{ $errors->first('description') }}</p>
                  @endif
                </div>

                 <div class="form-group">
                  <label for="exampleInputEmail1">Phone Number</label>
                  <input type="number" name="phone" class="form-control"  placeholder="Enter Phone Number"value="{{ old('phone') }}">
                  @if ($errors->has('phone'))
                      <p class="text-error more-info-err" style="color: red;">
                          {{ $errors->first('phone') }}</p>
                  @endif
                </div>

               
                

               
                
               
              </div>
              
              <!-- /.card-body -->
              <div class="card-footer">
                
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
          </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
  
        </div>
        <!--/.col (right) -->
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>

  <!-- /.content -->
  @endsection