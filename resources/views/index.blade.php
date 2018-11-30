@extends('layout.html')

@section('body')
    <div class="row">
        <div class="center-block" style="width: 80%">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">代理池</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body table-responsive no-padding ">
                    <table class="table table-hover table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>IP</th>
                            <th>端口</th>
                            <th>匿名度</th>
                            <th>类型</th>
                            <th>响应速度</th>
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
                                <td>{{ $proxy->checked_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-copy"
                                            data-url="{{ sprintf("%s://%s:%s",$proxy->protocol,$proxy->ip,$proxy->port) }}">
                                        复制
                                    </button>
                                    <button class="btn btn-sm btn-speed "
                                            data-url="{{ sprintf("%s://%s:%s",$proxy->protocol,$proxy->ip,$proxy->port) }}"
                                            data-protocol="{{ $proxy->protocol }}"
                                            data-ip="{{ $proxy->ip }}"
                                            data-port="{{ $proxy->port }}">测速
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
                {{ $proxies->render() }}
            </div>
            <!-- /.box -->
        </div>
    </div>

    <div class="modal fade" id="modal-speed" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="exampleModalLabel">代理IP测速</h4>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="recipient-name" class="control-label">代理地址</label>
                            <input type="text" class="form-control" id="proxy-ip-address">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">访问地址</label>
                            <input class="form-control" id="web-link" value="http://www.20.com/">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="control-label">访问结果</label>
                            <iframe class="form-control" id="proxy-iframe" style="min-height: 300px;"></iframe>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(function () {
            var loadModal = false;
            window.setInterval(function () {
                if (loadModal) {
                    return;
                }
                window.location.reload()
            }, 10000);
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

            $('.btn-speed').click(function () {
                loadModal = true;
                $('#modal-speed').modal({
                    'backdrop': false
                });
                var protocol = $(this).attr('data-protocol');
                var ip = $(this).attr('data-ip');
                var port = $(this).attr('data-port');
                var ipAddress = $(this).attr('data-url');
                var webLink = $('#web-link').val();
                $('#proxy-ip-address').val(ipAddress);
                var src = '/api/proxies/check?protocol=' + protocol + '&ip=' + ip + '&port=' + port + '&web_link=' + encodeURIComponent(webLink);
                $('#proxy-iframe').attr('src', src)

            });

            $('#modal-speed').on('hidden.bs.modal', function (e) {
                loadModal = false;
            })
        });
    </script>
@endsection