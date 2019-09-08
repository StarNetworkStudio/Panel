@extends('admin.master', ['title' => '运行状态'])
@section('content')
  <div class="row">
    <div class="col-md-6">
      <div class="kt-portlet">
        <div class="kt-portlet__head">
          <div class="kt-portlet__head-label">
            <h3 class="kt-portlet__head-title">信息</h3>
          </div>
        </div>
        <div class="kt-portlet__body">
          <table class="table table-bordered table-striped">
            <tbody>
            @foreach ($detail as $category => $info)
              <tr>
                <th colspan="2">{{$category}}</th>
              </tr>
              @foreach ($info as $key => $value)
                <tr>
                  <td>{{$key}}</td>
                  <td>{{ $value }}</td>
                </tr>
              @endforeach
            @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-md-6"></div>
  </div>
@endsection
