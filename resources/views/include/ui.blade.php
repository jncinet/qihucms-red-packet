<div class="fixed-top red-pack-win" id="red-packet">
    <div class="position-relative w-100">
        <img width="100%" class="d-block img-fluid" src="{{ asset('asset/red-pack-balance.png') }}" alt="红包">
        <div class="position-absolute red-pack-info w-100 h-100 text-center pt-2" onclick="openRedPacket()">
            <img width="46" height="46" class="rounded bg-secondary d-block mx-auto mt-4 mb-2"
                 src="" alt="会员头像">
            <div class="font-size-14 text-warning" id="red-packet-tit">您有一个红包<br>可以领取</div>
            <div class="d-none" id="red-packet-info">
                <div class="text-yellow d-flex justify-content-center align-items-end pt-1 text-shadow">
                    <div class="font-size-26 line-height-1" id="red-packet-amount">234233</div>
                    <div class="line-height-1 font-size-14" style="padding: 0 0 3px 3px;" id="red-packet-unit">元
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3" onclick="closeRedPacket()">
        <div class="red-pack-close mx-auto"></div>
    </div>
</div>