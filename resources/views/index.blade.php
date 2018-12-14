@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
            {{--<div class="card-header">--}}
            {{--</div>--}}
            {{--<div class="card-body">--}}
            {{----}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            <table class="table table-hover table-bordered table-bg">
                <thead>
                <tr>
                    <th>IP</th>
                    <th>端口</th>
                    <th>匿名度</th>
                    <th>类型</th>
                    <th>响应速度</th>
                    <th>使用次数</th>
                    <th>验证次数</th>
                    <th>最后验证时间</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($proxies as $key => $proxy)
                    <tr>
                        <td>{{ $proxy->ip }}</td>
                        <td>{{ $proxy->port }}</td>
                        <td>{{ __('proxy.'.$proxy->anonymity) }}</td>
                        <td>{{ strtoupper($proxy->protocol) }}</td>
                        <td>{{ \App\Utils\CommonUtil::formatSpeed($proxy->speed) }}</td>
                        <td>{{ $proxy->used_times }}</td>
                        <td>{{ $proxy->checked_times }}</td>
                        <td>{{ $proxy->last_checked_at }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-success btn-copy"
                                    data-url="{{ sprintf("%s://%s:%s",$proxy->protocol,$proxy->ip,$proxy->port) }}">
                                复制
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <!-- /.box-body -->
            {{ $proxies->render() }}
        </div>
    </div>
@endsection

@section('js')
    <script src="{{asset('js/jquery.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/clipboard.min.js')}}"></script>
    <script>
        $(function () {
            var loadModal = false;
            var clipboard = new Clipboard(".btn-copy", {
                text: function (_this) {
                    return $(_this).attr('data-url');
                }
            });
            clipboard.on("success", function (t) {
                alert('复制成功!')
            });
            clipboard.on("error", function (t) {
                alert('复制失败!')
            });
        });
    </script>
@endsection