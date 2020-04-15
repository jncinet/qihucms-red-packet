<style>
    .red-pack-win {
        left: 0;
        top: 0;
        z-index: 1040;
        margin: 0 auto;
        width: 50vw;
        transform: translate(0, -100%) scale(0);
        transition: all 500ms;
    }

    .red-pack-info {
        left: 0;
        top: 0;
        z-index: 1;
    }

    .text-yellow {
        color: #ff3;
    }

    .red-pack-transition {
        transform: translate(10px, 200px) scale(1);
    }

    .red-pack-close {
        border: 1px solid #fff;
        background: rgba(0, 0, 0, .3);
        position: relative;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        transform: rotate(45deg);
    }

    .red-pack-close:before {
        content: '';
        width: 1px;
        height: 16px;
        background: #fff;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }

    .red-pack-close:after {
        content: '';
        width: 16px;
        height: 1px;
        background: #fff;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        z-index: 1;
    }
</style>