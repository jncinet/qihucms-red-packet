<script>
    // 显示红包窗口
    function showRedPacket() {
        $('#red-packet').addClass('red-pack-transition');
    }

    // 关闭红包窗口
    function closeRedPacket() {
        $('#red-packet').removeClass('red-pack-transition');
        $('#red-packet-info').addClass('d-none');
        $('#red-packet-tit').html('您有一个红包<br>可以领取');
    }

    // 发送请求，读取红包
    function openRedPacket() {
        var tit = $('#red-packet-tit');
        if (tit.text() === '恭喜您获得') return;
        tit.text('恭喜您获得');
        var load = loadRedPacket();
        setTimeout(function () {
            clearInterval(load);
            var amount = 109, unit = '元';
            $('#red-packet-amount').text(amount);
            $('#red-packet-unit').text(unit);
        }, 1500);
    }

    // 红包结果获取前数字跳动
    function loadRedPacket() {
        $('#red-packet-tit').text('正在打开红包');
        $('#red-packet-info').removeClass('d-none');
        return setInterval(function () {
            $('#red-packet-amount').text(Math.round(Math.random() * 1000));
        }, 100);
    }

    function postServier(modules, id) {
        axios.post(this.props.url, {modules, id})
            .then(response => {
                setTimeout(() => {
                    clearInterval(this.timerID);
                    if (response.data.status === 'success') {
                        this.setState({
                            message: '已存入钱包',
                            money: response.data.money,
                            unit: response.data.unit,
                        });
                    } else {
                        this.setState({
                            message: response.data.errors,
                            money: 0,
                            unit: ''
                        });
                    }
                }, 2000);
            })
            .catch(error => {
                clearInterval(this.timerID);
                if (error.response.status === 401) {
                    $.toast('请先登录', 'cancel');
                }
                this.setState({
                    message: '红包怎么打开呢？',
                    money: 0,
                    unit: ''
                });
                console.log('red-packet:', error.response)
            });
    }
</script>