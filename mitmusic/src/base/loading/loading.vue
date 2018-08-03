<template>
    <div>
        <div class="loadingWrapper">
            <i class="iconfont icon-jiazai"></i>
        </div>
    </div>
</template>

<script>
    export default {
      name: 'loading'

    }
</script>

<style lang="stylus" scoped>
    @keyframes spin
        from
            transform: rotate(0deg)
        to
            transform: rotate(360deg)
    .loadingWrapper
        width: 40px
        height: 40px
        .icon-jiazai
            font-size: 40px
            color: #666
            animation: spin 1s linear infinite
            width: 100%
            height: 100%
            display: block

</style>