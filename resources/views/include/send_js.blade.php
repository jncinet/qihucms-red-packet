<script>
    $(function () {
        var numberReg = /^[0-9]+.?[0-9]*$/;

        // 会员账户
        var user_balance = {{ Auth::user()['account']['balance'] ?? 0 }};
        var user_jewel = {{ Auth::user()['account']['jewel'] ?? 0 }};
        var user_integral = {{ Auth::user()['account']['integral'] ?? 0 }};

        // 服务费费率
        var red_packet_balance_rate = {{ Cache::get('plugin_RedPacket_balance_fee', 0) }};
        var red_packet_jewel_rate = {{ Cache::get('plugin_RedPacket_jewel_fee', 0) }};
        var red_packet_integral_rate = {{ Cache::get('plugin_RedPacket_integral_fee', 0) }};

        // 计算红包总金额
        function countRedPacketTotalMoney() {
            // *** 红包类型：0.普通红包，1.拼手气红包 *** //
            var redPacketType = $('input[name="red-packet-type"]:checked').val();

            // *** 奖金类型 *** //
            var redPacketTypeMoney = $('input[name="red-packet-type-money"]:checked').val();

            // *** 红包金额 *** //
            var redPacketMoneyTotal = $('input[name="red-packet-money-total"]').val();
            redPacketMoneyTotal = numberReg.test(redPacketMoneyTotal) ? redPacketMoneyTotal : 0;
            redPacketMoneyTotal = redPacketTypeMoney === 'balance'
                ? parseFloat(redPacketMoneyTotal).toFixed(2)
                : parseInt(redPacketMoneyTotal);

            // 拼手气红包，直接输入总金额
            if (redPacketType === "1") {
                return redPacketMoneyTotal;
            }

            // *** 红包个数 *** //
            var redPacketAmount = $('input[name="red-packet-amount"]').val();
            redPacketAmount = numberReg.test(redPacketAmount) ? redPacketAmount : 0;
            redPacketAmount = parseInt(redPacketAmount);

            var total = redPacketMoneyTotal * redPacketAmount;

            // 普通红包
            return redPacketTypeMoney === 'balance' ? parseFloat(total).toFixed(2) : parseInt(total);
        }

        // 计算服务费
        function countRedPacketRate() {
            var money = countRedPacketTotalMoney();
            switch ($('input[name="red-packet-type-money"]:checked').val()) {
                case 'jewel':
                    if (red_packet_jewel_rate > 0) {
                        var jewel = red_packet_jewel_rate * parseInt(money);
                        // 向上取整
                        jewel = Math.ceil(jewel / 100);
                        if (jewel > 0) {
                            $('#red-packet-rate-amount').removeClass('d-none').find('span').text(jewel);
                            $('#red-packet-rate-name').removeClass('d-none');
                            return jewel;
                        }
                    } else {
                        $('#red-packet-rate-amount').addClass('d-none');
                        $('#red-packet-rate-name').addClass('d-none');
                    }
                    break;
                case 'integral':
                    if (red_packet_integral_rate > 0) {
                        var integral = red_packet_integral_rate * parseInt(money);
                        // 向上取整
                        integral = Math.ceil(integral / 100);
                        if (integral > 0) {
                            $('#red-packet-rate-amount').removeClass('d-none').find('span').text(integral);
                            $('#red-packet-rate-name').removeClass('d-none');
                            return integral;
                        }
                    } else {
                        $('#red-packet-rate-amount').addClass('d-none');
                        $('#red-packet-rate-name').addClass('d-none');
                    }
                    break;
                default:
                    if (red_packet_balance_rate > 0) {
                        var balance = red_packet_balance_rate * parseFloat(money);
                        // 向上取整
                        balance = Math.ceil(balance);
                        balance = balance / 100;
                        if (balance > 0) {
                            $('#red-packet-rate-amount').removeClass('d-none').find('span').text(balance);
                            $('#red-packet-rate-name').removeClass('d-none');
                            return balance;
                        }
                    } else {
                        $('#red-packet-rate-amount').addClass('d-none');
                        $('#red-packet-rate-name').addClass('d-none');
                    }
            }
            return 0;
        }

        // 更新实际结算结果
        function setRedPacketSettlementInfo() {
            // 结算奖金类型
            var redPacketSettlementType = $('#red-packet-settlement-type');
            // 结算金额
            $('#red-packet-settlement-amount').text(countRedPacketTotalMoney());
            // 结算奖金单位和金额输入框单位
            var redPacketSettlementUnit = $('#red-packet-settlement-unit,#red-packet-money-unit');
            var totoal_money_field = $('input[name="red-packet-money-total"]');

            switch ($('input[name="red-packet-type-money"]:checked').val()) {
                case "jewel":
                    redPacketSettlementType.text("{{ Cache::get('config_jewel_alias', '钻石') }}");
                    redPacketSettlementUnit.text("{{ Cache::get('config_jewel_unit', '个') }}");
                    if (numberReg.test(totoal_money_field.val())) {
                        totoal_money_field.val(parseInt(totoal_money_field.val()));
                    }
                    totoal_money_field.attr('placeholder', "0");
                    break;
                case "integral":
                    redPacketSettlementType.text("{{ Cache::get('config_integral_alias', '积分') }}");
                    redPacketSettlementUnit.text("{{ Cache::get('config_integral_unit', '分') }}");
                    if (numberReg.test(totoal_money_field.val())) {
                        totoal_money_field.val(parseInt(totoal_money_field.val()));
                    }
                    totoal_money_field.attr('placeholder', "0");
                    break;
                default:
                    redPacketSettlementType.text("¥");
                    redPacketSettlementUnit.text("{{ Cache::get('config_balance_unit', '元') }}");
                    if (numberReg.test(totoal_money_field.val())) {
                        totoal_money_field.val(parseFloat(totoal_money_field.val()).toFixed(2));
                    }
                    totoal_money_field.attr('placeholder', "0.00");
            }
        }

        // 根据红包类型设置提示文字：普通红包=>单个金额，拼手气红包=>总金额
        function updateRedPacketType() {
            if ($('input[name="red-packet-type"]:checked').val() === "1") {
                $('#red-packet-money-label').text("总金额：");
            } else {
                $('#red-packet-money-label').text("单个金额：");
            }
        }

        // 验证账户是否可支付
        function checkRedPacketAmount() {
            // 奖金类型
            var type = $('input[name="red-packet-type-money"]:checked').val(),
                result = true,
                // 实际应付金额 = 总金额 + 服务费
                total_money = parseFloat(countRedPacketTotalMoney()) + countRedPacketRate();

            // 拼手气红包要判断红包金额是否够分配
            if ($('input[name="red-packet-type"]:checked').val() === '1') {
                var money = $('input[name="red-packet-money-total"]').val();
                var amount = $('input[name="red-packet-amount"]').val();

                if (numberReg.test(money) && numberReg.test(amount)) {
                    // 余额红包以分为单
                    if (type === 'balance') {
                        money = parseFloat(money) * 100;
                    }
                    money = parseInt(money);
                    // 最少要得0.01元
                    if (money / amount < 1) {
                        $.toast('红包不够分啦', 'cancel');
                        result = false;
                    }
                }
            }

            if (result) {
                switch (type) {
                    case 'jewel':
                        if (total_money > user_jewel) {
                            $.toast("{{ Cache::get('config_jewel_alias', '钻石') }}不足", 'cancel');
                            result = false;
                        }
                        break;
                    case 'integral':
                        if (total_money > user_integral) {
                            $.toast("{{ Cache::get('config_integral_alias', '积分') }}不足", 'cancel');
                            result = false;
                        }
                        break;
                    default:
                        if (total_money > user_balance) {
                            $.toast("{{ Cache::get('config_balance_alias', '余额') }}不足", 'cancel');
                            result = false;
                        }
                }
            }

            // 更新提交按钮状态
            if (result && total_money > 0) {
                $('#red-packet-submit').removeClass('btn-secondary').addClass('btn-primary');
            } else {
                $('#red-packet-submit').removeClass('btn-primary').addClass('btn-secondary');
            }

            return result;
        }

        // 选择红包类型
        $('input[name="red-packet-type"]').on('change', function () {
            // 更新金额输入框的前缀
            updateRedPacketType();
            // 计算支付额
            setRedPacketSettlementInfo();
            // 验证数值
            checkRedPacketAmount()
        });

        // 选择奖励类型
        $('input[name="red-packet-type-money"]').on('change', function () {
            // 计算支付额
            setRedPacketSettlementInfo();
            // 验证数值
            checkRedPacketAmount()
        });

        // 输入红包金额
        $('input[name="red-packet-money-total"]').on('change', function () {
            if (numberReg.test($(this).val())) {
                if ($('input[name="red-packet-type-money"]:checked').val() === 'balance') {
                    $(this).val(parseFloat($(this).val()).toFixed(2));
                } else {
                    $(this).val(parseInt($(this).val()));
                }
            }
            // 计算支付额
            setRedPacketSettlementInfo();
            // 验证数值
            checkRedPacketAmount()
        });

        // 输入红包个数
        $('input[name="red-packet-amount"]').on('change', function () {
            if (numberReg.test($(this).val())) {
                $(this).val(parseInt($(this).val()));
            }
            // 计算支付额
            setRedPacketSettlementInfo();
            // 验证数值
            checkRedPacketAmount()
        });

        // 选择领取后的条件
        $('input[name="red-packet-rule"]').on('change', function () {
            if ($(this).val() === 'comment') {
                $('#red-packet-comment-msg').removeClass('d-none').addClass('d-block');
            } else {
                $('#red-packet-comment-msg').removeClass('d-block').addClass('d-none');
            }
        });

        $('#red-packet-submit').on('click', function () {
            axios.post("{{ route('plugin-red-packet.store') }}", {
                module_name: $("input[name='red-packet-module-name']").val(),
                module_id: $("input[name='red-packet-module-id']").val(),
                type: $("input[name='red-packet-type']:checked").val(),
                money_type: $("input[name='red-packet-type-money']:checked").val(),
                money_total: $('input[name="red-packet-money-total"]').val(),
                amount: $('input[name="red-packet-amount"]').val(),
                message: $('input[name="red-packet-message"]').val(),
                rule: $("input[name='red-packet-rule']:checked").val(),
                days: $("input[name='red-packet-days']").val(),
            })
                .then(function (response) {
                    $.toast(response.data.message);
                })
                .catch(function (error) {
                    $.toast(error.response.data.message);
                });
        });
    });

    function setModuleId(id) {
        $('input[name="red-packet-module-id"]').val(id);
    }

    function setModuleName(name) {
        $('input[name="red-packet-module-name"]').val(name);
    }
</script>