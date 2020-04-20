@extends('layouts.wap_no_header')

@section('title', '发出的红包')

@section('styles')
    <style>
        .show-item {
            animation: showItemAnimation 1s;
        }

        @keyframes showItemAnimation {
            from {
                opacity: 0;
                transform: translate(0, 100%);
            }
            to {
                opacity: 1;
                transform: translate(0, 0);
            }
        }
    </style>
@endsection

@inject('photo', 'App\Services\PhotoService')
@section('content')
    <div class="fixed-top">
        <div class="media bg-primary align-items-center" onclick="showRedPacket()">
            <a href="{{ route('member.wap.wallet') }}"
               class="iconfont icon-houtuishangyige text-warning font-weight-bold p-2 font-size-20"
               aria-hidden="true"></a>
            <div class="media-body">发出的红包</div>
            <a href="javascript:showMenu()" class="iconfont icon-gengduo text-warning font-weight-bold p-2"
               aria-hidden="true"></a>
        </div>
    </div>
    <div style="height: 46px"></div>
    <div class="bg-light pt-4">
        <img width="66" height="66" class="rounded d-block mx-auto"
             src="{{ $photo->getImgUrl(Auth::user()['avatar'], 132, 132, 0,'avatar') }}"
             alt="会员头像">
        <div class="text-center pt-2">
            <div class="pb-2">{{ Auth::user()['nickname'] }}共发出</div>
            <div class="d-flex align-items-end justify-content-center">
                <div class="font-size-34 line-height-1">{{ $got_balance }}</div>
                <div class="line-height-1 pb-1 font-size-14">{{ cache('config_balance_unit') ?: '元' }}</div>
            </div>
        </div>
    </div>
    <div class="d-flex bg-light qh-border-bottom text-center justify-content-around pt-2 pb-3">
        <div>
            <div class="font-size-20 text-info">{{ $got_jewel }}</div>
            <div class="font-size-12 text-secondary">发出{{ cache('config_jewel_alias') ?: '钻石' }}</div>
        </div>
        <div>
            <div class="font-size-20 text-warning">{{ $got_integral }}</div>
            <div class="font-size-12 text-secondary">发出{{ cache('config_integral_alias') ?: '积分' }}</div>
        </div>
    </div>
    <div class="bg-white px-3" id="items-wrap">
    </div>
    <div class="weui-loadmore d-none" id="items-loading">
        <i class="weui-loading"></i>
        <span class="weui-loadmore__tips text-secondary">正在加载</span>
    </div>
@endsection

@push('scripts')
    <script>
        function showMenu() {
            $.actions({
                actions: [{
                    text: "收到的红包",
                    onClick: function () {
                        window.location.href = "{{ route('plugin-red-packet.get') }}"
                    }
                }, {
                    text: "发出的红包",
                    onClick: function () {
                        window.location.href = "{{ route('plugin-red-packet.got') }}"
                    }
                }]
            });
        }

        var loading = false;
        var page = 0;

        $(function () {
            loadData()
        });

        $(document.body).infinite().on("infinite", loadData);

        function loadData() {
            if (loading) return;
            loading = true;
            $('#items-loading').removeClass('d-none');
            axios.get('{{ route('plugin-red-packet.my-got') }}', {
                params: {page: page}
            }).then(function (response) {
                setTimeout(function () {
                    var data = response.data.data;
                    for (var i in data) {
                        $("#items-wrap").append('<a href="' + data[i].show_url + '" class="media py-2 text-dark qh-border-bottom show-item">\n' +
                            '            <div class="media-body">\n' +
                            '                <div>\n' +
                            '                    <div>' + data[i].type_text + '<small class="ml-2 text-secondary">' + data[i].module_name_text + '</small></div>\n' +
                            '                </div>\n' +
                            '                <div class="font-size-14 text-secondary">' + data[i].created_at + '</div>\n' +
                            '            </div>\n' +
                            '            <div class="text-right">\n' +
                            '                <div>' + data[i].money_type_name + data[i].money_total + data[i].money_type_unit + '</div>\n' +
                            '                <div class="font-size-14 text-secondary">' + data[i].log_count + '/' + data[i].amount + '个</div>\n' +
                            '            </div>\n' +
                            '        </a>');
                    }
                    if (response.data.meta.current_page < response.data.meta.last_page) {
                        page += 1;
                        loading = false;
                        $('#items-loading').addClass('d-none');
                    } else {
                        loading = true;
                        if (page > 1) {
                            $('#items-loading > i').hide();
                            $('#items-loading > span').text('没有更多内容了');
                        } else {
                            $('#items-loading').addClass('d-none');
                        }
                    }
                }, 1000);
            }).cache(function (error) {
                $.toast('读取失败', 'cancel')
            });
        }
    </script>
@endpush