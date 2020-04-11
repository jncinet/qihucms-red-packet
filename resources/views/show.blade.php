@extends('layouts.wap_no_header')

@section('title', '红包详细')

@inject('photo', 'App\Services\PhotoService')
@section('content')
    <div class="fixed-top">
        <div class="media bg-primary align-items-center">
            <a href="javascript:window.history.back();"
               class="iconfont icon-houtuishangyige text-warning font-weight-bold p-2 font-size-20"
               aria-hidden="true"></a>
            <div class="media-body">收到的红包</div>
            <a href="javascript:showMenu()" class="iconfont icon-gengduo text-warning font-weight-bold p-2"
               aria-hidden="true"></a>
        </div>
    </div>
    <div style="height: 46px"></div>
    <div id="app">
        <div class="bg-light pt-4">
            <img width="66" height="66" class="rounded d-block mx-auto"
                 src="{{ $photo->getImgUrl(Auth::user()['avatar'], 132,132,0,'avatar') }}"
                 alt="会员头像">
            <div class="text-center pt-2">
                <div class="pb-2">{{ Auth::user()['nickname'] }}共收到</div>
                <div class="d-flex align-items-end justify-content-center">
                    <div class="font-size-34 line-height-1">{{ Auth::user()['account']['balance'] }}</div>
                    <div class="line-height-1 pb-1 font-size-14">{{ cache('config_balance_unit') ?: '元' }}</div>
                </div>
            </div>
        </div>
        <div class="d-flex bg-light qh-border-bottom text-center justify-content-around pt-2 pb-3">
            <div>
                <div class="font-size-20 text-info">{{ Auth::user()['account']['jewel'] }}</div>
                <div class="font-size-12 text-secondary">收到{{ cache('config_jewel_alias') ?: '钻石' }}</div>
            </div>
            <div>
                <div class="font-size-20 text-warning">{{ Auth::user()['account']['integral'] }}</div>
                <div class="font-size-12 text-secondary">收到{{ cache('config_integral_alias') ?: '积分' }}</div>
            </div>
        </div>
        <div class="bg-white px-3">
            <div class="media py-2 qh-border-bottom">
                <div class="media-body">
                    <div class="d-flex align-items-center">
                        <div>网友民称网友民称</div>
                    </div>
                    <div class="font-size-14 text-secondary">2分钟前</div>
                </div>
                <div>
                    1.00元
                </div>
            </div>
            <div class="media py-2 qh-border-bottom">
                <div class="media-body">
                    <div class="d-flex align-items-center">
                        <div>网友民称网友民称</div>
                    </div>
                    <div class="font-size-14 text-secondary">2分钟前</div>
                </div>
                <div>
                    1.00元
                </div>
            </div>
            <div class="media py-2 qh-border-bottom">
                <div class="media-body">
                    <div class="d-flex align-items-center">
                        <div>网友民称网友民称</div>
                    </div>
                    <div class="font-size-14 text-secondary">2分钟前</div>
                </div>
                <div>
                    1.00元
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script>
        new Vue({
            el: '#app',
            data: {
                items: [
                    ''
                ],
                message: 'Hello Vue!'
            }
        });

        function showMenu() {
            $.actions({
                actions: [{
                    text: "收到的红包",
                    onClick: function () {
                        window.location.href = "{{ route('red-packet.get') }}"
                    }
                }, {
                    text: "发出的红包",
                    onClick: function () {
                        window.location.href = "{{ route('red-packet.got') }}"
                    }
                }]
            });
        }
    </script>
@endpush