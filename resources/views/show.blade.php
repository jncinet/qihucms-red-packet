@extends('layouts.wap_no_header')

@section('title', '红包详细')

@inject('photo', 'App\Services\PhotoService')
@section('content')
    <div class="fixed-top">
        <div class="media bg-primary align-items-center">
            <a href="javascript:window.history.back();"
               class="iconfont icon-houtuishangyige text-warning font-weight-bold p-2 font-size-20"
               aria-hidden="true"></a>
            <div class="media-body">红包详细</div>
            <a href="javascript:showMenu()" class="iconfont icon-gengduo text-warning font-weight-bold p-2"
               aria-hidden="true"></a>
        </div>
    </div>
    <div style="height: 46px"></div>
    <div class="bg-white mb-2 border-bottom">
        <div class="bg-primary mb-4"
             style="height: 36px; border-bottom: 1px solid rgb(232,267,122); border-radius: 0 0 100% 100%">
        </div>
        <div class="d-flex justify-content-center align-items-center">
            <img width="26" height="26" class="rounded"
                 src="{{ $photo->getImgUrl(Auth::user()['avatar'], 52, 52, 0,'avatar') }}"
                 alt="会员头像">
            <div class="font-size-20 px-2">{{ Auth::user()['nickname'] }}的红包</div>
            <div class="text-white font-size-12 line-height-1 rounded p-1" style="background: rgb(199, 172, 122);">拼
            </div>
        </div>
        <div class="text-center pt-3 pb-4" style="color: rgb(200, 173, 122)">
            <div class="d-flex align-items-end justify-content-center">
                <div class="font-size-34 line-height-1">{{ $red_packet['money_total'] }}</div>
                <div class="line-height-1 pb-1 font-size-14">{{ cache('config_balance_unit') ?: '元' }}</div>
            </div>
            <div class="pt-2 font-size-14">{{ cache('config_'.$red_packet['money_type'].'_alias') }}红包</div>
        </div>
    </div>
    <div class="font-size-14 bg-white px-3 border-top text-secondary d-flex justify-content-between qh-border-bottom py-2">
        <div>共{{ $red_packet['amount'] }}个红包</div>
        <div>已领取{{ $red_packet['log_count'] }}个</div>
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
            $('#items-null').remove();
            if (loading) return;
            loading = true;
            $('#items-loading').removeClass('d-none');
            axios.get('{{ route('plugin-red-packet.my-show', ['id' => $red_packet['id']]) }}', {
                params: {page: page}
            }).then(function (response) {
                setTimeout(function () {
                    var data = response.data.data;
                    for (var i in data) {
                        $("#items-wrap").append('<a href="' + data[i].red_packet.show_url + '" class="media py-2 text-dark qh-border-bottom show-item">\n' +
                            '            <div class="media-body">\n' +
                            '                <div>\n' +
                            '                    <div>' + data[i].to_user.nickname + '<small class="ml-2 text-secondary">' + data[i].red_packet.module_name_text + '</small></div>\n' +
                            '                </div>\n' +
                            '                <div class="font-size-14 text-secondary">' + data[i].created_at + '</div>\n' +
                            '            </div>\n' +
                            '            <div class="text-right">' + data[i].red_packet.money_type_name + '红包' + data[i].red_packet.money_total + data[i].red_packet.money_type_unit + '</div>\n' +
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