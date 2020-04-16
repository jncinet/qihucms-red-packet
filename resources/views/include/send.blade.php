<div id="send-red-packet" class="weui-popup__container popup-bottom" style="z-index: 2000">
    <div class="weui-popup__overlay"></div>
    <div class="weui-popup__modal">
        <input type="hidden" name="red-packet-module-name" value="{{ $module_name }}">
        <input type="hidden" name="red-packet-module-id" value="{{ $module_id }}">
        <div class="bg-light border-bottom text-center d-flex align-items-center">
            <a class="iconfont icon-houtuishangyige close-popup pl-3 pr-1 py-2 text-dark"
               href="javascript:void(0);"></a>
            <div>发红包</div>
        </div>
        <div class="px-3 pt-3">
            <div class="media bg-white p-3 align-items-center rounded line-height-1">
                <span>红包类型：</span>
                <div class="media-body d-flex justify-content-end">
                    @foreach(__('red_packet::lang.type.value') as $key=>$value)
                        @if(is_array(cache('plugin_RedPacket_types')) && in_array($key, cache('plugin_RedPacket_types')))
                            <label class="ml-2 d-flex align-items-center">
                                <input type="radio" name="red-packet-type" value="{{ $key }}"
                                       @if($key === 'default') checked @endif>
                                <span class="ml-1 font-size-14">{{ $value }}</span>
                            </label>
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="media bg-white p-3 mt-2 align-items-center rounded line-height-1">
                <span>奖金类型：</span>
                <div class="media-body text-right d-flex justify-content-end">
                    @if(is_array(cache('plugin_RedPacket_money_types')) && in_array('balance', cache('plugin_RedPacket_money_types')))
                        <label class="ml-2 d-flex align-items-center">
                            <input type="radio" name="red-packet-type-money" value="balance" checked>
                            <span class="ml-1 font-size-14">{{ Cache::get('config_balance_alias', '余额') }}</span>
                        </label>
                    @endif
                    @if(is_array(cache('plugin_RedPacket_money_types')) && in_array('jewel', cache('plugin_RedPacket_money_types')))
                        <label class="ml-2 d-flex align-items-center">
                            <input type="radio" name="red-packet-type-money" value="jewel">
                            <span class="ml-1 font-size-14">{{ Cache::get('config_jewel_alias', '钻石') }}</span>
                        </label>
                    @endif
                    @if(is_array(cache('plugin_RedPacket_money_types')) && in_array('integral', cache('plugin_RedPacket_money_types')))
                        <label class="ml-2 d-flex align-items-center">
                            <input type="radio" name="red-packet-type-money" value="integral">
                            <span class="ml-1 font-size-14">{{ Cache::get('config_integral_alias', '积分') }}</span>
                        </label>
                    @endif
                </div>
            </div>
            <label class="media bg-white p-3 mt-2 align-items-center rounded line-height-1">
                <span id="red-packet-money-label">单个金额：</span>
                <input class="media-body border-0 bg-transparent text-right" type="text" name="red-packet-money-total"
                       placeholder="0.00" required>
                <span class="pl-2" id="red-packet-money-unit">元</span>
            </label>
            <label class="media bg-white p-3 mt-2 align-items-center rounded line-height-1">
                <span>红包个数：</span>
                <input class="media-body border-0 bg-transparent text-right" type="number" name="red-packet-amount"
                       placeholder="填写个数" required>
                <span class="pl-2">个</span>
            </label>
            <label class="media bg-white p-3 mt-2 align-items-center rounded line-height-1">
                <span>有效期：</span>
                <input class="media-body border-0 bg-transparent text-right" name="red-packet-days" type="number"
                       placeholder="填写天数" required>
                <span class="pl-2">天</span>
            </label>
            @if(Auth::user()['vip_rank'])
                <div class="media bg-white p-3 mt-2 align-items-center rounded line-height-1">
                    <span>领取红包后：</span>
                    <div class="media-body text-right d-flex justify-content-end">
                        @if(is_array(cache('plugin_RedPacket_vip_rules')) && in_array('fans', cache('plugin_RedPacket_vip_rules')))
                            <label class="ml-2 d-flex align-items-center">
                                <input type="radio" name="red-packet-rule" value="fans">
                                <span class="ml-1 font-size-14">关注</span>
                            </label>
                        @endif
                        @if(is_array(cache('plugin_RedPacket_vip_rules')) && in_array('like', cache('plugin_RedPacket_vip_rules')))
                            <label class="ml-2 d-flex align-items-center">
                                <input type="radio" name="red-packet-rule" value="like">
                                <span class="ml-1 font-size-14">点赞</span>
                            </label>
                        @endif
                        @if(is_array(cache('plugin_RedPacket_vip_rules')) && in_array('comment', cache('plugin_RedPacket_vip_rules')))
                            <label class="ml-2 d-flex align-items-center">
                                <input type="radio" name="red-packet-rule" value="comment">
                                <span class="ml-1 font-size-14">回复口令</span>
                            </label>
                        @endif
                    </div>
                </div>
            @else
                <div class="media bg-white p-3 mt-2 align-items-center rounded line-height-1">
                    <span>领取红包后：</span>
                    <div class="media-body text-right d-flex justify-content-end">
                        @if(is_array(cache('plugin_RedPacket_rules')) && in_array('fans', cache('plugin_RedPacket_rules')))
                            <label class="ml-2 d-flex align-items-center">
                                <input type="radio" name="red-packet-rule" value="fans">
                                <span class="ml-1 font-size-14">关注</span>
                            </label>
                        @endif
                        @if(is_array(cache('plugin_RedPacket_rules')) && in_array('like', cache('plugin_RedPacket_rules')))
                            <label class="ml-2 d-flex align-items-center">
                                <input type="radio" name="red-packet-rule" value="like">
                                <span class="ml-1 font-size-14">点赞</span>
                            </label>
                        @endif
                        @if(is_array(cache('plugin_RedPacket_rules')) && in_array('comment', cache('plugin_RedPacket_rules')))
                            <label class="ml-2 d-flex align-items-center">
                                <input type="radio" name="red-packet-rule" value="comment">
                                <span class="ml-1 font-size-14">回复口令</span>
                            </label>
                        @endif
                    </div>
                </div>
            @endif
            <label class="d-none bg-white p-3 mt-2 rounded line-height-1" id="red-packet-comment-msg">
                <input class="d-block border-0 bg-transparent" type="text" name="red-packet-message"
                       placeholder="恭喜发财，大吉大利">
            </label>
        </div>
        <div class="p-3">
            <div class="d-flex justify-content-center align-items-end line-height-1 mb-3">
                <div class="font-size-12 pb-1 text-dark" id="red-packet-settlement-type">¥</div>
                <div class="font-size-34 px-1" id="red-packet-settlement-amount">0.00</div>
                <div class="font-size-12 pb-1 text-secondary" id="red-packet-settlement-unit">元</div>
                <div class="font-size-16 pb-1 px-1 text-danger d-none" id="red-packet-rate-amount">+<span>1</span></div>
                <div class="font-size-12 pb-1 text-secondary d-none" id="red-packet-rate-name">服务费</div>
            </div>
            <button type="button" class="btn btn-block btn-secondary qh-btn-rounded" id="red-packet-submit">塞钱进红包
            </button>
        </div>
    </div>
</div>